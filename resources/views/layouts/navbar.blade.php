<!-- Navbar Start -->
<nav class="navbar navbar-expand-lg fixed-top scrolling-navbar">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main-navbar" aria-controls="main-navbar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
                <span class="lni-menu"></span>
                <span class="lni-menu"></span>
                <span class="lni-menu"></span>
            </button>
            <a href="{{ config('app.url') }}" class="navbar-brand"><img src="{{ asset('img/logo-bachecubano-w.png') }}" alt="Bachecubano" width="50" height="50" loading=lazy></a>
        </div>
        <div class="collapse navbar-collapse" id="main-navbar">

            <ul class="navbar-nav mr-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Categorías
                    </a>
                    <div class="dropdown-menu">
                        @foreach($parent_categories as $super_category)
                        <a class="dropdown-item" href="{{ route('super_category_index', ['category' => $super_category->description->slug, 'province_slug' => 'www']) }}">{{ $super_category->description->name }}</a>
                        @endforeach
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Provincias
                    </a>
                    <div class="dropdown-menu">
                        @foreach($locations as $location)
                        <a class="dropdown-item" href="{{ route('welcome', ['province_slug' => $location->slug, 'ref' => 'navbar']) }}">{{ $location->title }}</a>
                        @endforeach
                    </div>
                </li>
                <!--
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="{{ route('blog.index') }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Blog
                    </a>
                    <div class="dropdown-menu">
                        @foreach($latest_blog_post as $blog_post)
                        <a class="dropdown-item" href="{{ route('blog_post', ['entry_slug' => $blog_post->slug]) }}">{{ $blog_post->title }}</a>
                        @endforeach
                    </div>
                </li>
                -->
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('contact') }}">
                        Contáctenos
                    </a>
                </li>
            </ul>

            <!-- Show search Bar only in show page and user sections -->
            @if(isset($search_bar) && $search_bar == true)
            <ul class="navbar-nav mr-auto">
                <li>
                    <form action="{{ route('welcome', ['province_slug' => 'www']) }}/search" method="get">
                        <div class="search-inner">
                            <div class="row">
                                <div class="col-12">
                                    <div class="search-query">
                                        <input type="text" name="s" class="form-control" placeholder="Qué estás buscando hoy" autocomplete="on">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </li>
            </ul>
            @endif


            @auth
            <a class="tg-btn bg-primary mr-3" href="#">
                <i class="lni-money-protection"></i> {{ Auth::user()->wallet->credits }}
            </a>
            @endauth

            <!--
            <a class="tg-btn bg-primary mr-3" href="#">
                <i class="lni-cart"></i> Carrito
            </a>
            -->

            <ul class="sign-in">
                @if (Route::has('login'))
                @auth
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="{{ route('home') }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="lni-user"></i> Mi Cuenta</a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="{{ route('home') }}"><i class="lni-home"></i> Mi Cuenta</a>
                        <a class="dropdown-item" href="{{ route('my_ads') }}"><i class="lni-layers"></i> Mis Anuncios</a>
                        <a class="dropdown-item" href="{{ route('my_favourite') }}"><i class="lni-heart"></i> Favoritos</a>
                        <a class="dropdown-item" href="{{ route('transfer_money') }}"><i class="lni-money-protection"></i> Transferir</a>
                        <a class="dropdown-item" href="{{ route('my_settings') }}"><i class="lni-cog"></i> Ajustes</a>
                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="lni-exit"></i> Salir</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </li>
                @else
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="{{ route('login') }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="lni-user"></i> Acceder</a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="{{ route('login') }}"><i class="lni-home"></i> Iniciar sesión</a>
                        @if (Route::has('register'))
                        <a class="dropdown-item" href="{{ route('register') }}"><i class="lni-wallet"></i> Registrarme</a>
                        @endif
                    </div>
                </li>
                @endauth
                @endif
            </ul>

            <a class="tg-btn" href="{{ route('add', ['province_slug' => 'www']) }}">
                <i class="lni-pencil-alt"></i> Publicar Anuncio
            </a>
        </div>
    </div>

    <!-- Mobile Menu Start -->
    <ul class="mobile-menu">
        <li>
            <a href="{{ config('app.url') }}">
                Inicio
            </a>
        </li>
        <li>
            <a href="#">Categorías</a>
            <ul class="dropdown">
                @foreach($parent_categories as $super_category)
                <li><a href="{{ route('super_category_index', ['category' => $super_category->description->slug, 'province_slug' => 'www']) }}">{{ $super_category->description->name }}</a></li>
                @endforeach
            </ul>
        </li>
        <li>
            <a href="#">Blog</a>
            <ul class="dropdown">
                @foreach($latest_blog_post as $blog_post)
                <li><a href="{{ route('blog_post', ['entry_slug' => $blog_post->slug]) }}">{{ $blog_post->title }}</a></li>
                @endforeach
            </ul>
        </li>
        <li>
            <a href="{{ route('contact') }}">Contáctenos</a>
        </li>
        @if (Route::has('login'))
        @auth
        <li>
            <a>Mi Cuenta</a>
            <ul class="dropdown">
                <li><a href="{{ route('home') }}"><i class="lni-home"></i> Mi Cuenta</a></li>
                <li><a href="{{ route('my_ads') }}"><i class="lni-wallet"></i> Mis Anuncios</a></li>
                <li><a href="{{ route('my_favourite') }}"><i class="lni-heart"></i> Favoritos</a></li>
                <li><a href="{{ route('my_settings') }}"><i class="lni-cog"></i> Ajustes</a></li>
                <li>
                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        {{ __('Salir') }}
                    </a>
                </li>
            </ul>
        </li>
        @else
        <li>
            <a>Mi Cuenta</a>
            <ul class="dropdown">
                <li><a class="dropdown-item" href="{{ route('login') }}"><i class="lni-home"></i> Iniciar sesión</a></li>
                @if (Route::has('register'))
                <li><a class="dropdown-item" href="{{ route('register') }}"><i class="lni-wallet"></i> Registrarme</a></li>
                @endif
            </ul>
        </li>
        @endauth
        @endif
        <li>
            <a class="active" href="{{ route('add', ['province_slug' => 'www']) }}">
                Publicar anuncio
            </a>
        </li>
    </ul>
    <!-- Mobile Menu End -->
</nav>
<!-- Navbar End -->