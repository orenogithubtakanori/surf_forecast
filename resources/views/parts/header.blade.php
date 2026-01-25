<header class="site-header">
    <div class="site-header__inner">
        <a href="/" class="site-header__logo">surf forecast</a>
        <nav class="site-header__nav">
            <a href="{{ route('index') }}" class="site-header__link">サーフスポットを探す</a>
            @if (Route::has('login'))
                @auth
                    <span class="site-header__user">{{ Auth::user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="site-header__link site-header__button" type="submit">Log Out</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="site-header__link">Log in</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="site-header__link">Register</a>
                    @endif
                @endauth
            @endif
        </nav>
    </div>
</header>

<style>
.site-header {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    z-index: 60;
    height: 64px;
    background-color: #003057;
    border-bottom: 1px solid rgba(255, 255, 255, 0.12);
}
.site-header__inner {
    max-width: 1120px;
    margin: 0 auto;
    padding: 0 20px;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: space-between;
}
.site-header__logo {
    color: #ffffff;
    font-size: 18px;
    font-weight: 600;
    text-decoration: none;
}
.site-header__nav {
    display: flex;
    align-items: center;
    gap: 18px;
    color: #ffffff;
}
.site-header__link {
    color: #ffffff;
    text-decoration: none;
    font-size: 14px;
}
.site-header__link:hover {
    color: #e2e8f0;
}
.site-header__user {
    font-size: 13px;
    color: #e2e8f0;
}
.site-header__button {
    background: transparent;
    border: none;
    cursor: pointer;
    padding: 0;
}
</style>