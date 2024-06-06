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
    </header>
    <main>
            <h2>Forgot your password?</h2>
            @if (session('status'))

                <h3>{{ session('status') }}</h3>
            @endif
            <form action="{{ route('password.request') }}" method="post" autocomplete="off">
                @csrf
                    <label for="email">Email</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus class="{{ $errors->has('email') ? 'text-red-900 placeholder-red-300 focus:border-red-500 focus:ring-red-500 border-red-300' : 'border-gray-300 focus:border-green-500 focus:ring-green-500 placeholder:text-gray-400' }} w-full rounded-md pl-10 text-sm" placeholder="john@example.com" />
                        @error('email')
                        @enderror
                    @error('email')
                    <p>{{ $message }}</p>
                    @enderror
                    <button type="submit">Send Reset Link</button>
            </form>
    </main>
</body>

</html>