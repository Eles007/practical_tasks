<x-layouts :title="'Отзывы — ' . $user->fio">
    <div class="row justify-content-center mt-4">
        <div class="col-lg-8">

            <div class="mb-4">
                <a href="{{ url()->previous() }}" class="text-muted text-decoration-none small">← Назад</a>
                <h2 class="fw-bold mt-2">Отзывы автора</h2>
                <p class="text-muted mb-0">{{ $user->fio }}</p>
            </div>

            @forelse($reviews as $review)
                <div class="card mb-3 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h6 class="fw-bold mb-0">{{ $review->title }}</h6>
                            <span class="text-muted small">{{ $review->created_at->format('d.m.Y') }}</span>
                        </div>

                        <p class="mb-2">{{ $review->description }}</p>

                        <div class="d-flex align-items-center gap-2 flex-wrap">
                            <span class="text-warning">{{ str_repeat('⭐', $review->rating) }}</span>
                            @if($review->cities->isEmpty())
                                <span class="badge bg-secondary">Все города</span>
                            @else
                                @foreach($review->cities as $city)
                                    <span class="badge bg-warning text-dark">{{ $city->name }}</span>
                                @endforeach
                            @endif
                        </div>

                        @if($review->img)
                            <img src="{{ asset('storage/' . $review->img) }}" class="img-fluid rounded mt-2" style="max-height:160px" alt="фото">
                        @endif
                    </div>
                </div>
            @empty
                <div class="text-muted text-center py-5">У этого автора пока нет отзывов.</div>
            @endforelse

        </div>
    </div>
</x-layouts>
