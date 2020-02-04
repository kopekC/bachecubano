<!-- Schema Markup Unescaped -->
@if(isset($SchemaLD))
{!! $SchemaLD !!}
@endif

<!-- BreadCrumbs Markup Unescaped -->
@if(isset($BreadCrumbs))
{!! $BreadCrumbs !!}
@endif

<!-- jQuery first 3.3.1 NotSlim, then Popper.js, then Bootstrap JS -->
<script src="{{ asset('js/jquery-3.3.1.min.js') }}"></script>
<!-- Images LazyLoad -->
<script src="{{ asset('js/lazysizes.min.js') }}"></script>
<!-- Twitter Bootstrap & Behaviors Like Tooltips etc -->
<script src="{{ asset('js/popper.min.js') }}"></script>
<!-- Bootstrap JS -->
<script src="{{ asset('js/bs.js') }}"></script>
<!-- Responsive Navigation Menu -->
<script src="{{ asset('js/jquery.slicknav.min.js') }}"></script>
<!--Google Adesense -->
<script async data-ad-client="ca-pub-9876511577005081" src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>

<!-- Checkout This as the img logos for use later in main.js -->
<script>
    var logo = "{{ asset('img/logo-bachecubano.png') }}";
    var logo_w = "{{ asset('img/logo-bachecubano-w.png') }}";
    var user_token = "@auth{{Auth::user()->api_token}}@endauth";
    var api_server = "{{ config('app.api_url') }}";
    var current_url = "{{ URL::current() }}";
</script>

<script src="{{ asset('js/wow.js') }}"></script>
<script src="{{ asset('js/main3.js') }}"></script>

@stack('script')

<!-- FoxPush -->
<script data-cfasync="false">
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