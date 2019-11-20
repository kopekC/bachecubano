@extends('layouts.app')

@section('content')
<!-- Page Header Start -->
<div class="page-header">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="breadcrumb-wrapper">
                    <a href="{{ URL::current() }}">
                        <h1 class="h2 product-title">{{ $ad->description->title }}</h1>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Page Header End -->

<!--
    <ol class="breadcrumb">
    <li><a href="#">Home /</a></li>
    <li class="current">Details</li>
    </ol>
-->

<!-- Ads Details Start -->
<section class="section-padding">
    <div class="container-fluid">
        <!-- Product Info Start -->
        <div class="product-info row">

            <div class="col-xs-12 col-md-6 col-lg-3 col-xl-3 text-center mb-3">

                @if(count($ad->resources) > 1)
                <div class="owl-carousel owl-theme" id="product-carousel">
                    @foreach($ad->resources as $resource)
                    <div class="item">
                        <img src="{{ ad_image_url($resource) }}" class="img-fluid" alt="{{ text_clean($ad->description->title) }}">
                    </div>
                    @endforeach
                </div>
                @push('style')
                <!-- Owl carousel -->
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">
                @endpush
                @push('script')
                <!-- Carousell -->
                <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
                <script>
                    $('#product-carousel').owlCarousel({
                        center: true,
                        loop: true,
                        stagePadding: 0,
                        margin: 0,
                        singleItem: true,
                        nav: true,
                        autoWidth: true,
                        lazyLoad: true,
                        autoplay: true,
                        autoplayTimeout: 5000,
                        autoplayHoverPause: true,
                        responsive: {
                            600: {
                                items: 2
                            }
                        },
                        dots: true,
                        navigation: true, // Show next and prev buttons
                        slideSpeed: 300,
                        paginationSpeed: 400
                        // "singleItem:true" is a shortcut for:
                        // items : 1, 
                        // itemsDesktop : false,
                        // itemsDesktopSmall : false,
                        // itemsTablet: false,
                        // itemsMobile : false
                    })
                </script>
                @endpush

                @else
                <img src="{{ ad_first_image($ad) }}" class="img-fluid" alt="{{ text_clean($ad->description->title) }}">
                @endif
            </div>

            <div class="col-xs-12 col-md-6 col-lg-6 col-xl-7 pr-5 pl-5">
                <div class="description">
                    <div class="details-box">
                        <div class="ads-details-info">
                            <h4 class="title-small mb-3">Detalles del anuncio:</h4>
                            <ul class="advertisement">
                                <li>
                                    <p><strong><i class="lni-{{ $ad->category->description->icon }}"></i> Categoría:</strong> <a href="{{ ad_category_url($ad) }}">{{ $ad->category->description->name }}</a></p>
                                </li>
                                <!--
                                <li>
                                    <p><strong><i class="lni-archive"></i> Estado:</strong> Nuevo</p>
                                </li>
                                <li>
                                    <p><strong><i class="lni-package"></i> Marca:</strong> <a href="#"> xxx</a></p>
                                </li>
                                -->
                            </ul>
                            <div class="details-meta">
                                <span><a href="#" title="ID del anuncio"><i class="lni-information"></i> {{ $ad->id }}</a></span>
                                <span><a href="#" title="Creado el {{ $ad->created_at->format('d-m-Y') }} a las {{ $ad->created_at->format('H:m') }}"><i class="lni-alarm-clock"></i> {{ $ad->created_at->diffForHumans() }}</a></span>
                                <span><a href="#" title="Total de visitas válidas del anuncio"><i class="lni-eye"></i> {{ $ad->stats->hits > 0 ? $ad->stats->hits : 0 }} Visitas</a></span>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div id="content">
                        {!! nl2br($ad->description->description) !!}
                    </div>
                    <!-- Disqus -->
                    <div id="disqus_thread"></div>
                    @push('script')
                    <script>
                        var disqus_config = function() {
                            this.page.url = "{{ URL::current() }}"; // Replace PAGE_URL with your page's canonical URL variable
                            this.page.identifier = "{{ $ad->id }}"; // Replace PAGE_IDENTIFIER with your page's unique identifier variable
                        };
                        (function() { // DON'T EDIT BELOW THIS LINE
                            var d = document,
                                s = d.createElement('script');
                            s.src = 'https://bachecubano.disqus.com/embed.js';
                            s.setAttribute('data-timestamp', +new Date());
                            (d.head || d.body).appendChild(s);
                        })();
                    </script>
                    <noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
                    @endpush
                </div>
            </div>

            <div class="col-xs-12 col-md-6 col-lg-3 col-xl-2">
                <!-- Product Contact Start -->
                <div class="description-info">
                    <div class="short-info">

                        <div class="ads-btn mb-4">
                            <h3 class="text-center h3">{{ ad_price($ad) }}</h3>
                            @if(isset($ad->contact_name) && $ad->contact_name != "")
                            <h4 class="text-center h4">{{ $ad->contact_name }}</h4>
                            @endif
                            @if(isset($ad->contact_email) && $ad->contact_email != "")
                            <a href="mailto:{{ $ad->contact_email }}" class="btn btn-common btn-reply btn-block mb-1" title="Enviar Email a {{ $ad->contact_name }}"><i class="lni-envelope"></i> Correo</a>
                            @endif
                            @if(isset($ad->phone) && $ad->phone != "")
                            <a href="tel:{{ $ad->phone }}" class="btn btn-common btn-block" title="Llamar a {{ $ad->contact_name }}"><i class="lni-phone-handset"></i> {{ $ad->phone }}</a>
                            <a href="#!" class="btn btn-common btn-block" title="Enviar SMS a {{ $ad->contact_name }}"><i class="lni-bubble"></i> {{ $ad->phone }}</a>
                            @endif
                        </div>

                        @if(Auth::check() && Auth::getUser()->id == $ad->user_id)
                        <hr>
                        <a class="btn btn-success btn-block" href="{{ route('promote_ad', ['ad' => $ad]) }}"><i class="lni-dollar"></i> Pomocionar</a>
                        <a class="btn btn-info btn-block" href="{{ route('ad.edit', ['ad' => $ad]) }}"><i class="lni-pencil"></i> Editar anuncio</a>
                        <a class="btn btn-danger btn-block delete-ad" data-href="{{ route('ad.destroy', ['ad' => $ad]) }}"><i class="lni-trash"></i> Eliminar anuncio</a>
                        @endif

                        <hr>
                        <!-- Like and Share Buttons -->
                        <div class="share text-center">
                            <span>Like y Comparte: </span>
                            <div class="social-link">
                                <a href="#!" class="facebook like mb-2" data-ad_id="{{ $ad->id }}">
                                    @auth
                                    @if(Auth::getUser()->hasLiked($ad))
                                    <div class="spinner-border spinner-border-sm d-none" role="status"><span class="sr-only">Cargando...</span></div>
                                    <i class="lni-thumbs-down"></i>
                                    @else
                                    <div class="spinner-border spinner-border-sm d-none" role="status"><span class="sr-only">Cargando...</span></div>
                                    <i class="lni-thumbs-up"></i>
                                    @endif
                                    @else
                                    <i class="lni-thumbs-up"></i>
                                    @endauth
                                </a>
                                <a class="facebook mb-2" href="{{ route('share', ['network' => 'facebook', 'url' => base64_encode(URL::current()), 'text' => base64_encode($ad->description->title)]) }}"><i class="lni-facebook"></i></a>
                                <a class="twitter mb-2" href="{{ route('share', ['network' => 'twitter', 'url' => base64_encode(URL::current()), 'text' => base64_encode($ad->description->title)]) }}"><i class="lni-twitter"></i></a>
                                <a class="linkedin mb-2" href="{{ route('share', ['network' => 'linkedin', 'url' => base64_encode(URL::current()), 'text' => base64_encode($ad->description->title)]) }}"><i class="lni-linkedin"></i></a>
                            </div>
                        </div>

                        @if($ad->user_id !== 0 && isset($ad->owner))
                        <hr>
                        <div class="text-center">
                            <h4 class="mt-4">Perfil de contacto</h4>
                            <!-- Photo profile -->
                            <!-- Personal Link -->
                            <!-- Rating Stars -->
                            <div class="user">
                                <div class="d-flex justify-content-center h-100">
                                    <div class="image_outer_container">
                                        <div class="green_icon"></div>
                                        <div class="image_inner_container">
                                            <img src="{{ profile_logo($ad->owner) }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="usercontent text-center pt-3">
                                    <h4><i class="lni-user"></i> {{ $ad->owner->name }}</h4>
                                </div>
                            </div>
                        </div>
                        @endif
                        <hr>
                        <ul>
                            <li><a href="#" onclick="window.print();return false;"><i class="lni-printer"></i> Imprimir anuncio</a></li>
                            <li><a href="{{ route('invite', ['item' => 'ad', 'misc' => $ad->id]) }}"><i class="lni-reply"></i> Enviar a un amigo</a></li>
                            <li><a href="#"><i class="lni-warning"></i> Reportar anuncio</a></li>
                        </ul>
                    </div>
                </div>
                <!-- Product Description End -->
            </div>
        </div>
        <!-- Product Info End -->
    </div>
