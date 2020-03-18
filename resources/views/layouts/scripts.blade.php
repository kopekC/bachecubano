<!-- Schema Markup Unescaped -->
@if(isset($SchemaLD))
{!! $SchemaLD !!}
@endif

<!-- BreadCrumbs Markup Unescaped -->
@if(isset($BreadCrumbs))
{!! $BreadCrumbs !!}
@endif

<!-- Checkout This as the img logos for use later in main.js -->
<script>
    var logo = "{{ asset('img/logo-bachecubano.png') }}";
    var logo_w = "{{ asset('img/logo-bachecubano-w.png') }}";
    var user_token = "@auth{{Auth::user()->api_token}}@endauth";
    var api_server = "{{ config('app.api_url') }}";
    var current_url = "{{ URL::current() }}";
</script>

<!-- All above combined -->
<script src="{{ route('bachecubano_js') }}"></script>

<!--Google Adsense -->
@if($show_ads)
<script async data-ad-client="ca-pub-9876511577005081" src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>

@endif

@stack('script')

<!-- FoxPush -->
<script data-cfasync="false">
    var _foxpush = _foxpush || [];
    _foxpush.push(['_setDomain', 'bachecubanocom']);
    (function() {
        var foxscript = document.createElement('script');
        foxscript.src = '//www.bachecubano.com/js/foxpush_SDK_min.js';
        foxscript.type = 'text/javascript';
        foxscript.async = 'true';
        var fox_s = document.getElementsByTagName('script')[0];
        fox_s.parentNode.insertBefore(foxscript, fox_s);
    })();
</script>