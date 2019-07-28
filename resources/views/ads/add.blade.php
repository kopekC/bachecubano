@extends('layouts.app')

@section('content')

<!-- Page Header Start -->
<div class="page-header">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="breadcrumb-wrapper">
                    <a href="{{ route('add') }}">
                        <h1 class="h2 product-title">Publicar anuncio</h1>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Page Header End -->

<!-- Start Content -->
<div id="content" class="section-padding">
    <div class="container-luid">

        <div class="row">

            <div class="col-sm-12 col-md-4 col-lg-3 page-sidebar">
                @auth
                @include('user.sidebar')
                @endauth
            </div>

            <div class="col-sm-12 col-md-4 col-lg-6">

                <form action="{{ route('ad.store') }}" method="POST" name="add" class="form">

                    @csrf

                    <div class="inner-box">
                        <div class="dashboard-box">
                            <h2 class="dashbord-title">Detalles del anuncio:</h2>
                        </div>
                        <div class="dashboard-wrapper">
                            <div class="form-group mb-3">
                                <label class="control-label">Título del anuncio:</label>
                                <input class="form-control input-md" name="title" placeholder="Título del anuncio a promocionar" type="text">
                            </div>
                            <div class="form-group mb-3 tg-inputwithicon">
                                <label class="control-label">Categoría del anuncio:</label>
                                <div class="tg-select form-control">
                                    <select name="category">
                                        <option value="none">Seleccione la categoría</option>
                                        <option value="none">Mobiles</option>
                                        <option value="none">Electronics</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group mb-3">
                                <label class="control-label">Precio</label>
                                <input class="form-control input-md" name="price" placeholder="$ 1000.00" type="text">
                            </div>
                            <div class="form-group md-3">
                                <textarea name="description" class="form-control" rows="8" style="resize: vertical"></textarea>
                            </div>
                            <label class="tg-fileuploadlabel" for="tg-photogallery">
                                <span>Arrastre aquí las fotos del anuncio</span>
                                <span>O</span>
                                <span class="btn btn-common">Seleccione las fotos</span>
                                <span>Tamaño máximo para cada foto: 300 KB</span>
                                <input id="tg-photogallery" class="tg-fileinput" type="file" name="file">
                            </label>
                        </div>
                    </div>

                    <div class="inner-box">
                        <div class="tg-contactdetail">
                            <div class="dashboard-box">
                                <h2 class="dashbord-title">Detalles de contacto:</h2>
                            </div>
                            <div class="dashboard-wrapper">
                                <div class="form-group mb-3">
                                    <label class="control-label">Nombre *</label>
                                    <input class="form-control input-md" name="name" type="text">
                                </div>
                                <div class="form-group mb-3">
                                    <label class="control-label">Teléfono *</label>
                                    <input class="form-control input-md" name="phone" type="text">
                                </div>
                                <div class="form-group mb-3">
                                    <label class="control-label">Email *</label>
                                    <input class="form-control input-md" name="address" type="text">

                                </div>
                                <div class="form-group mb-3 tg-inputwithicon">
                                    <label class="control-label">Provincia</label>
                                    <div class="tg-select form-control">
                                        <select>
                                            <option value="none">Select State</option>
                                            <option value="none">Select State</option>
                                            <option value="none">Select State</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="tg-checkbox">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="tg-agreetermsandrules">
                                        <label class="custom-control-label" for="tg-agreetermsandrules">I agree to all <a href="javascript:void(0);">Terms of Use &amp; Posting Rules</a></label>
                                    </div>
                                </div>
                                <button class="btn btn-common btn-block" type="submit">Publicar anuncio</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- End Content -->

<!-- featured Listing -->
@include('blocks.featured-listing')
<!-- featured Listing -->

@push('script')
<script src="{{ asset('js/form-validator.min.js') }}"></script>
@endpush

@endsection