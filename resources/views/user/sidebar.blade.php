<aside>
    <div class="sidebar-box">
        <div class="user">
            <div class="d-flex justify-content-center h-100">
                <div class="image_outer_container">
                    <div class="green_icon"></div>
                    <div class="image_inner_container">
                        <img src="{{ profile_logo(Auth::getUser()) }}" loading=lazy>
                    </div>
                </div>
            </div>
            <div class="usercontent text-center">
                <h3 title="{{ Auth::user()->id }}"><i class="lni-user"></i> {{ Auth::user()->name }}</h3>
                <h4><i class="lni-mobile"></i> {{ Auth::user()->phone }}</h4>
                <h4><i class="lni-money-protection"></i> {{ Auth::user()->wallet->credits }}</h4>
                {{--
                <div class="row text-white">
                    <div class="col text-left">{{ Auth::user()->following()->count() }}<br><small>Siguiendo</small>
            </div>
            <div class="col text-right">{{ Auth::user()->followers()->count() }}<br><small>Seguidores</small></div>
        </div> --}}
    </div>
    </div>
    <nav class="navdashboard">
        <ul>
            <li>
                <a href="{{ route('home') }}" class="{{ \Route::current()->getName() == 'home' ? 'active' : ''}}">
                    <i class="lni-dashboard"></i>
                    <span>Panel Principal</span>
                </a>
            </li>
            <li>
                <a href="{{ route('my_ads') }}" class="{{ \Route::current()->getName() == 'my_ads' ? 'active' : ''}}">
                    <i class="lni-layers"></i>
                    <span>Anuncios</span>
                </a>
            </li>
            <li>
                <a href="{{ route('update_all') }}">
                    <i class="lni-layers"></i>
                    <span>Actualizar todo</span>
                </a>
            </li>

            {{--
            <li>
                <a href="{{ route('my_favourite') }}" class="{{ \Route::current()->getName() == 'my_favourite' ? 'active' : ''}}">
            <i class="lni-heart"></i>
            <span>Favoritos</span>
            </a>
            </li>
            --}}

            @role('writer')
            <li>
                <a href="{{ route('my_blog_posts') }}" class="{{ \Route::current()->getName() == 'my_blog_posts' ? 'active' : ''}}">
                    <i class="lni-docs"></i>
                    <span>Mis publicaciones</span>
                </a>
            </li>
            @else
            @endrole

            <li>
                <a href="{{ route('my_settings') }}" class="{{ \Route::current()->getName() == 'my_settings' ? 'active' : ''}}">
                    <i class="lni-cog"></i>
                    <span>Ajustes</span>
                </a>
            </li>
            <li>
                <a href="{{ route('transfer_money') }}" class="{{ \Route::current()->getName() == 'transfer_money' ? 'active' : ''}}">
                    <i class="lni-money-protection"></i>
                    <span>Transferir</span>
                </a>
            </li>
            <li>
                <a href="{{ route('send_sms') }}" class="{{ \Route::current()->getName() == 'send_sms' ? 'active' : ''}}">
                    <i class="lni-envelope"></i>
                    <span>Mensajes</span>
                </a>
            </li>

            <!--
                <li>
                    <a href="#" class="{{ \Route::current()->getName() == 'my_wallet' ? 'active' : ''}}">
                        <i class="lni-wallet"></i>
                        <span>Pagos</span>
                    </a>
                </li>
                -->

            <li>
                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="lni-exit"></i>
                    <span>Salir</span>
                </a>
            </li>
        </ul>
    </nav>
    </div>

    @include('gads.v')

</aside>