<nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
    <a class="navbar-brand" href="{{ route('ad.list') }}">Swap it</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <ul class="navbar-nav mr-auto">
        <li class="nav-item {{ Request::route()->getName() === 'ad.list' ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('ad.list') }}">Ads</a>
        </li>
        <li class="nav-item {{ Request::route()->getName() === 'ad.create.form' ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('ad.create.form') }}">New add</a>
        </li>
{{--            <li class="nav-item">--}}
{{--                <a class="nav-link" href="{{route('logout')}}">Link</a>--}}
{{--            </li>--}}
{{--            <li class="nav-item">--}}
{{--                <a class="nav-link disabled" href="#">Disabled</a>--}}
{{--            </li>--}}
{{--            <li class="nav-item dropdown">--}}
{{--                <a class="nav-link dropdown-toggle" href="http://example.com" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Dropdown</a>--}}
{{--                <div class="dropdown-menu" aria-labelledby="dropdown01">--}}
{{--                    <a class="dropdown-item" href="#">Action</a>--}}
{{--                    <a class="dropdown-item" href="#">Another action</a>--}}
{{--                    <a class="dropdown-item" href="#">Something else here</a>--}}
{{--                </div>--}}
{{--            </li>--}}
    </ul>
    @guest
        <a class="nav-link" href="{{ route('login') }}">Login</a>
        <a class="nav-link" href="{{ route('register') }}">Register</a>
    @else
        <a class="nav-link" href="{{ route('force-logout') }}">Logout</a>
    @endguest
</nav>
