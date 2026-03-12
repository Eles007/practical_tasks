<x-layouts>
    <div class="row p-4 pb-0 pe-lg-0 pt-lg-5 align-items-center rounded-3 border shadow-lg">
        <div class="col-lg-4 p-0 overflow-hidden">
            <img class="rounded-lg-3" src="{{asset('storage/hero_city.png')}}" alt=""
                 width="720">
        </div>
        <div class="col-lg-1"></div>
        <div class="col-lg-6 p-3 p-lg-5 pt-lg-3 ps-lg-5">
            <h1 class="display-5 fw-bold">Здравствуйте 👋</h1>
            <p class="lead">{{$data['city']}} ваш город ?</p>
            <div class="d-flex flex-wrap gap-2 mt-4">
                <a href="/cities" class="btn btn-outline-secondary btn-lg px-4">Нет</a>
                <form action="{{route('city.confirm', $data['city'])}}" method="post">
                    @csrf
                    <button type="submit" class="btn btn-warning btn-lg px-5 me-md-2 fw-bold">Да</button>
                </form>
            </div>
        </div>
    </div>
</x-layouts>
