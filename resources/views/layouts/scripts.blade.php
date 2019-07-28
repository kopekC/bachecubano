<!-- Schema Markup Unescaped -->
@if(isset($SchemaLD))
{!! $SchemaLD !!}
@endif

<!-- Images LazyLoad -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/lazysizes/5.1.0/lazysizes.min.js" async="async"></script>
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js" async="async"></script>
<!-- Twitter Bootstrap & Behaviors -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.15.0/popper.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.min.js" async="async"></script>
<!-- Carousell -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js" async="async"></script>
<!-- Responsive Navigation Menu -->
<script src="{{ asset('js/jquery.slicknav.js') }}"></script>


<!-- Checkout This: -->
<script src="{{ asset('js/waypoints.min.js') }}"></script>
<script src="{{ asset('js/wow.js') }}"></script>
<script src="{{ asset('js/nivo-lightbox.js') }}"></script>
<script src="{{ asset('js/main.js') }}"></script>
<!-- <script src="{{ asset('js/contact-form-script.min.js') }}"></script> -->

@stack('script')

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-64168215-3"></script>
<script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
        dataLayer.push(arguments);
    }
    gtag('js', new Date());
    gtag('config', 'UA-64168215-3');
</script>

<!-- ManyChat -->
<script src="//widget.manychat.com/1407854356137306.js" async="async"></script>