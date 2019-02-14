<li class="nav-item dropdown">
    <a 
        id="navbarDropdown"
        href="#" 
        class="nav-link dropdown-toggle"
        role="button"
        data-toggle="dropdown"
        aria-haspopup="true"
        aria-expanded="false">

        {{ Auth::user()->name }} <span class="caret"></span>
    </a>

    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
        <a 
            href="{{ route('logout') }}" 
            class="dropdown-item"
            onclick="
                event.preventDefault();
                document.getElementById('logout-form').submit();"
            >

            {{ __('Cerrar sesion') }}
        </a>

        <form action="{{ route('logout') }}" id="logout-form" method="POST" style="display:none;">
            @csrf
        </form>
    </div>
</li>