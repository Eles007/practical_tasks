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
    </div>
</x-layouts>
