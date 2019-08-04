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
    <div class="container-luid">

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
                                <div class="tg-select form-control">
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
                                <input class="form-control input-md" name="title" placeholder="Título del anuncio a promocionar" type="text">
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

                                <div class="form-group mb-3">
                                    <label class="control-label">Email *</label>
                                    <input class="form-control input-md" name="contact_email" type="text">
                                    @error('email')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="form-group mb-3 tg-inputwithicon">
                                    <label class="control-label">Provincia</label>
                                    <div class="tg-select form-control">
                                        <select name="province">
                                            <option value="la-habana">La Habana</option>
                                        </select>
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
    Dropzone.options.adImageUpload = {
        url: "{{ route('save-image-ajax') }}",
        paramName: "ad-file", //The name that will be used to transfer the file
        maxFilesize: 1,
        uploadMultiple: true,
        maxFiles: 10,
        acceptedFiles: 'image/*',
        addRemoveLinks: true,
        dictDefaultMessage: "Arrastre sus fotos aquí",
        dictInvalidFileType: "El fichero enviado no está permitido",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="token"]').attr('content')
        }
    };
</script>
<!-- Form Validation -->
<script src="{{ asset('js/form-validator.min.js') }}"></script>
@endpush

@endsection