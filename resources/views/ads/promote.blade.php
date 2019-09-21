@extends('layouts.app')

@section('content')
<!-- Page Header Start -->
<div class="page-header">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="breadcrumb-wrapper">
                    <a href="{{ URL::current() }}">
                        <h2 class="product-title">Promocionar anuncio:</h2>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Page Header End -->

<!-- Pricing section Start -->
<section id="pricing-table" class="section-padding">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="mainHeading">
                    <h2 class="section-title">Seleccione el plan de promoción</h2>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-xs-12">
                <div class="table">
                    <div class="icon">
                        <i class="lni-gift"></i>
                    </div>
                    <div class="title">
                        <h3>BRONCE</h3>
                    </div>
                    <div class="pricing-header">
                        <p class="price-value"><sup>$</sup>1<span>/ Mes</span></p>
                    </div>
                    <ul class="description">
                        <li><strong>Primero</strong> siempre</li>
                        <li>Listado en <strong>LaChopi</strong></li>
                        <li><strong>30</strong> días</li>
                        <li><strong>100%</strong> activo</li>
                        <del><li><strong>SMS</strong> masivo</li></del>
                        <del><li><strong>Viral</strong> Facebook</li></del>
                    </ul>
                    <button class="btn btn-common">Activar</button>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-xs-12">
                <div class="table" id="active-tb">
                    <div class="icon">
                        <i class="lni-leaf"></i>
                    </div>
                    <div class="title">
                        <h3>PLATA</h3>
                    </div>
                    <div class="pricing-header">
                        <p class="price-value"><sup>$</sup>5<span>/ Mes</span></p>
                    </div>
                    <ul class="description">
                        <li><strong>Primero</strong> siempre</li>
                        <li>Listado en <strong>LaChopi</strong></li>
                        <li><strong>30</strong> días</li>
                        <li><strong>100%</strong> activo</li>
                        <del><li><strong>SMS</strong> masivo</li></del>
                        <del><li><strong>Viral</strong> Facebook</li></del>
                    </ul>
                    <button class="btn btn-common">Activar</button>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-xs-12">
                <div class="table">
                    <div class="icon">
                        <i class="lni-layers"></i>
                    </div>
                    <div class="title">
                        <h3>ORO</h3>
                    </div>
                    <div class="pricing-header">
                        <p class="price-value"><sup>$</sup>10<span>/ Mes</span></p>
                    </div>
                    <ul class="description">
                        <li><strong>Primero</strong> siempre</li>
                        <li>Listado en <strong>LaChopi</strong></li>
                        <li><strong>30</strong> días</li>
                        <li><strong>100%</strong> activo</li>
                        <li><strong>SMS</strong> masivo</li>
                        <li><strong>Viral</strong> Facebook</li>
                    </ul>
                    <button class="btn btn-common">Activar</button>
                </div>
            </div>
        </div>

        <div id="list-view" class="tab-pane fade active show">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="featured-box">
                        <figure>
                            <div class="icon">
                                <i class="lni-heart"></i>
                            </div>
                            <a href="#"><img class="img-fluid" src="assets/img/featured/img5.jpg" alt=""></a>
                        </figure>
                        <div class="feature-content">
                            <div class="product">
                                <a href="#"><i class="lni-folder"></i> Apple</a>
                            </div>
                            <h4><a href="ads-details.html">Apple Macbook Pro 13 Inch</a></h4>
                            <span>Last Updated: 4 hours ago</span>
                            <ul class="address">
                                <li>
                                    <a href="#"><i class="lni-map-marker"></i>Louis, Missouri, US</a>
                                </li>
                                <li>
                                    <a href="#"><i class="lni-alarm-clock"></i> May 18, 2018</a>
                                </li>
                                <li>
                                    <a href="#"><i class="lni-user"></i> Will Ernest</a>
                                </li>
                                <li>
                                    <a href="#"><i class="lni-package"></i> Brand New</a>
                                </li>
                            </ul>
                            <div class="listing-bottom">
                                <h3 class="price float-left">$450.00</h3>
                                <a href="account-myads.html" class="btn-verified float-right"><i class="lni-check-box"></i>
                                    Verified Ad</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>
<!-- Pricing Table Section End -->

@endsection