
@if(Auth::guard('admin')->check())
<div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('admin.logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('AdminLogout') }}
                                    </a>
<form action="{{ route('admin.logout') }}" id="logout-form" method="POST" style="display: none;">
    @csrf
</form>
@elseif (Auth::guard('web')->check())
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
