
@if(Auth::guard('web')->check())
<div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('user.logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>
<form action="{{ route('user.logout') }}" id="logout-form" method="POST" style="display: none;">
    @csrf
</form>
@endif
