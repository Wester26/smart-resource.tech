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
            <?php if(auth()->guard()->guest()): ?>
            <a href="<?php echo e(route('login')); ?>">Log In</a>
            <a href="<?php echo e(route('register')); ?>">Register</a>
            <?php endif; ?>
            <?php if(auth()->guard()->check()): ?>
            <a href="<?php echo e(route('dashboard')); ?>">Dashboard</a>
            <?php endif; ?>
    </header>
</body>

</html><?php /**PATH D:\OSPanel\domains\smart-resource.tech\resources\views/welcome.blade.php ENDPATH**/ ?>