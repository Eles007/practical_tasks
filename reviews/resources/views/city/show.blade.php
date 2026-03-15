<x-layouts>
    {{-- Прелоадер --}}
    <div id="preloader" class="d-none position-fixed top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center"
         style="background:rgba(255,255,255,.6);z-index:9999">
        <div class="spinner-border text-warning" role="status"></div>
    </div>

    {{-- Модалка автора --}}
    <div class="modal fade" id="authorModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <h5 class="modal-title fw-bold" id="authorName"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body pt-0">
                    <p class="mb-1 text-muted"><span class="fw-semibold text-dark">Email:</span> <span id="authorEmail"></span></p>
                    <p class="mb-3 text-muted"><span class="fw-semibold text-dark">Телефон:</span> <span id="authorPhone"></span></p>
                    <a id="authorReviewsLink" href="#" class="btn btn-outline-warning w-100">Все отзывы автора</a>
                </div>
            </div>
        </div>
    </div>

    {{-- Модалка редактирования --}}
    <div class="modal fade" id="editModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <h5 class="modal-title fw-bold">Редактировать отзыв</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="edit-form" enctype="multipart/form-data" novalidate>
                        @csrf
                        <input type="hidden" id="edit-review-id">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Заголовок</label>
                            <input type="text" name="title" id="edit-title" class="form-control" required maxlength="100">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Текст отзыва</label>
                            <textarea name="description" id="edit-description" class="form-control" rows="3" required maxlength="255"></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Рейтинг</label>
                            <select name="rating" id="edit-rating" class="form-select" required>
                                @for($i = 1; $i <= 5; $i++)
                                    <option value="{{ $i }}">{{ str_repeat('⭐', $i) }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Города <span class="text-muted fw-normal small">— не выбрано = все города</span></label>
                            <div class="position-relative">
                                <input type="text" id="edit-city-search" class="form-control" placeholder="Начните вводить город...">
                                <ul id="edit-city-suggestions" class="list-group position-absolute w-100 shadow-sm d-none" style="top:100%;z-index:10"></ul>
                            </div>
                            <div id="edit-selected-cities" class="d-flex flex-wrap gap-2 mt-2"></div>
                            <div id="edit-cities-hidden-inputs"></div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Новое фото <span class="text-muted fw-normal small">(необязательно)</span></label>
                            <input type="file" name="img" id="edit-img" class="form-control" accept="image/*">
                        </div>
                        <div id="edit-alert" class="alert d-none"></div>
                        <button type="submit" class="btn btn-warning w-100 fw-bold">Сохранить</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center mt-4">
        <div class="col-lg-8">

            <div class="text-center mb-5">
                <h1 class="fw-bold">{{ $city }}</h1>
                <p class="text-muted">Средний рейтинг 4.3 ⭐</p>
            </div>

            @forelse($reviews as $review)
                <div class="card mb-3 shadow-sm" id="review-card-{{ $review->id }}">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-1">
                            @auth
                                <button class="btn btn-link p-0 fw-bold text-dark text-decoration-none author-btn"
                                        data-id="{{ $review->user->id }}"
                                        data-fio="{{ $review->user->fio }}"
                                        data-email="{{ $review->user->email }}"
                                        data-phone="{{ $review->user->phone }}">
                                    {{ $review->user->fio }}
                                </button>
                            @else
                                <span class="fw-bold">{{ $review->user->fio }}</span>
                            @endauth
                            <span class="text-muted small">{{ $review->created_at->format('d.m.Y') }}</span>
                        </div>

                        <p class="mb-2">{{ $review->description }}</p>
                        <div class="mb-2 text-warning">{{ str_repeat('⭐', $review->rating) }}</div>

                        @if($review->img)
                            <img src="{{ asset('storage/' . $review->img) }}" class="img-fluid rounded mb-2" style="max-height:200px" alt="фото отзыва">
                        @endif

                        @auth
                            @if(auth()->id() === $review->user_id)
                                <div class="d-flex gap-2 mt-2">
                                    <button class="btn btn-sm btn-outline-secondary edit-btn"
                                            data-id="{{ $review->id }}"
                                            data-title="{{ $review->title }}"
                                            data-description="{{ $review->description }}"
                                            data-rating="{{ $review->rating }}"
                                            data-cities="{{ $review->cities->pluck('name')->join(',') }}">
                                        Редактировать
                                    </button>
                                    <button class="btn btn-sm btn-outline-danger delete-btn" data-id="{{ $review->id }}">
                                        Удалить
                                    </button>
                                </div>
                            @endif
                        @endauth
                    </div>
                </div>
            @empty
                <p class="text-muted text-center">Отзывов пока нет.</p>
            @endforelse

            <div class="text-center mt-4">
                @auth
                    <a href="{{ route('reviews.create') }}" class="btn btn-warning fw-bold px-5">Написать отзыв</a>
                @else
                    <p class="text-muted">
                        <a href="{{ route('login') }}" class="text-warning fw-semibold text-decoration-none">Войдите</a>
                        или
                        <a href="{{ route('register') }}" class="text-warning fw-semibold text-decoration-none">зарегистрируйтесь</a>,
                        чтобы оставить отзыв.
                    </p>
                @endauth
            </div>

        </div>
    </div>

    <script>
        const CSRF = document.querySelector('meta[name="csrf-token"]').content;
        const AUTOCOMPLETE_URL = '{{ route("cities.autocomplete") }}';

        // --- Прелоадер ---
        const preloader = document.getElementById('preloader');
        function showLoader() { preloader.classList.remove('d-none'); preloader.classList.add('d-flex'); }
        function hideLoader() { preloader.classList.add('d-none'); preloader.classList.remove('d-flex'); }

        // --- Модалка автора ---
        @auth
        document.querySelectorAll('.author-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                document.getElementById('authorName').textContent = btn.dataset.fio;
                document.getElementById('authorEmail').textContent = btn.dataset.email;
                document.getElementById('authorPhone').textContent = btn.dataset.phone;
                document.getElementById('authorReviewsLink').href = `/users/${btn.dataset.id}/reviews`;
                new bootstrap.Modal(document.getElementById('authorModal')).show();
            });
        });
        @endauth

        // --- Удаление ---
        document.querySelectorAll('.delete-btn').forEach(btn => {
            btn.addEventListener('click', async () => {
                if (!confirm('Удалить отзыв?')) return;
                showLoader();
                const res = await fetch(`/reviews/${btn.dataset.id}`, {
                    method: 'DELETE',
                    headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' },
                });
                hideLoader();
                if (res.ok) {
                    document.getElementById(`review-card-${btn.dataset.id}`)?.remove();
                }
            });
        });

        // --- Редактирование: открытие модалки ---
        const editSelectedCities = [];

        document.querySelectorAll('.edit-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                const id = btn.dataset.id;
                document.getElementById('edit-review-id').value = id;
                document.getElementById('edit-title').value = btn.dataset.title;
                document.getElementById('edit-description').value = btn.dataset.description;
                document.getElementById('edit-rating').value = btn.dataset.rating;

                // Сброс городов
                editSelectedCities.length = 0;
                document.getElementById('edit-selected-cities').innerHTML = '';
                document.getElementById('edit-cities-hidden-inputs').innerHTML = '';

                const cities = btn.dataset.cities ? btn.dataset.cities.split(',') : [];
                cities.filter(Boolean).forEach(name => addEditCity(name));

                document.getElementById('edit-alert').classList.add('d-none');
                new bootstrap.Modal(document.getElementById('editModal')).show();
            });
        });

        // --- Редактирование: отправка ---
        document.getElementById('edit-form').addEventListener('submit', async (e) => {
            e.preventDefault();
            const id = document.getElementById('edit-review-id').value;
            const form = e.target;
            const alertEl = document.getElementById('edit-alert');
            const btn = form.querySelector('button[type="submit"]');

            showLoader();
            btn.disabled = true;

            const formData = new FormData(form);
            formData.append('_method', 'PUT');

            const res = await fetch(`/reviews/${id}`, {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' },
                body: formData,
            });

            hideLoader();
            btn.disabled = false;

            const data = await res.json();
            alertEl.classList.remove('d-none', 'alert-success', 'alert-danger');

            if (res.ok) {
                alertEl.classList.add('alert-success');
                alertEl.textContent = 'Отзыв обновлён!';
                setTimeout(() => location.reload(), 800);
            } else {
                alertEl.classList.add('alert-danger');
                alertEl.textContent = data.errors ? Object.values(data.errors).flat().join(' ') : 'Ошибка';
            }
        });

        // --- Автокомплит городов (редактирование) ---
        function makeAutocomplete(inputId, suggestionsId, addFn) {
            const input = document.getElementById(inputId);
            const list = document.getElementById(suggestionsId);
            let timer;

            input.addEventListener('input', () => {
                clearTimeout(timer);
                const q = input.value.trim();
                if (q.length < 2) { list.classList.add('d-none'); return; }
                timer = setTimeout(async () => {
                    const res = await fetch(`${AUTOCOMPLETE_URL}?query=${encodeURIComponent(q)}`);
                    const data = await res.json();
                    list.innerHTML = '';
                    if (!data.length) { list.classList.add('d-none'); return; }
                    data.forEach(city => {
                        const li = document.createElement('li');
                        li.className = 'list-group-item list-group-item-action';
                        li.style.cursor = 'pointer';
                        li.textContent = city.name;
                        li.addEventListener('mousedown', (e) => { e.preventDefault(); addFn(city.name); input.value = ''; list.classList.add('d-none'); });
                        list.appendChild(li);
                    });
                    list.classList.remove('d-none');
                }, 300);
            });

            document.addEventListener('click', e => {
                if (!e.target.closest(`#${inputId}`) && !e.target.closest(`#${suggestionsId}`)) {
                    list.classList.add('d-none');
                }
            });
        }

        function addEditCity(name) {
            if (editSelectedCities.includes(name)) return;
            editSelectedCities.push(name);

            const badge = document.createElement('span');
            badge.className = 'badge bg-warning text-dark fs-6 fw-normal d-flex align-items-center gap-2 px-3 py-2';
            badge.innerHTML = `${name}<button type="button" class="btn-close" style="font-size:.55rem"></button>`;
            badge.querySelector('button').addEventListener('click', () => {
                editSelectedCities.splice(editSelectedCities.indexOf(name), 1);
                badge.remove();
                document.querySelector(`#edit-cities-hidden-inputs [data-city="${name}"]`)?.remove();
            });
            document.getElementById('edit-selected-cities').appendChild(badge);

            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'cities[]';
            input.value = name;
            input.dataset.city = name;
            document.getElementById('edit-cities-hidden-inputs').appendChild(input);
        }

        makeAutocomplete('edit-city-search', 'edit-city-suggestions', addEditCity);
    </script>
</x-layouts>
