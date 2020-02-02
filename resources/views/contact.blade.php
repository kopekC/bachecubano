@extends('layouts.app')

@section('content')

@push('style')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css" integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ==" crossorigin="" />
<script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js" integrity="sha512-gZwIG9x3wUXg2hdXF6+rVkLF/0Vi9U8D2Ntg4Ga5I5BZpVkVxlJWbSQtXPSiUTtC0TjtGOmxa1AJPuV0CPthew==" crossorigin=""></script>
@endpush

<!-- Page Header Start -->
<div class="page-header">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="breadcrumb-wrapper">
                    <a href="{{ URL::current() }}">
                        <h2 class="product-title">Contáctanos</h2>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Page Header End -->

<!-- Map Section Start -->
<section id="google-map-area">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div id="mapid" style="height: 280px;"></div>
                <!--
                <div id="container-map"></div>
                -->
            </div>
        </div>
    </div>
</section>
<!-- Map Section End -->

<!-- Start Contact Us Section -->
<section id="content" class="section-padding">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-8 col-lg-9">
                <h2 class="contact-title">
                    Envíanos un Mensaje
                </h2>
                <!-- Form -->
                <form id="contactForm" class="contact-form" data-toggle="validator" action="{{ route('contact_submit') }}" method="POST">
                    @csrf

                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="name" name="name" placeholder="Nombre" required data-error="Por favor teclee su nombre">
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <input type="email" class="form-control" id="email" name="email" placeholder="Correo" required data-error="Por favor teclee su correo">
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="msg_subject" name="subject" placeholder="Asunto" required data-error="Por favor teclee el asunto de su solicitud">
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-12 col-lg-12">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <textarea class="form-control" placeholder="Mensaje a enviarnos" name="message" rows="10" data-error="Escriba aquí su mensaje y le respondemos en menos de 48 horas" required></textarea>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 text-center">
                            {{-- reCaptcha Robot Captcha --}}
                            @error ('g-recaptcha-response')
                            <div class="alert alert-danger">
                                {{ $message }}
                            </div>
                            @endif
                            {!! htmlFormSnippet() !!}
                        </div>

                        <div class="col-md-12 text-center">
                            <button type="submit" id="submit" class="btn btn-common"><i class="lni-telegram"></i> Enviar</button>
                        </div>

                    </div>
                </form>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-3">
                <h2 class="contact-title">
                    Mantenerte en contacto
                </h2>
                <div class="information">
                    <p>Con {{ date('Y') - 2014 }} años en el negocio de clasificados y compra/venta en Cuba. Somos pioneros en el comercio electrónico cubano así como la gestion de tiendas virtuales para sus productos.</p>
                    <div class="contact-datails">
                        <div class="icon">
                            <i class="lni-map-marker icon-radius"></i>
                        </div>
                        <div class="info">
                            <h3>Dirección</h3>
                            <span class="detail">Calle 35 #1477, <br> entre 26 y 28, Nuevo Vedado, Cuba</span>
                        </div>
                    </div>
                    <div class="contact-datails">
                        <div class="icon">
                            <i class="lni-pointer icon-radius"></i>
                        </div>
                        <div class="info">
                            <h3>Preguntas?</h3>
                            <span class="detail">contact@bachecubano.com</span>
                        </div>
                    </div>
                    <div class="contact-datails">
                        <div class="icon">
                            <i class="lni-phone-handset icon-radius"></i>
                        </div>
                        <div class="info">
                            <h3>Llámanos</h3>
                            <span class="detail">Oficina: +53 7 642 5371</span>
                        </div>
                    </div>
                    <div class="contact-datails">
                        <div class="icon">
                            <i class="lni-phone icon-radius"></i>
                        </div>
                        <div class="info">
                            <h3>Celular</h3>
                            <span class="detail">(+53) 5 514 9081</span>
                            <br>
                            <span class="detail">(+53) 5 466 3598</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Contact Us Section  -->

@push('script')
{!! ReCaptcha::htmlScriptTagJsApi() !!}
@endpush

@push('script')
<script>
    var mymap = L.map('mapid').setView([23.10193, -82.37215], 18);
    var marker = L.marker([23.10193, -82.37215]).addTo(mymap);
    L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
        maxZoom: 18,
        attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, ' + '<a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' + 'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
        id: 'mapbox/streets-v11'
    }).addTo(mymap);
</script>
@endpush

@endsection