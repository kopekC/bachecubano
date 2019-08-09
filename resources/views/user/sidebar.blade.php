<aside>
    <div class="sidebar-box">
        <div class="user">
            <figure>
                <a href="#"><img src="#" alt=""></a>
            </figure>
            <div class="usercontent">
                <h3>{{ Auth::user()->name }}</h3>
                <h4><i class="lni-hone"></i> {{ Auth::user()->phone }}</h4>
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
                        <span>Mis anuncios</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('my_favourite') }}" class="{{ \Route::current()->getName() == 'my_favourite' ? 'active' : ''}}">
                        <i class="lni-heart"></i>
                        <span>Mis Favoritos</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('my_settings') }}" class="{{ \Route::current()->getName() == 'my_settings' ? 'active' : ''}}">
                        <i class="lni-cog"></i>
                        <span>Ajustes</span>
                    </a>
                </li>

                <li>
                    <a href="#" class="{{ \Route::current()->getName() == 'offers' ? 'active' : ''}}">
                        <i class="lni-envelope"></i>
                        <span>Ofertas/Mensajes</span>
                    </a>
                </li>
                <li>
                    <a href="#" class="{{ \Route::current()->getName() == 'my_wallet' ? 'active' : ''}}">
                        <i class="lni-wallet"></i>
                        <span>Pagos</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="lni-close"></i>
                        <span>Salir</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
    <div class="widget">
        <h4 class="widget-title">Publicidad</h4>
        <div class="add-box">
            <img class="img-fluid" src="" alt="">
        </div>
    </div>
</aside>