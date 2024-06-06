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
            <a href="<?php echo e(route('register')); ?>">Register</a>
    </header>
    <main>
            <h2>Welcome back!</h2>
            <?php if(session('status')): ?>
                <h3><?php echo e(session('status')); ?></h3>
            <?php endif; ?>
            <form action="<?php echo e(route('login')); ?>" method="post" autocomplete="off">
                <?php echo csrf_field(); ?>
                    <label for="email">Email</label>
                        <input type="email" id="email" name="email" value="<?php echo e(old('email')); ?>" required autofocus placeholder="john@example.com" />
                    </div>
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
                    <label for="password">Password</label>
                        <input type="password" id="password" name="password" required placeholder="Minimum 8 characters" />
                    <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        <input type="checkbox" id="remember" name="remember" />
                        <label for="remember">Remember me</label>
                    <a href="<?php echo e(route('password.request')); ?>">Forgot your password?</a>
                    <button type="submit">Log In</button>
            </form>
    </main>
</body>

</html><?php /**PATH D:\OSPanel\domains\smart-resource.tech\resources\views/auth/login.blade.php ENDPATH**/ ?>