<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AppLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('header', null, []); ?> 
        <div class="flex flex-col gap-1">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <?php if(isset($city)): ?>
                    Отзывы: <?php echo e($city->name); ?>

                <?php else: ?>
                    Выбор города
                <?php endif; ?>
            </h2>

            <p class="text-sm text-gray-500">
                <?php if(isset($city)): ?>
                    Вы можете сменить город и посмотреть другие отзывы.
                <?php else: ?>
                    Подтвердите авто-определение или выберите город вручную.
                <?php endif; ?>
            </p>
        </div>
     <?php $__env->endSlot(); ?>

    <div class="min-h-[calc(100vh-4rem)] bg-gradient-to-br from-blue-50 via-white to-indigo-50 dark:from-[#0f172a] dark:via-[#0b1120] dark:to-[#020617] py-10">
        <div class="max-w-7xl mx-auto px-6">
            <?php if(isset($city)): ?>
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">
                    <div class="lg:col-span-2">
                        <div class="bg-white/80 dark:bg-[#0f172a]/80 backdrop-blur-xl rounded-3xl shadow-2xl border border-white/40 dark:border-white/5 overflow-hidden">
                            <div class="p-6 sm:p-8 border-b border-white/40 dark:border-white/5">
                                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                                    <div class="space-y-1">
                                        <div class="text-sm text-gray-500 dark:text-gray-300">
                                            Выбранный город
                                        </div>
                                        <div class="text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                                            <?php echo e($city->name); ?>

                                        </div>
                                    </div>

                                    <a href="<?php echo e(route('home')); ?>#cities"
                                       class="inline-flex items-center justify-center px-6 py-2.5 rounded-2xl
                                           bg-gray-900/5 dark:bg-white/10
                                           hover:bg-gray-900/10 dark:hover:bg-white/15
                                           transition font-medium text-gray-800 dark:text-gray-100">
                                        Сменить город
                                    </a>
                                </div>
                            </div>

                            <div class="p-6 sm:p-8">
                                <?php if(($reviews ?? collect())->isEmpty()): ?>
                                    <div class="rounded-3xl border border-white/40 dark:border-white/5 bg-white/60 dark:bg-white/5 p-8 text-center">
                                        <div class="text-lg font-semibold text-gray-900 dark:text-white">
                                            Пока нет отзывов
                                        </div>
                                        <div class="mt-2 text-sm text-gray-500 dark:text-gray-300">
                                            Для города <?php echo e($city->name); ?> ещё не добавили отзывы.
                                        </div>
                                    </div>
                                <?php else: ?>
                                    <div class="grid grid-cols-1 gap-4">
                                        <?php $__currentLoopData = $reviews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $review): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="rounded-3xl border border-white/40 dark:border-white/5 bg-white/70 dark:bg-white/5 p-6">
                                                <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-3">
                                                    <div class="min-w-0">
                                                        <div class="text-lg font-semibold text-gray-900 dark:text-white truncate">
                                                            <?php echo e($review->title); ?>

                                                        </div>
                                                        <div class="mt-1 text-sm text-gray-500 dark:text-gray-300">
                                                            Автор: <?php echo e($review->user?->name ?? '—'); ?>

                                                        </div>
                                                    </div>

                                                    <div class="shrink-0">
                                                        <div class="inline-flex items-center gap-2 rounded-2xl px-4 py-2 bg-gray-900/5 dark:bg-white/10">
                                                            <span class="text-sm font-bold text-gray-900 dark:text-white">
                                                                <?php echo e($review->rating); ?>/5
                                                            </span>
                                                            <span class="text-xs text-gray-500 dark:text-gray-300">
                                                                рейтинг
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="mt-4 text-gray-700 dark:text-gray-100 leading-relaxed">
                                                    <?php echo e($review->text); ?>

                                                </div>
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <aside class="lg:col-span-1">
                        <div class="bg-white/80 dark:bg-[#0f172a]/80 backdrop-blur-xl rounded-3xl shadow-2xl border border-white/40 dark:border-white/5 p-6 sm:p-8 space-y-4">
                            <div class="text-lg font-semibold text-gray-900 dark:text-white">
                                Действия
                            </div>

                            <div class="grid grid-cols-1 gap-3">
                                <a href="<?php echo e(route('home')); ?>#cities"
                                   class="w-full inline-flex items-center justify-center px-6 py-3 rounded-2xl
                                       bg-gradient-to-r from-blue-600 to-indigo-600
                                       hover:from-blue-700 hover:to-indigo-700
                                       text-white font-semibold transition shadow-lg hover:shadow-blue-500/40">
                                    Выбрать другой город
                                </a>
                            </div>
                        </div>
                    </aside>
                </div>
            <?php else: ?>
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">
                    <div class="lg:col-span-2 space-y-6">
                        <div class="bg-white/80 dark:bg-[#0f172a]/80 backdrop-blur-xl rounded-3xl shadow-2xl border border-white/40 dark:border-white/5 p-6 sm:p-10">
                            <div class="space-y-3">
                                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-600/10 dark:bg-white/10 text-blue-700 dark:text-blue-200 text-sm font-medium">
                                    Быстрый выбор
                                </div>

                                <h1 class="text-3xl sm:text-4xl font-bold tracking-tight text-gray-900 dark:text-white">
                                    Выберите город и получите релевантные отзывы
                                </h1>

                                <p class="text-gray-600 dark:text-gray-300 leading-relaxed max-w-2xl">
                                    Мы попробовали определить город автоматически. Если не угадали — выберите вручную ниже.
                                </p>
                            </div>
                        </div>

                        <?php if(isset($detectedCity)): ?>
                            <div class="relative overflow-hidden rounded-3xl
                                bg-white/80 backdrop-blur-xl
                                dark:bg-[#0f172a]/80
                                border border-white/40 dark:border-white/5
                                shadow-2xl p-6 sm:p-10 text-center space-y-8">

                                <div class="absolute -top-20 -right-20 w-72 h-72 rounded-full bg-blue-200/40 dark:bg-blue-900/20 blur-3xl"></div>

                                <div class="flex justify-center relative">
                                    <div class="w-24 h-24 rounded-2xl
                                        bg-gradient-to-br from-blue-500 to-indigo-500
                                        flex items-center justify-center
                                        shadow-lg">
                                        <svg class="w-12 h-12 text-white"
                                             fill="none" viewBox="0 0 24 24"
                                             stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                        </svg>
                                    </div>
                                </div>

                                <div class="space-y-4 relative">
                                    <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white">
                                        Ваш город — <?php echo e($detectedCity->name); ?>?
                                    </h2>

                                    <p class="text-gray-500 dark:text-gray-300 leading-relaxed">
                                        Подтвердите выбор или перейдите к списку городов.
                                    </p>
                                </div>

                                <form method="POST" action="<?php echo e(route('select.city')); ?>"
                                      class="flex flex-col sm:flex-row justify-center gap-4 relative">
                                    <?php echo csrf_field(); ?>
                                    <input type="hidden" name="city_id" value="<?php echo e($detectedCity->id); ?>">

                                    <button class="w-full sm:w-auto px-9 py-3 rounded-2xl
                                        bg-gradient-to-r from-blue-600 to-indigo-600
                                        hover:from-blue-700 hover:to-indigo-700
                                        text-white font-semibold
                                        transition-all duration-300
                                        shadow-lg hover:shadow-blue-500/40
                                        hover:-translate-y-1
                                        active:scale-95">
                                        Да, это мой город
                                    </button>

                                    <a href="#cities"
                                       class="w-full sm:w-auto px-9 py-3 rounded-2xl
                                           bg-gray-900/5 dark:bg-white/10
                                           hover:bg-gray-900/10 dark:hover:bg-white/15
                                           text-gray-700 dark:text-gray-200
                                           font-medium transition">
                                        Выбрать вручную
                                    </a>
                                </form>
                            </div>
                        <?php endif; ?>
                    </div>

                    <aside class="lg:col-span-1">
                        <div class="bg-white/80 dark:bg-[#0f172a]/80 backdrop-blur-xl rounded-3xl shadow-2xl border border-white/40 dark:border-white/5 p-6 sm:p-8 space-y-5">
                            <div>
                                <div class="text-lg font-semibold text-gray-900 dark:text-white">
                                    Поиск по городам
                                </div>
                                <div class="mt-2 text-sm text-gray-500 dark:text-gray-300">
                                    Введите название — список отфильтруется.
                                </div>
                            </div>

                            <input id="city-search"
                                   type="text"
                                   placeholder="Например: Москва"
                                   class="w-full rounded-2xl border-white/40 dark:border-white/10
                                       bg-white/60 dark:bg-white/5
                                       text-gray-900 dark:text-white
                                       placeholder:text-gray-400 dark:placeholder:text-gray-400
                                       focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                    </aside>
                </div>

                <?php if(isset($cities)): ?>
                    <div id="cities" class="mt-8 bg-white/80 dark:bg-[#0f172a]/80 backdrop-blur-xl rounded-3xl shadow-2xl border border-white/40 dark:border-white/5 overflow-hidden">
                        <div class="p-6 sm:p-8 border-b border-white/40 dark:border-white/5">
                            <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-3">
                                <div class="space-y-1">
                                    <div class="text-sm text-gray-500 dark:text-gray-300">
                                        Доступные города
                                    </div>
                                    <div class="text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                                        Выберите город вручную
                                    </div>
                                </div>

                                <div class="text-sm text-gray-500 dark:text-gray-300">
                                    <?php echo e($cities->count()); ?> шт.
                                </div>
                            </div>
                        </div>

                        <div class="p-4 sm:p-6">
                            <div id="cities-grid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
                                <?php $__currentLoopData = $cities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $candidateCity): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <form method="POST" action="<?php echo e(route('select.city')); ?>" data-city-name="<?php echo e($candidateCity->name); ?>">
                                        <?php echo csrf_field(); ?>
                                        <input type="hidden" name="city_id" value="<?php echo e($candidateCity->id); ?>">

                                        <button type="submit"
                                                class="w-full text-left p-5 rounded-3xl border border-white/40 dark:border-white/5
                                                    bg-white/60 dark:bg-white/5
                                                    hover:bg-white/80 dark:hover:bg-white/10
                                                    transition">
                                            <div class="font-semibold text-gray-900 dark:text-white">
                                                <?php echo e($candidateCity->name); ?>

                                            </div>
                                            <div class="mt-1 text-sm text-gray-500 dark:text-gray-300">
                                                Нажмите, чтобы выбрать
                                            </div>
                                        </button>
                                    </form>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                    </div>

                    <script>
                        (function () {
                            const input = document.getElementById('city-search');
                            const grid = document.getElementById('cities-grid');
                            if (!input || !grid) {
                                return;
                            }

                            const cards = Array.from(grid.querySelectorAll('form[data-city-name]'));

                            input.addEventListener('input', function () {
                                const q = (input.value || '').trim().toLowerCase();

                                for (const card of cards) {
                                    const name = (card.getAttribute('data-city-name') || '').toLowerCase();
                                    card.classList.toggle('hidden', q !== '' && !name.includes(q));
                                }
                            });
                        })();
                    </script>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php /**PATH C:\laragon\www\reviews\resources\views/home.blade.php ENDPATH**/ ?>