<!-- Hero Area Start -->
<div id="hero-area">
    <div class="overlay"></div>
    <div class="container">
        <div class="row d-flex justify-content-center">
            <div class="col-md-9 col-lg-9 col-xs-12 text-center">
                <div class="contents">
                    <h1 class="head-title">Busca anuncios y negocios en {{ $province_name }}</h1>
                    <p>Compra y vende Computadoras, Celulares, Casas, Carros, ofertas de empleo y comercio electrónico en Cuba</p>
                    <div class="search-two-form">

                        <form class="search-two" action="{{ route('welcome', ['province_slug' => 'www']) }}/search" method="get">
                            <div class="search-inner">
                                <div class="row">
                                    <div class="col-lg-9 col-md-9">
                                        <div class="form-group search-query">
                                            <input type="text" name="s" class="form-control" placeholder="Qué estás buscando hoy" autocomplete="on">
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-3">
                                        <button class="btn btn-common search-two-submit" type="submit"><i class="lni-search"></i> Buscar</button>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <div class="adverts-search-suggestion d-none d-md-block">
                            <span class="search-suggestion-title">Búsquedas populares</span>
                            <div class="adverts-search-suggestion-items">
                                <ul>
                                    <li><a href="{{ config('app.url') }}/search?s=Xiaomi">Xiaomi</a></li>
                                    <li><a href="{{ config('app.url') }}/search?s=Asus">Asus</a></li>
                                    <li><a href="{{ config('app.url') }}/search?s=2Tb">2Tb</a></li>
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