<div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom shadow-sm">
    <h5 class="my-0 mr-md-auto font-weight-normal">
        <a class="navbar-brand" href="{{ url('/') }}">
            {{ config('app.name', 'SocialDB') }}
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>
    </h5>
    @auth()
        <nav class="my-2 my-md-0 mr-md-3">
            <a class="p-2 text-dark" href="{{route('users.profile', auth()->user())}}">My profile</a>
            <a class="p-2 text-dark" href="{{route('friends', auth()->user())}}">My friends</a>
            <a class="p-2 text-dark" href="{{route('news')}}">News</a>
            <a class="p-2 text-dark" href="{{route('users')}}">All users</a>
        </nav>
    @endauth
    @guest
        @if (Route::has('login'))
            <a class="btn btn-outline-primary m-2" href="{{ route('login') }}">{{ __('Login') }}</a>
        @endif

        @if (Route::has('register'))
            <a class="btn btn-primary m-2" href="{{ route('register') }}">{{ __('Register') }}</a>
        @endif
    @else
        <div class="dropdown">
            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                {{ Auth::user()->name }}
            </button>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="{{ route('logout') }}"
                   onclick="event.preventDefault();
                   document.getElementById('logout-form').submit();"
                >
                    {{ __('Logout') }}
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        </div>
    @endguest
</div>
