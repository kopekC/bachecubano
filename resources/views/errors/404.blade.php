@extends('layouts.app')

@section('content')
<!-- Page Header Start -->
<div class="page-header">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="breadcrumb-wrapper">
                    <a href="{{ URL::current() }}">
                        <h2 class="product-title">Ups, parece que esto ya esto no existe</h2>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Page Header End -->

<!-- Start Contact Us Section -->
<section id="content" class="section-padding  bg-primary">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">                
                <!-- Include Here a Big Search bar -->
                <form class="search-two" action="{{ route('welcome') }}/search" method="get">
                    <div class="search-inner">
                        <div class="row">
                            <div class="col-lg-9 col-md-9">
                                <div class="form-group search-query">
                                    <input type="text" name="query" class="form-control" placeholder="Qué estás buscando hoy" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3">
                                <button class="btn btn-common search-two-submit" type="submit"><i class="lni-search"></i> Buscar</button>
                            </div>
                        </div>
                    </div>
                </form>

                <img src="{{ asset('img/bachecubano-working.png') }}" class="img-fluid" loading=lazy>
            </div>
        </div>
    </div>
</section>
<!-- End Contact Us Section  -->

@endsection