<!-- Footer Section Start -->
<footer>
    <!-- Footer Area Start -->
    <section class="footer-Content">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-6 col-mb-12">
                    <div class="widget">
                        <h3 class="footer-logo"><img src="{{ asset('img/logo-bachecubano.png') }}" alt="Bachecubano" width="60" height="60"></h3>
                        <div class="textwidget">
                            <p>Web de negocios, tiendas y clasificados en Cuba. Especialidad en computadoras, celulares, accesorios, electrodomésticos, casas y carros así como sorteos y compras online.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-6 col-mb-12">
                    <div class="widget">
                        <h3 class="block-title">Movida en Instagram</h3>
                        <ul class="media-content-list">
                            <!-- http://instafeedjs.com/ -->
                            <li>
                                <div class="media-left">
                                    <img class="img-fluid" src="{{ asset('img/art/img1.jpg') }}" alt="">
                                    <div class="overlay">
                                        <span class="price">$ 79</span>
                                    </div>
                                </div>
                                <div class="media-body">
                                    <h4 class="post-title"><a href="ads-details.html">Brand New Macbook Pro</a></h4>
                                    <span class="date">12 Jan 2018</span>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-6 col-mb-12">
                    <div class="widget">
                        <h3 class="block-title">Ayuda & soporte</h3>
                        <ul class="menu">
                            <li><a href="https://m.me/Bachecubano">Chatea con Bachecubano</a></li>
                            <li><a href="#privacy-page">Política de Privacidad</a></li>
                            <li><a href="#report-user">Protección de compras</a></li>
                            <li><a href="https://www.bachecubano.net">Reportar un problema</a></li>
                            <li><a href="{{ route('contact') }}">Contáctanos</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-6 col-mb-12">
                    <div class="widget">
                        <h3 class="block-title">Subscríbete a nosotros</h3>
                        <p class="text-sub">Llevamos más de 5 años ofreciendo lo mejor de la compra venta en Cuba, subscríbete a nuestras alertas de gangas por correo.</p>
                        <form method="post" id="subscribe-form" name="subscribe-form" class="validate">
                            <div class="form-group is-empty">
                                <input type="email" value="" name="Email" class="form-control" id="EMAIL" placeholder="Dirección de correo" required="">
                                <button type="submit" name="subscribe" id="subscribes" class="btn btn-common sub-btn"><i class="lni-check-box"></i></button>
                                <div class="clearfix"></div>
                            </div>
                        </form>
                        <ul class="footer-social">
                            <li><a class="facebook" href="https://www.facebook.com/Bachecubano" rel="nofollow"><i class="lni-facebook"></i></a></li>
                            <li><a class="instagram" href="https://www.instagram.com/Bachecubano" rel="nofollow"><i class="lni-instagram"></i></a></li>
                            <li><a class="twitter" href="https://www.twitter.com/Bachecubano" rel="nofollow"><i class="lni-twitter"></i></a></li>
                            <li><a class="linkedin" href="https://www.linkedin.com/company/bachecubano"><i class="lni-linkedin"></i></a></li>
                            <li><a class="telegram" href="https://t.me/elBacheChannel"><i class="lni-telegram"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Footer area End -->

    <!-- Copyright Start  -->
    <div id="copyright">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="site-info float-left">
                        <p>Todos los derechos reservados &copy; {{ date("Y") }} - Desarrollado por <a href="https://www.qvaqui.com">QvaQui</a></p>
                    </div>
                    <div class="float-right">
                        <ul class="bottom-card">
                            <li>
                                <a href="https://www.qvapay.com"><img src="https://www.qvapay.com/favicon-32x32.png" alt="Pasarela de pagos QvaPay" width="34" height="22"></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Copyright End -->

</footer>
<!-- Footer Section End -->