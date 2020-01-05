@extends('layouts.app')

@section('content')
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
                <div id="container-map"></div>
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
                            <span class="detail">Oficina: +53 7 830 6807</span>
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
<!-- load for map -->
<script>
    // Initialize and add the map
    function initMap() {
        // The location of Uluru About London or Any other free Company creation TODO
        var uluru = {
            lat: 23.117155,
            lng: -82.402568
        };
        // The map, centered at Uluru
        var map = new google.maps.Map(
            document.getElementById('container-map'), {
                zoom: 15,
                center: uluru
            });
        // The marker, positioned at Uluru
        var marker = new google.maps.Marker({
            position: uluru,
            map: map
        });
    }
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCnQKzWiXfy41cW22A-YhWyExgJ-gmDTmM&callback=initMap"></script>
@endpush

@endsection