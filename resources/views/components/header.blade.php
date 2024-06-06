<header>
      <a class="logo" href="{{ route('welcome') }}">
         <span><img src="{{ asset('public/img/logo.png') }}" alt="логотип команды SRM"></span>
      </a>
      <nav class="menu">
         <ul>
            <li><a class="link" href="">{{ __('Развернуть контракт') }}</a></li>
            <li><a class="link" href="">{{ __('Физические устройства') }}</a></li>
            <li><a class="link" href="">{{ __('Документация') }}</a></li>
            <li><a class="link" href="">{{ __('API') }}</a></li>
            <li><a class="link" href="">{{ __('О нас') }}</a></li>
            <li><a class="link" href="">{{ __('Контакты') }}</a></li>
         </ul>
      </nav>
      @guest
      <div class="authorization">
         <a class="button button_green" href="{{ route('login') }}">{{ __('Вход') }}</a>
         <a class="button button_grey" href="{{ route('register') }}">{{ __('Регистрация') }}</a>
      </div>
      @endguest
      @auth
      <div class="authorization"><a class="button button_green" href="{{ route('dashboard') }}">{{ __('Личный кабинет') }}</a></div>
      @endauth
   </header>