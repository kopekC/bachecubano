@extends('layouts.app')

@section('content')

<!-- Page Header Start -->
<div class="page-header">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="breadcrumb-wrapper">
                    <h1 class="h2 product-title">{{ $ad->description->title }}</h2>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Page Header End -->

<!--
    <ol class="breadcrumb">
    <li><a href="#">Home /</a></li>
    <li class="current">Details</li>
    </ol>
-->

<!-- Ads Details Start -->
<div class="section-padding">
    <div class="container-fluid">
        <!-- Product Info Start -->
        <div class="product-info row">
            <div class="col-lg-4 col-md-12 col-xs-12">
                <div class="details-box ads-details-wrapper">
                    <div id="owl-demo" class="owl-carousel owl-theme">
                        <div class="item">
                            <div class="product-img">
                                <img class="img-fluid" src="{{ asset('img/productinfo/img1.jpg') }}" alt="">
                            </div>
                            <span class="price">{{ ad_price($ad) }}</span>
                        </div>
                        <div class="item">
                            <div class="product-img">
                                <img class="img-fluid" src="{{ asset('img/productinfo/img2.jpg') }}" alt="">
                            </div>
                            <span class="price">{{ ad_price($ad) }}</span>
                        </div>
                        <div class="item">
                            <div class="product-img">
                                <img class="img-fluid" src="{{ asset('img/productinfo/img3.jpg') }}" alt="">
                            </div>
                            <span class="price">{{ ad_price($ad) }}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-5 col-md-12 col-xs-12">
                <div class="description">
                    <div class="details-box">
                        <div class="ads-details-info">
                            <div class="details-meta">
                                <span><a href="#" title="Creado el {{ $ad->created_at->format('d-m-Y') }} a las {{ $ad->created_at->format('H:m') }}"><i class="lni-alarm-clock"></i> {{ $ad->created_at->format("d M, H:m") }}</a></span>
                                <span><a href="#"><i class="lni-map-marker"></i> New York</a></span>
                                <span><a href="#"><i class="lni-eye"></i> {{ $ad->stats->hits > 0 ? $ad->stats->hits : 0 }} Visitas</a></span>
                            </div>
                            <h4 class="title-small mb-3">Detalles del anuncio:</h4>
                            <ul class="list-specification">
                                <li><i class="lni-check-mark-circle"></i> 256GB PCIe flash storage</li>
                                <li><i class="lni-check-mark-circle"></i> 2.7 GHz dual-core Intel Core i5</li>
                            </ul>
                        </div>
                        <ul class="advertisement mb-4">
                            <li>
                                <p><strong><i class="lni-folder"></i> Categories:</strong> <a href="#">Electronics</a></p>
                            </li>
                            <li>
                                <p><strong><i class="lni-archive"></i> Condition:</strong> New</p>
                            </li>
                            <li>
                                <p><strong><i class="lni-package"></i> Brand:</strong> <a href="#">Apple</a></p>
                            </li>
                        </ul>
                    </div>
                    {{ $ad->description->description }}
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-xs-12">
                <!-- Product Description Start -->
                <div class="description-info" style="float: right">
                    <div class="short-info">

                        <div class="ads-btn mb-4">
                            <a href="mailto:{{ $ad->contact_email }}" class="btn btn-common btn-reply"><i class="lni-envelope"></i> Correo</a>
                            <a href="tel:{{ $ad->contact_email }}" class="btn btn-common"><i class="lni-phone-handset"></i> 01154256643</a>
                        </div>

                        <div class="share">
                            <span>Compartir: </span>
                            <div class="social-link">
                                <a class="facebook" href="#"><i class="lni-facebook"></i></a>
                                <a class="twitter" href="#"><i class="lni-twitter"></i></a>
                                <a class="linkedin" href="#"><i class="lni-linkedin"></i></a>
                                <a class="google" href="#"><i class="lni-google-plus"></i></a>
                            </div>
                        </div>

                        <h4 class="mt-4">Perfil de contacto</h4>
                        <ul>
                            <li><a href="#"><i class="lni-users"></i> Anuncios de <span>{{ $ad->contact_name }}</span></a></li>
                            <li><a href="#"><i class="lni-printer"></i> Print this ad</a></li>
                            <li><a href="#"><i class="lni-reply"></i> Send to a friend</a></li>
                            <li><a href="#"><i class="lni-warning"></i> Report this ad</a></li>
                        </ul>
                    </div>
                </div>
                <!-- Product Description End -->
            </div>
        </div>
        <!-- Product Info End -->
    </div>
</div>
<!-- Ads Details End -->

@endsection