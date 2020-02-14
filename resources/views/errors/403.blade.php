@extends('layouts.app')

@section('content')
<!-- Page Header Start -->
<div class="page-header">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="breadcrumb-wrapper">
                    <a href="{{ URL::current() }}">
                        <h2 class="product-title">No tienes acceso a esta página</h2>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Page Header End -->

<!-- Start Contact Us Section -->
<section id="content" class="section-padding">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <h5>Lo sentimos, pero no tienes acceso a esta página.</h5>
                <img src="{{ asset('img/bachecubano-working.png') }}" class="img-fluid" loading=lazy>
            </div>
        </div>
    </div>
</section>
<!-- End Contact Us Section  -->
@endsection