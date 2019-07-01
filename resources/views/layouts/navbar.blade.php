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
            <a href="index.html" class="navbar-brand"><img src="{{ asset('img/logo-bachecubano.png') }}" alt="Bachecubano" width="60" height="60"></a>
        </div>
        <div class="collapse navbar-collapse" id="main-navbar">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Categorías
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="adlistinggrid.html">Ad Grid</a>
                        <a class="dropdown-item" href="adlistinglist.html">Ad Listing</a>
                        <a class="dropdown-item" href="ads-details.html">Listing Detail</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Blog
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="blog.html">Blog - Right Sidebar</a>
                        <a class="dropdown-item" href="blog-left-sidebar.html">Blog - Left Sidebar</a>
                        <a class="dropdown-item" href="blog-grid-full-width.html"> Blog full width </a>
                        <a class="dropdown-item" href="single-post.html">Blog Details</a>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="contact.html">
                        Contacto
                    </a>
                </li>
            </ul>
            <ul class="sign-in">
                @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="lni-user"></i> My Account</a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="account-profile-setting.html"><i class="lni-home"></i> Account Home</a>
                            <a class="dropdown-item" href="account-myads.html"><i class="lni-wallet"></i> My Ads</a>
                            <a class="dropdown-item" href="account-favourite-ads.html"><i class="lni-heart"></i> Favourite ads</a>
                            <a class="dropdown-item" href="account-archived-ads.html"><i class="lni-folder"></i> Archived</a>
                            <a class="dropdown-item" href="login.html"><i class="lni-lock"></i> Log In</a>
                            <a class="dropdown-item" href="signup.html"><i class="lni-user"></i> Signup</a>
                            <a class="dropdown-item" href="forgot-password.html"><i class="lni-reload"></i> Forgot Password</a>
                            <a class="dropdown-item" href="account-close.html"><i class="lni-close"></i>Account close</a>
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
                </div>
                @endif
            </ul>
            <a class="tg-btn btn-danger" href="{{ route('add') }}">
                <i class="lni-pencil-alt"></i> Publicar Anuncio
            </a>
        </div>
    </div>

    <!-- Mobile Menu Start -->
    <ul class="mobile-menu">
        <li>
            <a class="active" href="#">
                Home
            </a>
        </li>
        <li>
            <a href="category.html">Categories</a>
        </li>
        <li>
            <a href="#">Blog</a>
            <ul class="dropdown">
                <li><a href="blog.html">Blog - Right Sidebar</a></li>
                <li><a href="blog-left-sidebar.html">Blog - Left Sidebar</a></li>
                <li><a href="blog-grid-full-width.html"> Blog full width </a></li>
                <li><a href="single-post.html">Blog Details</a></li>
            </ul>
        </li>
        <li>
            <a href="contact.html">Contact Us</a>
        </li>
        @if (Route::has('login'))
        @auth
        <li>
            <a>Mi Cuenta</a>
            <ul class="dropdown">
                <li><a href="account-profile-setting.html"><i class="lni-home"></i> Account Home</a></li>
                <li><a href="account-myads.html"><i class="lni-wallet"></i> My Ads</a></li>
                <li><a href="account-favourite-ads.html"><i class="lni-heart"></i> Favourite ads</a></li>
                <li><a href="account-archived-ads.html"><i class="lni-folder"></i> Archived</a></li>
                <li><a href="login.html"><i class="lni-lock"></i> Log In</a></li>
                <li><a href="signup.html"><i class="lni-user"></i> Signup</a></li>
                <li><a href="forgot-password.html"><i class="lni-reload"></i> Forgot Password</a></li>
                <li><a href="account-close.html"><i class="lni-close"></i>Account close</a></li>
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
    </ul>
    <!-- Mobile Menu End -->

</nav>
<!-- Navbar End -->