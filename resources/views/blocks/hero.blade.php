<!-- Hero Area Start -->
<div id="hero-area">
    <div class="overlay"></div>
    <div class="container">
        <div class="row d-flex justify-content-center">
            <div class="col-md-9 col-lg-9 col-xs-12 text-center">
                <div class="contents">
                    <h1 class="head-title">Busca entre +{{ $total_ads }} anuncios</h1>
                    <p>Compra y Vende Computadoras, Celulares, Casas, Carros, ofertas de empleo y todo lo que quieras en Cuba</p>
                    <div class="search-two-form">
                        <form class="search-two" action="{{ route('search') }}" method="get">
                            <div class="search-inner">
                                <div class="row">
                                    <div class="col-lg-9 col-md-9">
                                        <div class="form-group search-query">
                                            <input type="text" name="query" class="form-control" placeholder="Qué estas buscando hoy" autocomplete="off">
                                            <div class="search-suggestion">
                                                <div class="search-suggestion-items">
                                                    <ul>
                                                        <li><a href="#"><i class="lni-display"></i> Computadoras</a></li>
                                                        <li><a href="#"><i class="lni-tshirt"></i> Ropa</a></li>
                                                        <li><a href="#"><i class="lni-mobile"></i> Celulares</a></li>
                                                        <li><a href="#"><i class="lni-paint-roller"></i> Servicios</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-3">
                                        <button class="btn btn-common search-two-submit" type="submit" form="search-two"><i class="lni-search"></i> Buscar</button>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <div class="adverts-search-suggestion">
                            <span class="search-suggestion-title">Búsquedas populares</span>
                            <div class="adverts-search-suggestion-items">
                                <ul>
                                    <li><a href="#">dynamic</a></li>
                                    <li><a href="#">bachecubano motos</a></li>
                                    <li><a href="#">revolico celulares</a></li>
                                    <li><a href="#">base de datos ETECSA</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Hero Area End -->