</section>
<!-- Ads Details End -->

<!-- featured Listing -->
@include('blocks.featured-listing')
<!-- featured Listing -->

@push('script')

<!-- Autolinker hashtags and Mentions to stores -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/autolinker/3.1.0/Autolinker.min.js"></script>
<script>
    var content = document.getElementById('content');
    content.innerHTML = Autolinker.link(content.innerHTML, {
        hashtag: 'twitter',
        mention: 'twitter',
        replaceFn: function(match) {
            switch (match.getType()) {
                case 'hashtag':
                    var hashtag = match.getHashtag();
                    console.log(hashtag);
                    return '<a href="https://www.bachecubano.com/search?ht=' + hashtag + '">#' + hashtag + '</a>';
                    break;

                case 'mention':
                    var mention = match.getMention();
                    console.log(mention);
                    return '<a href="https://' + mention + '.bachecubano.com">' + mention + '</a>';
                    break;
            }
        }
    });
</script>

<!--Shorten plugin -->
<script>
    (function($) {
        $.fn.shorten = function(settings) {
            var config = {
                showChars: 100,
                ellipsesText: "...",
                moreText: "more",
                lessText: "less"
            };
            if (settings) {
                $.extend(config, settings);
            }
            $(document).off("click", '.morelink');
            $(document).on({
                click: function() {

                    var $this = $(this);
                    if ($this.hasClass('less')) {
                        $this.removeClass('less');
                        $this.html(config.moreText);
                    } else {
                        $this.addClass('less');
                        $this.html(config.lessText);
                    }
                    $this.parent().prev().toggle();
                    $this.prev().toggle();
                    return false;
                }
            }, '.morelink');
            return this.each(function() {
                var $this = $(this);
                if ($this.hasClass("shortened")) return;
                $this.addClass("shortened");
                var content = $this.html();
                if (content.length > config.showChars) {
                    var c = content.substr(0, config.showChars);
                    var h = content.substr(config.showChars, content.length - config.showChars);
                    var html = c + '<span class="moreellipses">' + config.ellipsesText + ' </span><span class="morecontent"><span>' + h + '</span> <a href="#" class="morelink">' + config.moreText + '</a></span>';
                    $this.html(html);
                    $(".morecontent span").hide();
                }
            });
        };
    })(jQuery);
    $(document).ready(function() {
        $("#content").shorten({
            "showChars": 1800,
            "moreText": "Ver más",
            "lessText": "menos",
        });
    });
</script>
@endpush

@endsection