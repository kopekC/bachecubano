@extends('layouts.app')

@section('content')

@push('style')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.7.5/css/bootstrap-select.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.css">
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
    <div class="container-fluid">

        <div class="row">

            <div class="col-sm-12 col-md-4 col-lg-3 col-xl-2 page-sidebar">
                @auth
                @include('user.sidebar')
                @endauth
            </div>

            <div class="col-sm-12 col-md-8 col-lg-6 col-xl-6 offset-xl-1">

                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <form action="{{ route('ad.store') }}" method="POST" name="add" class="form">

                    @csrf

                    <div class="inner-box">
                        <div class="dashboard-box">
                            <h2 class="dashbord-title">Detalles del anuncio:</h2>
                        </div>
                        <div class="dashboard-wrapper">
                            <div class="form-group mb-3 tg-inputwithicon">
                                <label class="control-label">Categoría del anuncio:</label>
                                <div class="tg-select form-control pt-0 pb-0">
                                    <select class="form-control" name="category">
                                        @foreach($parent_categories as $super_category)
                                        <optgroup label="{{ $super_category->description->name }}">
                                            @foreach($category_formatted[$super_category->id] as $category)
                                            <option value="{{ $category->category_id }}" data-tokens="{{ $category->description }}">{{ $category->name }}</option>
                                            @endforeach
                                        </optgroup>
                                        @endforeach
                                    </select>
                                </div>
                                @error('category')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label class="control-label">Título del anuncio:</label>
                                <input class="form-control input-md" name="title" placeholder="Título del anuncio" type="text">
                                @error('title')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-sm-12 col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="control-label">Precio</label>
                                        <input class="form-control input-md" name="price" placeholder="$ 100.00" type="text">
                                    </div>
                                    @error('price')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <div class="form-group mb-3 tg-inputwithicon">
                                        <label class="control-label">Estado</label>
                                        <div class="tg-select form-control  pt-0 pb-0">
                                            <select class="form-control" name="status">
                                                <option value="new">Nuevo</option>
                                                <option value="new">De Uso</option>
                                                <option value="new">Subasta</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group md-3">
                                @error('description')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                                <textarea name="description" class="form-control" rows="8" style="resize: vertical"></textarea>
                            </div>

                            <!-- Drop Zone -->
                            <div class="dropzone" id="ad-image-upload" style="border: 2px dashed #0087F7; border-radius: 5px; background: white;">
                                <div class="fallback">
                                    <input name="file" type="file" multiple />
                                </div>
                            </div>

                            {{--Dropzone Preview Template--}}
                            <div id="preview" style="display: none;">
                                <div class="dz-preview dz-file-preview">
                                    <div class="dz-image"><img data-dz-thumbnail /></div>
                                    <div class="dz-details">
                                        <div class="dz-size"><span data-dz-size></span></div>
                                        <div class="dz-filename"><span data-dz-name></span></div>
                                    </div>
                                    <div class="dz-progress"><span class="dz-upload" data-dz-uploadprogress></span></div>
                                    <div class="dz-error-message"><span data-dz-errormessage></span></div>
                                    <div class="dz-success-mark">
                                        <svg width="54px" height="54px" viewBox="0 0 54 54" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns">
                                            <!-- Generator: Sketch 3.2.1 (9971) - http://www.bohemiancoding.com/sketch -->
                                            <title>Check</title>
                                            <desc>Created with Sketch.</desc>
                                            <defs></defs>
                                            <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" sketch:type="MSPage">
                                                <path d="M23.5,31.8431458 L17.5852419,25.9283877 C16.0248253,24.3679711 13.4910294,24.366835 11.9289322,25.9289322 C10.3700136,27.4878508 10.3665912,30.0234455 11.9283877,31.5852419 L20.4147581,40.0716123 C20.5133999,40.1702541 20.6159315,40.2626649 20.7218615,40.3488435 C22.2835669,41.8725651 24.794234,41.8626202 26.3461564,40.3106978 L43.3106978,23.3461564 C44.8771021,21.7797521 44.8758057,19.2483887 43.3137085,17.6862915 C41.7547899,16.1273729 39.2176035,16.1255422 37.6538436,17.6893022 L23.5,31.8431458 Z M27,53 C41.3594035,53 53,41.3594035 53,27 C53,12.6405965 41.3594035,1 27,1 C12.6405965,1 1,12.6405965 1,27 C1,41.3594035 12.6405965,53 27,53 Z" id="Oval-2" stroke-opacity="0.198794158" stroke="#747474" fill-opacity="0.816519475" fill="#FFFFFF" sketch:type="MSShapeGroup"></path>
                                            </g>
                                        </svg>

                                    </div>
                                    <div class="dz-error-mark">
                                        <svg width="54px" height="54px" viewBox="0 0 54 54" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns">
                                            <!-- Generator: Sketch 3.2.1 (9971) - http://www.bohemiancoding.com/sketch -->
                                            <title>error</title>
                                            <desc>Created with Sketch.</desc>
                                            <defs></defs>
                                            <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" sketch:type="MSPage">
                                                <g id="Check-+-Oval-2" sketch:type="MSLayerGroup" stroke="#747474" stroke-opacity="0.198794158" fill="#FFFFFF" fill-opacity="0.816519475">
                                                    <path d="M32.6568542,29 L38.3106978,23.3461564 C39.8771021,21.7797521 39.8758057,19.2483887 38.3137085,17.6862915 C36.7547899,16.1273729 34.2176035,16.1255422 32.6538436,17.6893022 L27,23.3431458 L21.3461564,17.6893022 C19.7823965,16.1255422 17.2452101,16.1273729 15.6862915,17.6862915 C14.1241943,19.2483887 14.1228979,21.7797521 15.6893022,23.3461564 L21.3431458,29 L15.6893022,34.6538436 C14.1228979,36.2202479 14.1241943,38.7516113 15.6862915,40.3137085 C17.2452101,41.8726271 19.7823965,41.8744578 21.3461564,40.3106978 L27,34.6568542 L32.6538436,40.3106978 C34.2176035,41.8744578 36.7547899,41.8726271 38.3137085,40.3137085 C39.8758057,38.7516113 39.8771021,36.2202479 38.3106978,34.6538436 L32.6568542,29 Z M27,53 C41.3594035,53 53,41.3594035 53,27 C53,12.6405965 41.3594035,1 27,1 C12.6405965,1 1,12.6405965 1,27 C1,41.3594035 12.6405965,53 27,53 Z" id="Oval-2" sketch:type="MSShapeGroup"></path>
                                                </g>
                                            </g>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            {{--End of Dropzone Preview Template--}}
                        </div>
                    </div>

                    <div class="inner-box">
                        <div class="tg-contactdetail">
                            <div class="dashboard-box">
                                <h2 class="dashbord-title">Detalles de contacto:</h2>
                            </div>
                            <div class="dashboard-wrapper">
                                <div class="row">

                                    <div class="col-sm-12 col-md-6">
                                        <div class="form-group mb-3">
                                            <label class="control-label">Nombre *</label>
                                            <input class="form-control input-md" name="contact_name" type="text">
                                            @error('name')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-sm-12 col-md-6">
                                        <div class="form-group mb-3">
                                            <label class="control-label">Teléfono *</label>
                                            <input class="form-control input-md" name="phone" type="text">
                                            @error('phone')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                </div>

                                <div class="row">

                                    <div class="col-sm-12 col-md-6">
                                        <div class="form-group mb-3">
                                            <label class="control-label">Email *</label>
                                            <input class="form-control input-md" name="contact_email" type="text">
                                            @error('email')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-sm-12 col-md-6">
                                        <div class="form-group mb-3 tg-inputwithicon">
                                            <label class="control-label">Provincia</label>
                                            <div class="tg-select form-control">
                                                <select name="province">
                                                    <option value="la-habana">La Habana</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div class="tg-checkbox">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="tg-agreetermsandrules" name="agree" checked>
                                        <label class="custom-control-label" for="tg-agreetermsandrules">Estoy de acuerdo con los <a href="#">Términos &amp; Condiciones</a></label>
                                        @error('agree')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.js"></script>
<script>
    var total_photos_counter = 0;
    Dropzone.options.adImageUpload = {
        uploadMultiple: true,
        maxFilesize: 0.3,
        addRemoveLinks: true,
        dictDefaultMessage: "Arrastre sus fotos aquí",
        dictInvalidFileType: "El fichero enviado no está permitido",
        dictRemoveFile: 'Eliminar Foto',
        dictFileTooBig: 'La imagen es demasiado grande',
        timeout: 10000,

        url: "{{ route('save-image-ajax') }}",
        paramName: "photo",
        maxFiles: 10,
        acceptedFiles: 'image/*',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="token"]').attr('content')
        }
    };
</script>
<!-- Form Validation -->
<script src="{{ asset('js/form-validator.min.js') }}"></script>
@endpush

@endsection