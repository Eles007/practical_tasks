<nav class="bg-white border-b border-gray-100">

    <div class="max-w-7xl mx-auto px-6">
        <div class="flex justify-between h-16 items-center">

            <!-- Logo -->
            <div class="flex items-center">
                <a href="<?php echo e(route('home')); ?>">
                    <?php if (isset($component)) { $__componentOriginal8892e718f3d0d7a916180885c6f012e7 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8892e718f3d0d7a916180885c6f012e7 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.application-logo','data' => ['class' => 'h-9 w-auto text-gray-800']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('application-logo'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'h-9 w-auto text-gray-800']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8892e718f3d0d7a916180885c6f012e7)): ?>
<?php $attributes = $__attributesOriginal8892e718f3d0d7a916180885c6f012e7; ?>
<?php unset($__attributesOriginal8892e718f3d0d7a916180885c6f012e7); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8892e718f3d0d7a916180885c6f012e7)): ?>
<?php $component = $__componentOriginal8892e718f3d0d7a916180885c6f012e7; ?>
<?php unset($__componentOriginal8892e718f3d0d7a916180885c6f012e7); ?>
<?php endif; ?>
                </a>
            </div>

            <!-- Right Side -->
            <div class="flex items-center gap-4">

                <?php if(auth()->guard()->guest()): ?>

                    <!-- Login -->
                    <a href="<?php echo e(route('login')); ?>"
                       class="px-5 py-2 rounded-xl
                   text-gray-600 hover:text-gray-900
                   hover:bg-gray-100 transition">
                        Вход
                    </a>

                    <!-- Register -->
                    <a href="<?php echo e(route('register')); ?>"
                       class="px-5 py-2 rounded-xl
                   bg-green-600 text-gray-600
                   hover:bg-green-700 transition">
                        Регистрация
                    </a>

                <?php endif; ?>


                <?php if(auth()->guard()->check()): ?>
                    <a href="<?php echo e(route('profile.edit')); ?>"
                       class="block px-4 py-2 hover:bg-gray-100">
                        Профиль
                    </a>

                    <form method="POST" action="<?php echo e(route('logout')); ?>">
                        <?php echo csrf_field(); ?>

                        <button type="submit"
                                class="w-full text-left px-4 py-2
                                    hover:bg-gray-100">
                            Выйти
                        </button>
                    </form>

                <?php endif; ?>

            </div>

        </div>
    </div>

</nav>
<?php /**PATH C:\laragon\www\reviews\resources\views/layouts/navigation.blade.php ENDPATH**/ ?>