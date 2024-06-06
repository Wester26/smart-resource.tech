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
            <h2>Reset Password</h2>
            <form action="{{ route('password.update') }}" method="post" autocomplete="off">
                @csrf

                <input type="hidden" name="token" value="{{ $request->token }}">

                    <label for="email">Email</label>

                        <input type="email" id="email" name="email" value="{{ old('email', $request->email) }}" required placeholder="john@example.com" />
                        @error('email')
                        @enderror
                    @error('email')
                    <p>{{ $message }}</p>
                    @enderror
                    <label for="password">Password</label>
                        <input type="password" id="password" name="password" required />
                        @error('password')
                        @enderror
                    @error('password')
                    <p>{{ $message }}</p>
                    @enderror
                    <label for="password_confirmation">Confirm Password</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" required class="{{ $errors->has('password_confirmation') ? 'text-red-900 placeholder-red-300 focus:border-red-500 focus:ring-red-500 border-red-300' : 'border-gray-300 focus:border-green-500 focus:ring-green-500 placeholder:text-gray-400' }} w-full rounded-md pl-10 text-sm" placeholder="Minimum 8 characters" />
                        @error('password_confirmation')
                        @enderror
                    @error('password_confirmation')
                    <p>{{ $message }}</p>
                    @enderror
                    <button type="submit">Reset Password</button>
            </form>
    </main>
</body>

</html>