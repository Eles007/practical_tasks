<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReviewRequest;
use App\Models\City;
use App\Models\Review;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class ReviewController extends Controller
{
    protected string $dadataApiKey;

    public function __construct()
    {
        $this->dadataApiKey = config('services.dadata.key');
    }

    public function create()
    {
        return view('reviews.create');
    }

    public function store(StoreReviewRequest $request): JsonResponse
    {
        $img = $request->hasFile('img')
            ? $request->file('img')->store('reviews', 'public')
            : null;

        $review = Review::create([
            'title'       => $request->title,
            'description' => $request->description,
            'rating'      => $request->rating,
            'img'         => $img,
            'user_id'     => auth()->id(),
        ]);

        $this->syncCities($review, $request->input('cities', []));

        return response()->json($review->load('cities'), 201);
    }

    public function edit(Review $review): JsonResponse
    {
        abort_if($review->user_id !== auth()->id(), 403);

        return response()->json($review->load('cities'));
    }

    public function update(Request $request, Review $review): JsonResponse
    {
        abort_if($review->user_id !== auth()->id(), 403);

        $request->validate([
            'title'       => 'required|string|max:100',
            'description' => 'required|string|max:255',
            'rating'      => 'required|integer|min:1|max:5',
            'img'         => 'nullable|image|mimes:jpg,png,jpeg,gif,svg|max:5120',
            'cities'      => 'nullable|array',
            'cities.*'    => 'string|max:100',
        ]);

        if ($request->hasFile('img')) {
            if ($review->img) Storage::disk('public')->delete($review->img);
            $review->img = $request->file('img')->store('reviews', 'public');
        }

        $review->update($request->only('title', 'description', 'rating', 'img'));
        $this->syncCities($review, $request->input('cities', []));

        return response()->json($review->load('cities'));
    }

    public function destroy(Review $review): JsonResponse
    {
        abort_if($review->user_id !== auth()->id(), 403);

        if ($review->img) Storage::disk('public')->delete($review->img);
        $review->cities()->detach();
        $review->delete();

        return response()->json(['success' => true]);
    }

    public function cityAutoComplete(Request $request): JsonResponse
    {
        $query = $request->query('query');

        if (empty($query)) {
            return response()->json([]);
        }

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Token ' . $this->dadataApiKey,
                'Content-Type'  => 'application/json',
                'Accept'        => 'application/json',
            ])->post('https://suggestions.dadata.ru/suggestions/api/4_1/rs/suggest/address', [
                'query'      => $query,
                'count'      => 5,
                'from_bound' => ['value' => 'city'],
                'to_bound'   => ['value' => 'city'],
            ]);

            if ($response->successful()) {
                $cities = collect($response->json('suggestions'))
                    ->filter(fn($item) => !empty($item['data']['city']))
                    ->map(fn($item) => ['name' => $item['data']['city']])
                    ->unique('name')
                    ->values();

                return response()->json($cities);
            }

            return response()->json([], 500);
        } catch (\Exception $e) {
            return response()->json([], 500);
        }
    }

    private function syncCities(Review $review, array $cityNames): void
    {
        if (empty($cityNames)) {
            $review->cities()->sync(City::pluck('id'));
        } else {
            $cityIds = collect($cityNames)
                ->map(fn($name) => City::firstOrCreate(['name' => $name])->id);
            $review->cities()->sync($cityIds);
        }
    }
}
