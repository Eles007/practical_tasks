<x-layouts title="Новый отзыв">
    <div class="row justify-content-center mt-5">
        <div class="col-lg-7">

            <div class="mb-4">
                <a href="{{ url()->previous() }}" class="text-muted text-decoration-none small">← Назад</a>
                <h2 class="fw-bold mt-2">Новый отзыв</h2>
                <p class="text-muted">Поделитесь своим опытом. Если не выбрать город — отзыв будет виден во всех
                    городах.</p>
            </div>

            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <form action="{{route('reviews.store')}}" id="review-form" enctype="multipart/form-data" novalidate>
                        @csrf

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Заголовок</label>
                            <input type="text" name="title" class="form-control" placeholder="Кратко о чём отзыв"
                                   required maxlength="100">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Текст отзыва</label>
                            <textarea name="description" class="form-control" rows="4"
                                      placeholder="Расскажите подробнее..." required maxlength="255"></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Рейтинг</label>
                            <select name="rating" class="form-select" required>
                                <option value="">Выберите оценку</option>
                                @for($i = 1; $i <= 5; $i++)
                                    <option value="{{ $i }}">{{ str_repeat('⭐', $i) }}</option>
                                @endfor
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                Города
                                <span class="text-muted fw-normal small ms-1">— не выбрано = все города</span>
                            </label>
                            <div class="position-relative">
                                <input type="text" id="city-search" class="form-control"
                                       placeholder="Начните вводить название города...">
                                <ul id="city-suggestions" class="list-group position-absolute w-100 shadow-sm d-none"
                                    style="top:100%;z-index:10"></ul>
                            </div>
                            <div id="selected-cities" class="d-flex flex-wrap gap-2 mt-2"></div>
                            <div id="cities-hidden-inputs"></div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold">Фото <span class="text-muted fw-normal small">(скан отзыва, необязательно)</span></label>
                            <input type="file" name="img" id="img-input" class="form-control" accept="image/*">
                            <div id="img-preview" class="mt-2 d-none">
                                <img id="img-preview-src" src="" class="rounded border" style="max-height:160px"
                                     alt="превью">
                            </div>
                        </div>

                        <div id="review-alert" class="alert d-none"></div>

                        <button type="submit" class="btn btn-warning w-100 fw-bold py-2">Отправить отзыв</button>
                    </form>
                </div>
            </div>

        </div>
    </div>

    <script>
        const AUTOCOMPLETE_URL = '{{ route("cities.autocomplete") }}';
        const STORE_URL = '{{ route("reviews.store") }}';
        const CSRF = document.querySelector('meta[name="csrf-token"]').content;

        // --- Превью фото ---
        document.getElementById('img-input').addEventListener('change', function () {
            const file = this.files[0];
            const preview = document.getElementById('img-preview');
            const previewSrc = document.getElementById('img-preview-src');
            if (file) {
                previewSrc.src = URL.createObjectURL(file);
                preview.classList.remove('d-none');
            } else {
                preview.classList.add('d-none');
            }
        });

        // --- Автокомплит городов ---
        const searchInput = document.getElementById('city-search');
        const suggestionsList = document.getElementById('city-suggestions');
        const selectedCitiesDiv = document.getElementById('selected-cities');
        const hiddenInputsDiv = document.getElementById('cities-hidden-inputs');
        const selectedCities = [];

        let debounceTimer;
        searchInput.addEventListener('input', () => {
            clearTimeout(debounceTimer);
            const q = searchInput.value.trim();
            if (q.length < 2) { suggestionsList.classList.add('d-none'); return; }
            debounceTimer = setTimeout(() => fetchSuggestions(q), 300);
        });

        async function fetchSuggestions(q) {
            const res = await fetch(`${AUTOCOMPLETE_URL}?query=${encodeURIComponent(q)}`);
            const data = await res.json();
            suggestionsList.innerHTML = '';
            if (!data.length) { suggestionsList.classList.add('d-none'); return; }
            data.forEach(city => {
                const li = document.createElement('li');
                li.className = 'list-group-item list-group-item-action';
                li.style.cursor = 'pointer';
                li.textContent = city.name;
                li.addEventListener('mousedown', (e) => { e.preventDefault(); addCity(city.name); });
                suggestionsList.appendChild(li);
            });
            suggestionsList.classList.remove('d-none');
        }

        function addCity(name) {
            if (selectedCities.includes(name)) { closeSuggestions(); return; }
            selectedCities.push(name);

            const badge = document.createElement('span');
            badge.className = 'badge bg-warning text-dark fs-6 fw-normal d-flex align-items-center gap-2 px-3 py-2';
            badge.innerHTML = `${name}<button type="button" class="btn-close" style="font-size:.55rem" aria-label="Удалить"></button>`;
            badge.querySelector('button').addEventListener('click', () => removeCity(name, badge));
            selectedCitiesDiv.appendChild(badge);

            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'cities[]';
            input.value = name;
            input.dataset.city = name;
            hiddenInputsDiv.appendChild(input);

            closeSuggestions();
        }

        function removeCity(name, badge) {
            selectedCities.splice(selectedCities.indexOf(name), 1);
            badge.remove();
            hiddenInputsDiv.querySelector(`[data-city="${name}"]`)?.remove();
        }

        function closeSuggestions() {
            searchInput.value = '';
            suggestionsList.classList.add('d-none');
        }

        document.addEventListener('click', e => {
            if (!e.target.closest('#city-search') && !e.target.closest('#city-suggestions')) {
                suggestionsList.classList.add('d-none');
            }
        });

        // --- Прелоадер ---
        const preloader = document.getElementById('preloader');
        function showLoader() { preloader.classList.remove('d-none'); preloader.classList.add('d-flex'); }
        function hideLoader() { preloader.classList.add('d-none'); preloader.classList.remove('d-flex'); }

        // --- Отправка формы ---
        document.getElementById('review-form').addEventListener('submit', async (e) => {
            e.preventDefault();
            const form = e.target;
            const alertEl = document.getElementById('review-alert');
            const btn = form.querySelector('button[type="submit"]');

            btn.disabled = true;
            btn.textContent = 'Отправка...';
            showLoader();

            const res = await fetch(STORE_URL, {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': CSRF },
                body: new FormData(form),
            });

            const data = await res.json();
            alertEl.classList.remove('d-none', 'alert-success', 'alert-danger');

            if (res.ok) {
                alertEl.classList.add('alert-success');
                alertEl.textContent = 'Отзыв успешно добавлен!';
                form.reset();
                selectedCities.length = 0;
                selectedCitiesDiv.innerHTML = '';
                hiddenInputsDiv.innerHTML = '';
                document.getElementById('img-preview').classList.add('d-none');
            } else {
                alertEl.classList.add('alert-danger');
                alertEl.textContent = data.errors
                    ? Object.values(data.errors).flat().join(' ')
                    : 'Ошибка при отправке';
            }

            hideLoader();
            btn.disabled = false;
            btn.textContent = 'Отправить отзыв';
        });
    </script>
</x-layouts>
