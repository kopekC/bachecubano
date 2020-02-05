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
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="mainHeading">
                    <h2 class="section-title">Seleccione el plan de promoción</h2>
                </div>
            </div>
            <div class="col-lg-2 col-md-6 col-xs-12">
                <div class="table">
                    <div class="icon">
                        <i class="lni-invest-monitor"></i>
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
                        <del>
                            <li><strong>SMS</strong> masivo</li>
                        </del>
                        <del>
                            <li><strong>Viral</strong> Facebook</li>
                        </del>
                    </ul>
                    <form action="{{ route('post_promote_ad', ['ad' => $ad]) }}" method="POST">
                        @csrf
                        <input type="hidden" name="ad_id" value="{{ $ad->id }}">
                        <input type="hidden" name="promotype" value="1">
                        <button class="btn btn-common" type="submit">Activar Bronce</button>
                    </form>
                </div>
            </div>
            <div class="col-lg-2 col-md-6 col-xs-12">
                <div class="table" id="active-tb">
                    <div class="icon">
                        <i class="lni-invest-monitor"></i>
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
                        <del>
                            <li><strong>SMS</strong> masivo</li>
                        </del>
                        <del>
                            <li><strong>Viral</strong> Facebook</li>
                        </del>
                    </ul>
                    <form action="{{ route('post_promote_ad', ['ad' => $ad]) }}" method="POST">
                        @csrf
                        <input type="hidden" name="ad_id" value="{{ $ad->id }}">
                        <input type="hidden" name="promotype" value="2">
                        <button class="btn btn-common" type="submit">Activar Plata</button>
                    </form>
                </div>
            </div>
            <div class="col-lg-2 col-md-6 col-xs-12">
                <div class="table">
                    <div class="icon">
                        <i class="lni-invest-monitor"></i>
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
                        <del>
                            <li><strong>Viral</strong> Facebook</li>
                        </del>
                    </ul>
                    <form action="{{ route('post_promote_ad', ['ad' => $ad]) }}" method="POST">
                        @csrf
                        <input type="hidden" name="ad_id" value="{{ $ad->id }}">
                        <input type="hidden" name="promotype" value="3">
                        <button class="btn btn-common" type="submit">Activar Oro</button>
                    </form>
                </div>
            </div>
            <div class="col-lg-2 col-md-6 col-xs-12">
                <div class="table">
                    <div class="icon">
                        <i class="lni-invest-monitor"></i>
                    </div>
                    <div class="title">
                        <h3>DIAMANTE</h3>
                    </div>
                    <div class="pricing-header">
                        <p class="price-value"><sup>$</sup>20<span>/ Mes</span></p>
                    </div>
                    <ul class="description">
                        <li><strong>Primero</strong> siempre</li>
                        <li>Listado en <strong>LaChopi</strong></li>
                        <li><strong>30</strong> días</li>
                        <li><strong>100%</strong> activo</li>
                        <li><strong>SMS</strong> masivo</li>
                        <li><strong>Viral</strong> Facebook</li>
                    </ul>
                    <form action="{{ route('post_promote_ad', ['ad' => $ad]) }}" method="POST">
                        @csrf
                        <input type="hidden" name="ad_id" value="{{ $ad->id }}">
                        <input type="hidden" name="promotype" value="4">
                        <button class="btn btn-common" type="submit">Activar Diamante</button>
                    </form>
                </div>
            </div>
            <div class="col-lg-2 col-md-6 col-xs-12">
                <div class="table">
                    <div class="icon">
                        <i class="lni-invest-monitor"></i>
                    </div>
                    <div class="title">
                        <h3>YOUTUBE</h3>
                    </div>
                    <div class="pricing-header">
                        <p class="price-value"><sup>$</sup>50<span>/ Pago único</span></p>
                    </div>
                    <ul class="description">
                        <li><strong>Primero</strong> siempre * 1 mes</li>
                        <li>Listado en <strong>LaChopi</strong></li>
                        <li><strong>30</strong> días</li>
                        <li><strong>100%</strong> activo</li>
                        <li><strong>SMS</strong> masivo</li>
                        <li><strong>Video</strong> en Youtube</li>
                    </ul>
                    <form action="{{ route('post_promote_ad', ['ad' => $ad]) }}" method="POST">
                        @csrf
                        <input type="hidden" name="ad_id" value="{{ $ad->id }}">
                        <input type="hidden" name="promotype" value="5">
                        <button class="btn btn-common" type="submit">Activar Youtube</button>
                    </form>
                </div>
            </div>
            <div class="col-lg-2 col-md-6 col-xs-12">
                <div class="table">
                    <div class="icon">
                        <i class="lni-invest-monitor"></i>
                    </div>
                    <div class="title">
                        <h3>PARTNER</h3>
                    </div>
                    <div class="pricing-header">
                        <p class="price-value"><sup>$</sup>100<span>/ Pago único</span></p>
                    </div>
                    <ul class="description">
                        <li><strong>Primero</strong> siempre * 1 mes</li>
                        <li>Listado en <strong>LaChopi</strong></li>
                        <li><strong>30</strong> días</li>
                        <li><strong>100%</strong> activo</li>
                        <li><strong>SMS</strong> masivo</li>
                        <li><strong>Tienda</strong> Online</li>
                    </ul>
                    <form action="{{ route('post_promote_ad', ['ad' => $ad]) }}" method="POST">
                        @csrf
                        <input type="hidden" name="ad_id" value="{{ $ad->id }}">
                        <input type="hidden" name="promotype" value="6">
                        <button class="btn btn-common" type="submit">Activar Partner</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div id="list-view" class="tab-pane fade active show">
            <div class="row">
                @include('blocks.ad-block-h')
            </div>
        </div>
    </div>
</section>
<!-- Pricing Table Section End -->

@endsection