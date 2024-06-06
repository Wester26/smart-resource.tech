<header>
      <a class="logo" href="<?php echo e(route('welcome')); ?>">
         <span><img src="<?php echo e(asset('public/img/logo.png')); ?>" alt="логотип команды SRM"></span>
      </a>
      <nav class="menu">
         <ul>
            <li><a class="link" href=""><?php echo e(__('Развернуть контракт')); ?></a></li>
            <li><a class="link" href=""><?php echo e(__('Физические устройства')); ?></a></li>
            <li><a class="link" href=""><?php echo e(__('Документация')); ?></a></li>
            <li><a class="link" href=""><?php echo e(__('API')); ?></a></li>
            <li><a class="link" href=""><?php echo e(__('О нас')); ?></a></li>
            <li><a class="link" href=""><?php echo e(__('Контакты')); ?></a></li>
         </ul>
      </nav>
      <?php if(auth()->guard()->guest()): ?>
      <div class="authorization">
         <a class="button button_green" href="<?php echo e(route('login')); ?>"><?php echo e(__('Вход')); ?></a>
         <a class="button button_grey" href="<?php echo e(route('register')); ?>"><?php echo e(__('Регистрация')); ?></a>
      </div>
      <?php endif; ?>
      <?php if(auth()->guard()->check()): ?>
      <div class="authorization"><a class="button button_green" href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Личный кабинет')); ?></a></div>
      <?php endif; ?>
   </header><?php /**PATH /var/www/u2575153/data/www/smart-resources.tech/resources/views/components/header.blade.php ENDPATH**/ ?>