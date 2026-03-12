<x-layouts>
    <div class="row justify-content-center mt-4">
        <div class="col-lg-8">

            <div class="text-center mb-5">
                <h1 class="fw-bold">{{$city}}</h1>
                <p class="text-muted">Средний рейтинг 4.3 ⭐</p>
            </div>

            @foreach($reviews as $review)
                <div class="card mb-3">
                    <div class="card-body">
                        <h6 class="fw-bold">{{ $review->user->fio }}</h6>
                        <p>{{ $review->description }}</p>
                    </div>
                </div>
            @endforeach

            <div class="card mt-4">
                <div class="card-body">
                    <h5 class="mb-3">Добавить отзыв</h5>
                    <textarea class="form-control mb-3" rows="3"></textarea>
                    <button class="btn btn-warning w-100">Отправить</button>
                </div>
            </div>

        </div>
    </div>
</x-layouts>
