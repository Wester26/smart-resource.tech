<x-layout>
    <header>
        <a href="{{ route('welcome') }}">
            <span>SRM</span>
        </a>
        <a href="{{ route('profile') }}">Profile</a>
        <form method="post" action="{{ route('logout') }}">
            @csrf
            <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();">Log Out</a>
        </form>
    </header>
    <main>
        <h1>Dashboard</h1>
    </main>
</x-layout>