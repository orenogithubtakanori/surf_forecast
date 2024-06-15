<header class = 'head'>
    <a href="/" class = 'head_name'>
        My SurfForecast
    </a>
    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <!-- Responsive Settings Options -->
        <div class="auth">
        @if (Route::has('login'))
            @auth
            <div class="">
                <div>{{ Auth::user()->name }}</div>
                <div>{{ Auth::user()->email }}</div>
            </div>

            <div class="">
                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
            @else
                <a href="{{ route('login') }}" class="bottun">Log in</a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="bottun">Register</a>
                @endif
            @endauth
        @endif 
        </div>
    </div>
</header>

<style>
header {
    position: fixed;
    z-index: 2;
    height: 100px;
    width: 100%;
    background-color: #33CBB9;
    display: flex; 
    box-shadow: 0px 2px 0px 2px rgba(0, 0, 0, 0.1);
    margin-top: 0px;
    padding: 0px;
    /*position: relative;*/
    /*display: flex;
    justify-content: center;
    align-items: center;*/
}
.head_name{
    position: absolute;
    top: 50%;
    left: 3%;
    transform: translateY(-50%);
    -webkit- transform: translateY(-10%) translateX(-50%);
    font-size: 30px;
    font-weight: bold;
    color: #FFFFFF;
    text-decoration: none;
    cursor: pointer;
}
.auth{
    position: absolute;
    top: 50%;
    left: 85%;
    -webkit- transform: translateY(-50%) translateX(-50%);
}
.bottun{
    margin: 10px;
    color: #FFFFFF;
    font-weight: 100;
}
</style>