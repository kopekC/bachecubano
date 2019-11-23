@extends('layouts.app')

@section('content')

<!-- Page Header Start -->
<div class="page-header">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="breadcrumb-wrapper">
                    <a href="{{ URL::current() }}">
                        <h1 class="h2 text-white">{{ isset($sub_category->name) ? $sub_category->name : $super_category->name }}</h1>
                    </a>
                    <h2 class="h6 text-white">{{ isset($sub_category->description) ? $sub_category->description : $super_category->description }}</h2>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Page Header End -->

<!--
    <ol class="breadcrumb">
    <li><a href="#">Home /</a></li>
    <li class="current">Listing</li>
    </ol>
-->

<!-- Main container Start -->
<div class="main-container section-padding">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-2 col-md-12 col-xs-12 page-sidebar">
                <aside>
                    <!-- Searcg Widget -->
                    <form role="search" id="search-form" method="get">

                        <!-- Show here as hidden elements all input parameters by now -->
                        <!--TODO Un foreach de cada input? -->

                        <div class="widget categories p-2">

                            <h4 class="widget-title">Filtrado</h4>

                            <!-- Search Box -->
                            <input type="search" class="form-control mb-1" autocomplete="on" name="s" placeholder="Buscar..." id="search-input" value="@if($request->has('s')){{$request->input('s')}}@endif">

                            <!-- Min Price -->
                            <input type="number" class="form-control mb-1" autocomplete="on" name="min_price" placeholder="Precio Min" value="{{$request->input('min_price', '')}}">

                            <!-- Max Price -->
                            <input type="number" class="form-control mb-1" autocomplete="on" name="max_price" placeholder="Precio Max" value="{{$request->input('max_price', '')}}">

                            <!-- CheckBox with only photos -->
                            <div class="custom-checkbox ml-2">
                                <input type="checkbox" class="form-control-input mb-1" name="only_photos" @if($request->has('only_photos')) checked @endif>
                                <label>Sólo anuncios con fotos</label>
                            </div>

                            <!-- CheckBox with only Affiliates Stores -->
                            <div class="custom-checkbox ml-2">
                                <input type="checkbox" class="form-control-input mb-1" name="only_stores" @if($request->has('only_stores')) checked @endif>
                                <label>Sólo tiendas asociadas</label>
                            </div>

                            <button type="submit" class="btn btn-primary btn-block"><i class="lni-search"></i></button>
                        </div>
                    </form>
                    <div class="widget d-none d-lg-block">
                        <h4 class="widget-title">Publicidad</h4>
                        <div class="add-box"></div>
                    </div>
                </aside>
            </div>
            <div class="col-lg-10 col-md-12 col-xs-12 page-content">
                <!-- Product filter Start -->
                <div class="product-filter">
                    <div class="short-name d-none d-lg-block">
                        @if($ads->total() >= 1)
                        <span>Mostrando (1 - {{ count($ads) }} anuncios de {{ $total_ads }})</span>
                        @else
                        <span>No se han encontrado anuncios</span>
                        @endif
                    </div>
                    <div class="Show-item">
                        <span>Anuncios por página:</span>
                        @foreach(config('constants.posts_per_page_options') as $page_option)
                        @if($page_option == $posts_per_page)
                        <span>{{ $page_option }}</span>
                        @else
                        <a href="{{ URL::full() }}?posts_per_page={{ $page_option }}">{{ $page_option }}</a>
                        @endif
                        @endforeach
                        <span class="ml-3">Orden: </span>
                        <form class="woocommerce-ordering" method="post">
                            <label>
                                <select name="order" class="orderby">
                                    <option selected="selected" value="updated_at">Fecha Modificación</option>
                                    <option value="popularity">Popularidad</option>
                                    <option value="lower_price">Menor Precio</option>
                                    <option value="greather_price">Mayor Precio</option>
                                </select>
                            </label>
                        </form>
                    </div>
                </div>
                <!-- Product filter End -->

                <!-- Adds wrapper Start -->
                <div class="adds-wrapper">
                    <div class="tab-content">
                        <div id="grid-view" class="tab-pane fade active show">
                            <div class="row">
                                @if($ads->total() >= 1)
                                @foreach($ads as $ad)
                                @include('blocks.ad-block')
                                @endforeach
                                @else
                                <div class="col-md-12 col-lg-12 col-xs-12 text-center">
                                    <div class="contents">
                                        <div class="search-two-form">
                                            <form class="search-two" action="{{ route('welcome') }}/search" method="get">
                                                <div class="search-inner">
                                                    <div class="row">
                                                        <div class="col-lg-9 col-md-9">
                                                            <div class="form-group search-query">
                                                                <input type="text" name="s" class="form-control" placeholder="Qué estas buscando hoy" autocomplete="on">
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
                                        </div>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Adds wrapper End -->

                <!-- Laravel Pagination -->
                <div class="pagination-bar">
                    {{ $ads->links() }}
                </div>

                <!-- Start Pagination
                <div class="pagination-bar">
                    <nav>
                        <ul class="pagination justify-content-center">
                            <li class="page-item"><a class="page-link active" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item"><a class="page-link" href="#">Next</a></li>
                        </ul>
                    </nav>
                </div>
                End Pagination -->

            </div>
        </div>
    </div>
</div>
<!-- Main container End -->

@push('script')
<script>
</script>
@endpush

@endsection