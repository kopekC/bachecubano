@extends('layouts.app')

@section('content')

@push('style')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.7.5/css/bootstrap-select.min.css">
<link href="https://transloadit.edgly.net/releases/uppy/v1.8.0/uppy.min.css" rel="stylesheet">
@endpush

<!-- Page Header Start -->
<div class="page-header">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="breadcrumb-wrapper">
                    <a href="{{ URL::current() }}">
                        <h1 class="h2 product-title">@if($edit) Modificar anuncio @else Publicar anuncio @endif</h1>
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

            <div class="col-sm-12 col-md-4 col-lg-3 col-xl-3 page-sidebar d-none d-md-block">
                @auth
                @include('user.sidebar')
                @endauth
            </div>

            <div class="col-sm-12 col-md-8 col-lg-6 col-xl-6">

                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <form action="@if($edit){{ route('ad.update', ['ad' => $ad]) }}@else{{ route('ad.store') }}@endif" method="POST" name="add" class="form" id="add">
                    @csrf

                    @if($edit)
                    <input type="hidden" name="edit" value="{{ $ad->id }}">
                    @method('PUT')
                    @endif

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
                                            <option value="{{ $category->category_id }}" @if($edit==true && $ad->category_id == $category->category_id) selected="" @endif>{{ $category->name }}</option>
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
                                <input class="form-control input-md" name="title" placeholder="Título del anuncio" type="text" value="@if($edit){{ $ad->description->title }}@else{{ old('title') }}@endif">
                                @error('title')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-sm-12 col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="control-label">Precio</label>
                                        <input class="form-control input-md" name="price" placeholder="$ 100.00" type="text" value="@if($edit){{ $ad->price }}@else{{ old('price', '0') }}@endif">
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
                                <textarea name="description" class="form-control" rows="8" style="resize: vertical">@if($edit){!! $ad->description->description !!}@else{!! old('description') !!}@endif</textarea>
                            </div>

                            <!-- Drop Zone 
                            <div class="dropzone" id="ad-image-upload" style="border: 2px dashed #0087F7; border-radius: 5px; background: white;">
                                <div class="fallback">
                                    <input name="file" type="file" multiple />
                                </div>
                            </div>
                            -->
                            <div class="DashboardContainer">

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
                                            <input class="form-control input-md" name="contact_name" type="text" value="@if($edit){{ $ad->contact_name }}@else{{ old('contact_name', optional(Auth::user())->name) }}@endif">
                                            @error('name')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-sm-12 col-md-6">
                                        <div class="form-group mb-3">
                                            <label class="control-label">Teléfono *</label>
                                            <input class="form-control input-md" name="phone" type="text" value="@if($edit){{ $ad->phone }}@else{{ old('phone', optional(Auth::user()->phone)) }}@endif">
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
                                            <input class="form-control input-md" name="contact_email" type="text" value="@if($edit){{ $ad->contact_email }}@else{{ old('contact_email', optional(Auth::user()->email)) }}@endif">
                                            @error('email')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-sm-12 col-md-6">
                                        <div class="form-group mb-3 tg-inputwithicon">
                                            <label class="control-label">Provincia</label>
                                            <div class="tg-select form-control  pt-0 pb-0">
                                                <select name="ad_region">
                                                    @if(isset($regions))
                                                    <option value="737586" @if($edit==true && $ad->region_id == 737586) selected="" @endif>La Habana</option>
                                                    @foreach($regions as $region)
                                                    @if($region->id == 737586)
                                                    @continue
                                                    @endif
                                                    <option value="{{ $region->id }}" @if($edit==true && $ad->region_id == $region->id) selected="" @endif>{{ $region->name }}</option>
                                                    @endforeach
                                                    @endif
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

                                <button class="btn btn-common btn-block" type="submit">@if($edit) Modificar anuncio @else Publicar anuncio @endif</button>
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
<!-- AJAX Uploading for Add Post -->
<script src="https://transloadit.edgly.net/releases/uppy/v1.8.0/uppy.min.js"></script>
<script src="https://transloadit.edgly.net/releases/uppy/locales/v1.11.0/es_ES.min.js"></script>
<script>
    const uppy = Uppy.Core({
            debug: true,
            autoProceed: true,
            restrictions: {
                maxFileSize: 500000,
                maxNumberOfFiles: 10,
                minNumberOfFiles: 1,
                allowedFileTypes: ['image/*']
            },
            locale: Uppy.locales.es_ES
        })
        .use(Uppy.Dashboard, {
            trigger: '.UppyModalOpenerBtn',
            inline: true,
            target: '.DashboardContainer',
            replaceTargetContent: true,
            showProgressDetails: true,
            note: 'Images and video only, 2–3 files, up to 1 MB',
            height: 470,
            metaFields: [{
                    id: 'name',
                    name: 'Name',
                    placeholder: 'file name'
                },
                {
                    id: 'caption',
                    name: 'Caption',
                    placeholder: 'describe what the image is about'
                }
            ],
            browserBackButtonClose: true
        })
        .use(Uppy.XHRUpload, {
            endpoint: "{{ route('save-image-ajax') }}",
            formData: true,
            fieldName: 'files[]',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="token"]').attr('content')
            },
        })
    uppy.on('upload-success', (file, response) => {
        response.status // HTTP status code
        response.body // extracted response data
        // do something with file and response
        $('<input>', {
            type: 'hidden',
            name: 'imageID[]',
            value: response.body.imageID
        }).appendTo("#add");
    })
    uppy.on('complete', result => {
        console.log('successful files:', result.successful)
        console.log('failed files:', result.failed)
    })
</script>
<!-- Form Validation 
<script src="{{ asset('js/form-validator.min.js') }}"></script>-->
@endpush

@endsection