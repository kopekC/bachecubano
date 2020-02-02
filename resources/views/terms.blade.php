@extends('layouts.app')

@section('content')

<!-- Page Header Start -->
<div class="page-header">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="breadcrumb-wrapper">
                    <a href="{{ URL::current() }}">
                        <h2 class="product-title">Términos y Condiciones</h2>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Page Header End -->

<!-- Start Contact Us Section -->
<section id="content" class="section-padding">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-8 col-lg-9">
                
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

@endsection