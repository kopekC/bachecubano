@extends('layouts.app')

@section('content')

@push('style')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.7.5/css/bootstrap-select.min.css">
<link href="{{ asset('css/uppy.min.css') }}" rel="stylesheet">
@endpush

@if($edit)
<style>
    /* Container needed to position the button. Adjust the width as needed */
    .del_container {
        position: relative;
        width: 50%;
    }

    /* Make the image responsive */
    .del_container img {
        width: 100%;
        height: auto;
    }

    /* Style the button and place it in the middle of the container/image */
    .del_container .btn {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        -ms-transform: translate(-50%, -50%);
        padding: 12px 24px;
        border: none;
        cursor: pointer;
    }
</style>
@endif

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

<ol class="breadcrumb">
    <li><a href="{{ config('app.url') }}">Inicio</a></li>
    <li class="ml-2">/</li>
    <li class="current ml-2"> @if($edit) Modificar anuncio @else Publicar anuncio @endif</li>
</ol>

<!-- Start Content -->
<div id="content" class="section-padding">
    <div class="container-fluid">

        <div class="row">

            <div class="col-sm-12 col-md-4 col-lg-3 col-xl-3 page-sidebar d-none d-md-block">
                <!-- Explicit Ad Left Square -->
                <ins class="adsbygoogle" style="display:block" data-ad-client="ca-pub-9876511577005081" data-ad-slot="1908002875" data-ad-format="auto" data-full-width-responsive="true"></ins>
                <script>
                    (adsbygoogle = window.adsbygoogle || []).push({});
                </script>
                <!-- Explicit Ad Left Square -->
            </div>

            <div class="col-sm-12 col-md-8 col-lg-6 col-xl-6">

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

                            <!-- Image grid for Ajax deletion -->
                            @if($edit && isset($ad->resources) && $ad->resources->count() >= 1)
                            <div class="form-group mb-3 p-3">
                                @foreach($ad->resources as $resource)
                                <div class="col-3 del_container">
                                    <img src="{{ ad_image_url($resource) }}" class="img-fluid" alt="{{ text_clean($ad->description->title) }}">
                                    <a class="btn btn-danger btn-sm p-1 delete_ad" href="#!" data-delete-item="{{ $resource->id }}">
                                        <div class="spinner-border spinner-border-sm d-none" role="status"><span class="sr-only">Cargando...</span></div>
                                        <i class="lni-trash"></i>
                                    </a>
                                </div>
                                @endforeach
                            </div>
                            @endif

                            <!-- Images Uppy -->
                            <!--
                            <a href="#" class="btn btn-primary UppyModalOpenerBtn">Subir fotos</a>
                            -->
                            <div class="DashboardContainer"></div>

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
                                            <input class="form-control input-md" name="contact_name" type="text" value="@if($edit){{ $ad->contact_name }}@else{{ old('contact_name', isset(Auth::user()->name) ? Auth::user()->name : '') }}@endif">
                                            @error('name')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-sm-12 col-md-6">
                                        <div class="form-group mb-3">
                                            <label class="control-label">Teléfono *</label>
                                            <input class="form-control input-md" name="phone" type="text" value="@if($edit){{ $ad->phone }}@else{{ old('phone', isset(Auth::user()->phone) ? Auth::user()->phone : '') }}@endif">
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
                                            <input class="form-control input-md" name="contact_email" type="text" value="@if($edit){{ $ad->contact_email }}@else{{ old('contact_email', isset(Auth::user()->email) ? Auth::user()->email : '') }}@endif">
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

                                @guest
                                <div class="row">
                                    <div class="col-md-12 text-center">
                                        {{-- reCaptcha Robot Captcha --}}
                                        @error ('g-recaptcha-response')
                                        <div class="alert alert-danger">
                                            {{ $message }}
                                        </div>
                                        @endif
                                        {!! htmlFormSnippet() !!}
                                    </div>
                                </div>
                                @endguest

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

            <div class="col-sm-12 col-md-4 col-lg-3 col-xl-3 page-sidebar d-none d-md-block">
                <!-- Explicit Ad Left Square -->
                <ins class="adsbygoogle" style="display:block" data-ad-client="ca-pub-9876511577005081" data-ad-slot="1908002875" data-ad-format="auto" data-full-width-responsive="true"></ins>
                <script>
                    (adsbygoogle = window.adsbygoogle || []).push({});
                </script>
                <!-- Explicit Ad Left Square -->
            </div>
        </div>
    </div>
</div>
<!-- End Content -->

<!-- featured Listing -->
@include('blocks.featured-listing')
<!-- featured Listing -->

@if($edit)
@push('script')
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    //like or dislike ad, animate it.
    $('.delete_ad').on('click', function(rsp) {
        var delete_asset = $(this);
        //Show spinner
        delete_asset.children("div").toggleClass('d-none');
        //Hide i element
        delete_asset.children("i").toggleClass('d-none');
        $.post("{{ route('delete-image-ajax') }}?res_id=" + $(this).data("delete-item") + "&api_token=" + user_token, function(data) {
            //Toggle Thumbs
            //like_btn.children("i").toggleClass('lni-thumbs-down');
            //like_btn.children("i").toggleClass('lni-thumbs-up');
            delete_asset.parent().addClass('d-none');
            //Hide spinner
            like_btn.children("div").toggleClass('d-none');
            //Show i element
            like_btn.children("i").toggleClass('d-none');
        });
    });
</script>
@endpush
@endif

@push('script')
<!-- AJAX Uploading for Add Post -->
<script src="{{ asset('js/uppy.min.js') }}"></script>
<script src="{{ asset('js/es_ES.min.js') }}"></script>
<script>
    const uppy = Uppy.Core({
            debug: false,
            autoProceed: true,
            restrictions: {
                maxFileSize: 600000,
                maxNumberOfFiles: 10,
                minNumberOfFiles: 1,
                allowedFileTypes: ['.jpg', '.jpeg', '.png', '.gif']
            },
            locale: Uppy.locales.es_ES
        })
        .use(Uppy.Dashboard, {
            inline: true,
            target: '.DashboardContainer',
            replaceTargetContent: true,
            showProgressDetails: true,
            note: 'Sólo imágenes, hasta 10 fotos, de no más de 800kb',
            height: 350,
            width: '100%',
            metaFields: [{
                    id: 'name',
                    name: 'Name',
                    placeholder: 'Nombre del fichero subido'
                },
                {
                    id: 'caption',
                    name: 'Caption',
                    placeholder: 'Describe la imagen que estás subiendo'
                }
            ],
            browserBackButtonClose: true,
            plugins: ['Webcam']
        })
        .use(Uppy.XHRUpload, {
            endpoint: "{{ route('save-image-ajax') }}",
            formData: true,
            fieldName: 'files[]',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
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

@guest
{!! ReCaptcha::htmlScriptTagJsApi() !!}
@endguest

@endpush
@endsection