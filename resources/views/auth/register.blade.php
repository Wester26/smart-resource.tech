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
            <a href="{{ route('login') }}">Log In</a>
    </header>
    <main>
            <h2>Create your account</h2>
            <form action="{{ route('register') }}" method="post" autocomplete="off">
                @csrf
                    <label for="name">Name</label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" required autofocus placeholder="John Doe" />
                        @error('name')
                        @enderror
                    @error('name')
                    <p>{{ $message }}</p>
                    @enderror
                    <label for="email">Email</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required placeholder="john@example.com" />
                        @error('email')
                        @enderror
                    @error('email')
                    <p>{{ $message }}</p>
                    @enderror
                    <label for="password">Password</label>
                        <input type="password" id="password" name="password" required placeholder="Minimum 8 characters" />
                        @error('password')
                        @enderror
                    @error('password')
                    <p>{{ $message }}</p>
                    @enderror
                    <label for="password_confirmation">Confirm Password</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" required placeholder="Minimum 8 characters" />
                        @error('password_confirmation')
                        @enderror
                    @error('password_confirmation')
                    <p>{{ $message }}</p>
                    @enderror
                    <button type="submit">Sign Up</button>
            </form>
                <a href="{{ route('login') }}">Already have an account?</a>
    </main>
</body>

</html>