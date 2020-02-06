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

<!-- Bread Crumbs -->
<ol class="breadcrumb">
    <li><a href="{{ config('app.url') }}">Inicio</a></li>
    <li class="ml-2">/</li>
    @if(isset($sub_category->name))
    <li class="ml-2"><a href="{{ config('app.url') . $super_category->slug }}/">{{ $super_category->name }}</a></li>
    <li class="ml-2">/</li>
    <li class="current ml-2">{{ $sub_category->name }}</li>
    @else
    <li class="current ml-2">{{ $super_category->name }}</li>
    @endif
</ol>

<!-- Main container Start -->
<div class="main-container section-padding">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-2 col-md-12 col-xs-12 page-sidebar">
                <aside>
                    <!-- Search Widget -->
                    <form role="search" id="search-form" method="get">
                        <!-- Show here as hidden elements all input parameters by now -->
                        <div class="widget categories p-2">

                            <h4 class="widget-title">Filtrado</h4>

                            <!-- Search Box -->
                            <input type="search" class="form-control mb-1" autocomplete="on" name="s" placeholder="Buscar..." id="search-input" value="@if($request->has('s')){{$request->input('s')}}@endif">

                            <!-- Min Price -->
                            <input type="number" class="form-control mb-1" autocomplete="on" name="min_price" placeholder="Precio Min" value="{{$request->input('min_price', '')}}">

                            <!-- Max Price -->
                            <input type="number" class="form-control mb-1" autocomplete="on" name="max_price" placeholder="Precio Max" value="{{$request->input('max_price', '')}}">

                            <!-- CheckBox with only photos -->
                            <div class="custom-checkbox ml-2 mb-2">
                                <input type="checkbox" class="form-control-input mb-1" name="only_photos" @if($request->has('only_photos')) checked @endif>
                                <label>Sólo anuncios con fotos</label>
                            </div>

                            <!-- CheckBox with only Affiliates Stores -->
                            <div class="custom-checkbox ml-2 mb-2">
                                <input type="checkbox" class="form-control-input mb-1" name="only_stores" @if($request->has('only_stores')) checked @endif>
                                <label>Sólo tiendas asociadas</label>
                            </div>

                            <!--Hidden Fields -->
                            @if($request->has('order_by'))
                            <input type="hidden" name="order_by" value="{{ $request->order_by }}">
                            @endif

                            <button type="submit" class="btn btn-primary btn-block"><i class="lni-search"></i></button>
                        </div>
                    </form>

                    <!-- Categories Widget -->
                    @if(isset($super_category->category_id) && is_array($category_formatted[$super_category->category_id]) && count($category_formatted[$super_category->category_id])>0)
                    <div class="widget categories d-none d-lg-block">
                        <h4 class="widget-title">Otras categorías:</h4>
                        <ul class="categories-list">
                            @foreach($category_formatted[$super_category->category_id] as $sub_category)
                            <li>
                                <a href="{{ route('category_index', ['category' => $super_category->slug, 'subcategory' => $sub_category->slug]) }}">
                                    <i class="lni-{{ $super_category->category->icon }}"></i>
                                    {{ $sub_category->name }}
                                </a>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <!-- Explicit Ad Left Square -->
                    <ins class="adsbygoogle" style="display:block" data-ad-client="ca-pub-9876511577005081" data-ad-slot="1908002875" data-ad-format="auto" data-full-width-responsive="true"></ins>
                    <script>
                        (adsbygoogle = window.adsbygoogle || []).push({});
                    </script>
                    <!-- Explicit Ad Left Square -->

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
                        <span class="ml-3">Orden: </span>
                        <form class="woocommerce-ordering" method="post">
                            <label>
                                <select name="order" class="orderby" onchange="this.options[this.selectedIndex].value && (window.location = '?order_by=' + this.options[this.selectedIndex].value);">
                                    <option @if($request->has('order_by') && $request->order_by == 'updated_at') selected @endif value="updated_at">Fecha Modificación</option>
                                    <option @if($request->has('order_by') && $request->order_by == 'popularity') selected @endif value="popularity">Popularidad</option>
                                    <option @if($request->has('order_by') && $request->order_by == 'lower_price') selected @endif value="lower_price">Menor Precio</option>
                                    <option @if($request->has('order_by') && $request->order_by == 'greather_price') selected @endif value="greather_price">Mayor Precio</option>
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

                                <!-- Iterate over every Ads result set -->
                                @foreach($ads as $ad)
                                @include('blocks.ad-block')
                                @endforeach

                                @else
                                <!-- no ads found -->
                                <div class="col-md-12 col-lg-12 col-xs-12 text-center">
                                    <div class="contents">
                                        <div class="search-two-form">
                                            <form class="search-two" action="{{ route('welcome') }}/search" method="get">
                                                <div class="search-inner">
                                                    <div class="row">
                                                        <div class="col-lg-9 col-md-9">
                                                            <div class="form-group search-query">
                                                                <input type="text" name="s" class="form-control" placeholder="Qué estás buscando hoy" autocomplete="on">
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
                                                            <button class="btn btn-common search-two-submit" type="submit"><i class="lni-search"></i> Buscar</button>
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

            </div>
        </div>
    </div>
</div>
<!-- Main container End -->

@endsection