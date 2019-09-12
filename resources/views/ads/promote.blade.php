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
                    <h2 class="section-title">Select Package</h2>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-xs-12">
                <div class="table">
                    <div class="icon">
                        <i class="lni-gift"></i>
                    </div>
                    <div class="title">
                        <h3>SILVER</h3>
                    </div>
                    <div class="pricing-header">
                        <p class="price-value"><sup>$</sup>29<span>/ Mo</span></p>
                    </div>
                    <ul class="description">
                        <li><strong>Free</strong> ad posting</li>
                        <li><strong>No</strong> Featured ads availability</li>
                        <li><strong>For 30</strong> days</li>
                        <li><strong>100%</strong> Secure!</li>
                    </ul>
                    <button class="btn btn-common">Buy Now</button>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-xs-12">
                <div class="table" id="active-tb">
                    <div class="icon">
                        <i class="lni-leaf"></i>
                    </div>
                    <div class="title">
                        <h3>STANDARD</h3>
                    </div>
                    <div class="pricing-header">
                        <p class="price-value"><sup>$</sup>89<span>/ Mo</span></p>
                    </div>
                    <ul class="description">
                        <li><strong>Free</strong> ad posting</li>
                        <li><strong>6</strong> Featured ads availability</li>
                        <li><strong>For 30</strong> days</li>
                        <li><strong>100%</strong> Secure!</li>
                    </ul>
                    <button class="btn btn-common">Buy Now</button>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-xs-12">
                <div class="table">
                    <div class="icon">
                        <i class="lni-layers"></i>
                    </div>
                    <div class="title">
                        <h3>PLANINIUM</h3>
                    </div>
                    <div class="pricing-header">
                        <p class="price-value"><sup>$</sup>99<span>/ Mo</span></p>
                    </div>
                    <ul class="description">
                        <li><strong>Free</strong> ad posting</li>
                        <li><strong>20</strong> Featured ads availability</li>
                        <li><strong>For 25</strong> days</li>
                        <li><strong>100%</strong> Secure!</li>
                    </ul>
                    <button class="btn btn-common">Buy Now</button>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Pricing Table Section End -->

@endsection