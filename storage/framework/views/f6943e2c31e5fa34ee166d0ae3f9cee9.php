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
            <h2>Verify Email</h2>
            <?php if(session('status')): ?>
                <h3><?php echo e(session('status')); ?></h3>
            <?php endif; ?>
            <form action="<?php echo e(route('verification.send')); ?>" method="post" autocomplete="off">
                <?php echo csrf_field(); ?>
                    <button type="submit">Resend Verification Link</button>
            </form>
    </main>
</body>

</html><?php /**PATH /var/www/u2575153/data/www/smart-resources.tech/resources/views/auth/verify-email.blade.php ENDPATH**/ ?>