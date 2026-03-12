<x-layouts>
    <div class="row">
        <div class="col-8 ">
            <div class="card shadow-sm mt-2">
                <div class="card-body">
                    <h4 class="mb-4">Список городов</h4>

                    <div class="d-flex flex-column gap-2">
                        @foreach($cities as $city)
                            <form action="{{ route('city.confirm', $city->name) }}" method="post">
                                @csrf
                                <button type="submit"
                                        class="btn btn-outline-secondary text-start w-100">{{ $city->name }}</button>
                            </form>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="card shadow-sm mt-2">
                <div class="card-body text-center">
                    <h5 class="mb-3">Хотите оставить отзыв?</h5>
                    <!--  <a href="#" class="btn btn-warning w-100 mb-2">Создать отзыв</a> !-->
                    <a href="#" class="fw-semibold text-decoration-none text-muted">Войдите</a>
                    или
                    <a href="$" class="fw-semibold text-decoration-none text-muted">зарегистрируйтесь</a>,
                    чтобы оставить отзыв
                </div>
            </div>
        </div>
    </div>
</x-layouts>
