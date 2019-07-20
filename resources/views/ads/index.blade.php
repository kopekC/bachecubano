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
                    <div class="widget_search">
                        <form role="search" id="search-form">
                            <input type="search" class="form-control" autocomplete="off" name="s" placeholder="Buscar..." id="search-input" value="" name="search">
                            <button type="submit" id="search-submit" class="search-btn"><i class="lni-search"></i></button>
                        </form>
                    </div>
                    <!-- Categories Widget -->
                    <div class="widget categories">
                        <h4 class="widget-title">Otras Categorías</h4>
                        <ul class="categories-list">
                            <li>
                                <a href="#">
                                    <i class="lni-dinner"></i>
                                    Hotel & Travels <span class="category-counter">(5)</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="widget">
                        <h4 class="widget-title">Publicidad</h4>
                        <div class="add-box">

                        </div>
                    </div>
                </aside>
            </div>
            <div class="col-lg-10 col-md-12 col-xs-12 page-content">
                <!-- Product filter Start -->
                <div class="product-filter">
                    <div class="short-name">
                        @if($ads)
                        <span>Mostrando (1 - {{ count($ads) }} anuncios de {{ $total_ads }})</span>
                        @else
                        <span>No se han encontrado anuncios</span>
                        @endif
                    </div>
                    <div class="Show-item">
                        <span>Show Items</span>
                        <form class="woocommerce-ordering" method="post">
                            <label>
                                <select name="order" class="orderby">
                                    <option selected="selected" value="menu-order">49 items</option>
                                    <option value="popularity">popularity</option>
                                    <option value="popularity">Average ration</option>
                                    <option value="popularity">newness</option>
                                    <option value="popularity">price</option>
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
                                @if($ads)
                                @foreach($ads as $ad)
                                @include('blocks.ad-block')
                                @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Adds wrapper End -->

                <!-- Start Pagination -->
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
                <!-- End Pagination -->

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