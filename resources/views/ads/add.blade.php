@extends('layouts.app')

@section('content')

@push('style')
<link href="https://transloadit.edgly.net/releases/uppy/v1.3.0/uppy.min.css" rel="stylesheet">
@endpush

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

                            <!-- Drop Zone with edgly -->
                            <div class="UppyDragDrop"></div>

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
<!-- AJAX Uploading -->
<script src="https://transloadit.edgly.net/releases/uppy/v1.3.0/uppy.min.js"></script>
<script src="https://transloadit.edgly.net/releases/uppy/locales/v1.5.0/es_ES.min.js"></script>
<script>
    /*
    var uppy = Uppy.Core()
    uppy.use(Uppy.DragDrop, {
        target: '.UppyDragDrop',
        debug: true,
        autoProceed: true,
        locale: Uppy.locales.es_ES,
        endpoint: "{{ route('save-image-ajax') }}",
    })
    */

    var uppy = Uppy.Core({
        id: 'ad-upload',
        allowMultipleUploads: true,
        restrictions: {
            maxFileSize: 307200,
            maxNumberOfFiles: 10,
            allowedFileTypes: ['image/*', '.jpg', '.jpeg', '.png']
        },
        debug: true,
        autoProceed: true,
        locale: Uppy.locales.es_ES,
        meta: {
            destination: 'Ad'
        },
        
    });
    uppy.use(Uppy.DragDrop, {
        target: '.UppyDragDrop'
    });
    uppy.use(Uppy.ProgressBar, {
        target: 'body',
        fixed: true,
        hideAfterFinish: false
    });
    uppy.use(Uppy.Tus, {
        endpoint: "{{ route('save-image-ajax') }}",
    });

    console.log('--> Uppy pre-built version with Tus, DragDrop & Spanish language pack has loaded');
</script>

<!-- Form Validation -->
<script src="{{ asset('js/form-validator.min.js') }}"></script>
@endpush

@endsection