<!-- Schema Markup Unescaped -->
@if(isset($SchemaLD))
{!! $SchemaLD !!}
@endif

<!--Google Adesense -->
<script async data-ad-client="ca-pub-9876511577005081" src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>

<!-- Images LazyLoad -->
<script async src="https://cdnjs.cloudflare.com/ajax/libs/lazysizes/5.1.0/lazysizes.min.js"></script>
<!-- jQuery first 3.3.1 NotSlim, then Popper.js, then Bootstrap JS -->
<script async src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<!-- Twitter Bootstrap & Behaviors Like Tooltips etc -->
<script async src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script async src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<!-- Responsive Navigation Menu -->
<script async src="https://cdnjs.cloudflare.com/ajax/libs/SlickNav/1.0.10/jquery.slicknav.min.js"></script>

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