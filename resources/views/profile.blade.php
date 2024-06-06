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

        <a href="{{ route('dashboard') }}">Dashboard</a>
        <form method="post" action="{{ route('logout') }}">
            @csrf

            <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();">Log Out</a>
        </form>

    </header>
    <main>

        <h1>Profile</h1>

    </main>
</body>

</html>