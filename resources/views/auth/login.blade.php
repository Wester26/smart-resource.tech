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
            <a href="{{ route('register') }}">Register</a>
    </header>
    <main>
            <h2>Welcome back!</h2>
            @if (session('status'))
                <h3>{{ session('status') }}</h3>
            @endif
            <form action="{{ route('login') }}" method="post" autocomplete="off">
                @csrf
                    <label for="email">Email</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus placeholder="john@example.com" />
                    </div>
                    @error('email')
                    <p>{{ $message }}</p>
                    @enderror
                    <label for="password">Password</label>
                        <input type="password" id="password" name="password" required placeholder="Minimum 8 characters" />
                    @error('password')
                    <p>{{ $message }}</p>
                    @enderror
                        <input type="checkbox" id="remember" name="remember" />
                        <label for="remember">Remember me</label>
                    <a href="{{ route('password.request') }}">Forgot your password?</a>
                    <button type="submit">Log In</button>
            </form>
    </main>
</body>

</html>