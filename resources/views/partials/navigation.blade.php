<header>
    <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
        <div class="container">

            <a href="{{ url('/') }}" class="navbar-brand">
                {{ config('app.name') /*busca la variable 'name' en config/app.php */}}
            </a>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarContent" aria-expanded="false" aria-controls="navbarContent">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarContent">

                <ul class="navbar-nav mr-auto">

                </ul>

                <ul class="navbar-nav ml-auto">
                    <li class="nav-item dropdown">
                        <a 
                            href="#" 
                            class="nav-link dropdown-toggle"
                            id="navbarDropdownMenuLink"
                            data-toggle="dropdown"
                            aria-haspopup="true"
                            aria-expanded="false">

                            {{ __("Selecciona un idioma") }}

                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <a 
                                href="{{ route('set_language',['es']) }}" 
                                class="dropdown-item">

                                {{ __('Español') }}
                                
                            </a>
                            <a 
                                href="{{ route('set_language',['en']) }}" 
                                class="dropdown-item">

                                {{ __('Ingles') }}

                            </a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

</header>