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
        <form method="post" action="<?php echo e(route('logout')); ?>">
            <?php echo csrf_field(); ?>
            <a href="<?php echo e(route('logout')); ?>" onclick="event.preventDefault(); this.closest('form').submit();">Log Out</a>
        </form>
</header>
<main>
        <h2>Confirm Password</h2>
        <form action="<?php echo e(route('password.confirm')); ?>" method="post" autocomplete="off">
            <?php echo csrf_field(); ?>
                <label for="password">Password</label>
                    <input type="password" id="password" name="password" required placeholder="Minimum 8 characters" />
                    <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
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
                <button type="submit">Confirm</button>
        </form>
</main>
</body>

</html><?php /**PATH /var/www/u2575153/data/www/smart-resources.tech/resources/views/auth/confirm-password.blade.php ENDPATH**/ ?>