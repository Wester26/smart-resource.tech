<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <header>
        <a href="<?php echo e(route('welcome')); ?>">

            <span>SRM</span>
        </a>
    </header>
    <main>
            <h2>Forgot your password?</h2>
            <?php if(session('status')): ?>

                <h3><?php echo e(session('status')); ?></h3>
            <?php endif; ?>
            <form action="<?php echo e(route('password.request')); ?>" method="post" autocomplete="off">
                <?php echo csrf_field(); ?>
                    <label for="email">Email</label>
                        <input type="email" id="email" name="email" value="<?php echo e(old('email')); ?>" required autofocus class="<?php echo e($errors->has('email') ? 'text-red-900 placeholder-red-300 focus:border-red-500 focus:ring-red-500 border-red-300' : 'border-gray-300 focus:border-green-500 focus:ring-green-500 placeholder:text-gray-400'); ?> w-full rounded-md pl-10 text-sm" placeholder="john@example.com" />
                        <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    <button type="submit">Send Reset Link</button>
            </form>
    </main>
</body>

</html><?php /**PATH /var/www/u2575153/data/www/smart-resources.tech/resources/views/auth/forgot-password.blade.php ENDPATH**/ ?>