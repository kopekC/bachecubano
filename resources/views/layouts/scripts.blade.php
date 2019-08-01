<!-- Schema Markup Unescaped -->
@if(isset($SchemaLD))
{!! $SchemaLD !!}
@endif

<!-- Images LazyLoad -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/lazysizes/5.1.0/lazysizes.min.js"></script>
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<!-- Twitter Bootstrap & Behaviors -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.15.0/umd/popper.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.min.js"></script>
<!-- Carousell -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
<!-- Responsive Navigation Menu -->
<script src="{{ asset('js/jquery.slicknav.js') }}"></script>

<!-- Checkout This: -->
<script>
    var logo = "{{ asset('img/logo-bachecubano.png') }}";
    var logo_w = "{{ asset('img/logo-bachecubano-w.png') }}";
</script>

<script src="{{ asset('js/waypoints.min.js') }}"></script>
<script src="{{ asset('js/wow.js') }}"></script>
<script src="{{ asset('js/nivo-lightbox.js') }}"></script>
<script src="{{ asset('js/main.js') }}"></script>
<!-- <script src="{{ asset('js/contact-form-script.min.js') }}"></script> -->

@stack('script')

<!-- FoxPush -->
<script type="text/javascript" data-cfasync="false">
    var _foxpush = _foxpush || [];
    _foxpush.push(['_setDomain', 'bachecubanocom']);
    (function() {
        var foxscript = document.createElement('script');
        foxscript.src = '//cdn.foxpush.net/sdk/foxpush_SDK_min.js';
        foxscript.type = 'text/javascript';
        foxscript.async = 'true';
        var fox_s = document.getElementsByTagName('script')[0];
        fox_s.parentNode.insertBefore(foxscript, fox_s);
    })();
</script>

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