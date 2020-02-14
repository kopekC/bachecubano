@extends('layouts.app')

@section('content')
<!-- Page Header Start -->
<div class="page-header">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="breadcrumb-wrapper">
                    <a href="{{ URL::current() }}">
                        <h2 class="product-title">No abuses, deja recursos para los demás.</h2>
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
                <h5>Al parecer estás abusando de los recursos del servidor, intenta más tarde. 😢👍🏼</h5>
                <img src="{{ asset('img/bachecubano-working.png') }}" class="img-fluid" loading=lazy>
            </div>
        </div>
    </div>
</section>
<!-- End Contact Us Section  -->
@endsection