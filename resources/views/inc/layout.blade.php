<div class="si-wrapper">
    <div class="si-wrapper__menu">
        @include('inc.menu')
    </div>
    <div class="si-wrapper__header">
        @yield('header')
    </div>
    <div class="si-wrapper__content">
        @include('inc.messages')
        @yield('content')
    </div>
</div>
