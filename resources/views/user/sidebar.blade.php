<aside>
    <div class="sidebar-box">
        <div class="user">
            <figure>
                <a href="#"><img src="assets/img/author/img1.jpg" alt=""></a>
            </figure>
            <div class="usercontent">
                <h3>User</h3>
                <h4>Administrator</h4>
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
                    <a href="account-profile-setting.html">
                        <i class="lni-cog"></i>
                        <span>Ajustes</span>
                    </a>
                </li>
                <li>
                    <a href="account-myads.html">
                        <i class="lni-layers"></i>
                        <span>Mis anuncios</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="lni-envelope"></i>
                        <span>Ofertas/Mensajes</span>
                    </a>
                </li>
                <li>
                    <a href="dashboard-payments.html">
                        <i class="lni-wallet"></i>
                        <span>Pagos</span>
                    </a>
                </li>
                <li>
                    <a href="account-favourite-ads.html">
                        <i class="lni-heart"></i>
                        <span>Mis Favoritos</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="lni-enter"></i>
                        <span>Cerrar</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
    <div class="widget">
        <h4 class="widget-title">Publicidad</h4>
        <div class="add-box">
            <img class="img-fluid" src="assets/img/img1.jpg" alt="">
        </div>
    </div>
</aside>