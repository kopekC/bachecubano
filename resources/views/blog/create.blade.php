@extends('layouts.app')

@section('content')

@push('style')
<link rel="stylesheet" type="text/css" href="{{ asset('css/trix.css') }}">
<link href="{{ asset('css/uppy.min.css') }}" rel="stylesheet">
@endpush

<!-- Page Header Start -->
<div class="page-header">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="breadcrumb-wrapper">
                    <a href="{{ URL::current() }}">
                        <h2 class="product-title">Crear Publicación</h2>
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
    <li class="ml-2"><a href="{{ URL::current() }}">Publicar noticia</a></li>
</ol>

<!-- Start Content -->
<div id="content" class="section-padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-12 col-xs-12">
                <form action="{{ route('blog.store') }}" method="post" id="create-new">
                    @csrf
                    <div class="form-group mb-3">
                        <label for="title">Título de la noticia</label>
                        <input type="text" name="title" class="form-control" placeholder="Título de la Noticia">
                        @error('title')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <input id="body" type="hidden" name="body">
                        <trix-editor input="body" style="min-height:300px"></trix-editor>
                    </div>

                    <div class="form-group mb-3">
                        <!-- Images Uppy -->
                        <div class="DashboardContainer"></div>
                    </div>

                    <button class="btn btn-common btn-block" type="submit">@if(isset($edit)) Modificar noticia @else Publicar noticia @endif</button>
                </form>
            </div>
            @include('blog.sidebar')
        </div>
    </div>
</div>
<!-- End Content -->

@push('script')
<script type="text/javascript" src="{{ asset('js/trix.js') }}"></script>
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
            note: 'Sólo imágenes, hasta 1 foto, de no más de 600kb',
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
            endpoint: "{{ route('save-cover-image-ajax') }}",
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
            name: 'cover',
            value: response.body.cover
        }).appendTo("#create-new");
    })
</script>
@endpush

@endsection