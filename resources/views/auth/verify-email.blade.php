<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <header>
        <a href="{{ route('welcome') }}">
            <span>SRM</span>
        </a>
            <form method="post" action="{{ route('logout') }}">
                @csrf

                <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();">Log Out</a>
            </form>
    </header>
    <main>
            <h2>Verify Email</h2>
            @if (session('status'))
                <h3>{{ session('status') }}</h3>
            @endif
            <form action="{{ route('verification.send') }}" method="post" autocomplete="off">
                @csrf
                    <button type="submit">Resend Verification Link</button>
            </form>
    </main>
</body>

</html>