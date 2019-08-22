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
<div class="section-padding">
    <div class="container-fluid">
        <!-- Product Info Start -->
        <div class="product-info row">

            <div class="col-xs-12 col-md-6 col-lg-3 col-xl-3 text-center mb-3">
                @if(count($ad->resources) > 1)
                <div class="owl-carousel owl-theme" id="product-carousel">
                    @foreach($ad->resources as $resource)
                    <div class="item">
                        <img src="{{ ad_image_url($resource) }}" class="img-fluid">
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
                <img src="{{ ad_first_image($ad) }}" class="img-fluid">
                @endif
            </div>

            <div class="col-xs-12 col-md-6 col-lg-6 col-xl-6 pr-5 pl-5">
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
                            <!--
                            <ul class="list-specification">
                                <li><i class="lni-check-mark-circle"></i> xxx</li>
                                <li><i class="lni-check-mark-circle"></i> xxx</li>
                            </ul>
                            -->
                            <div class="details-meta">
                                <span><a href="#" title="Creado el {{ $ad->created_at->format('d-m-Y') }} a las {{ $ad->created_at->format('H:m') }}"><i class="lni-alarm-clock"></i> {{ $ad->created_at->diffForHumans() }}</a></span>
                                <span><a href="#"><i class="lni-eye"></i> {{ $ad->stats->hits > 0 ? $ad->stats->hits : 0 }} Visitas</a></span>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div id="adcontent">
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

            <div class="col-xs-12 col-md-6 col-lg-3 col-xl-3">
                <!-- Product Description Start -->
                <div class="description-info">
                    <div class="short-info">

                        <div class="ads-btn mb-4">
                            <h3 class="text-center h3">{{ ad_price($ad) }}</h3>
                            <h4 class="text-center h4">{{ $ad->contact_name }}</h4>
                            <a href="mailto:{{ $ad->contact_email }}" class="btn btn-common btn-reply btn-block mb-1"><i class="lni-envelope"></i> Correo</a>
                            @if(isset($ad->phone) && $ad->phone != "")
                            <a href="tel:{{ $ad->phone }}" class="btn btn-common btn-block"><i class="lni-phone-handset"></i> {{ $ad->phone }}</a>
                            @endif
                        </div>

                        <hr>
                        <div class="share text-center">
                            <span>Compartir: </span>
                            <div class="social-link">
                                <a class="facebook" href="{{ route('share', ['network' => 'facebook', 'url' => base64_encode(URL::current()), 'text' => base64_encode($ad->description->title)]) }}"><i class="lni-facebook"></i></a>
                                <a class="twitter" href="{{ route('share', ['network' => 'twitter', 'url' => base64_encode(URL::current()), 'text' => base64_encode($ad->description->title)]) }}"><i class="lni-twitter"></i></a>
                                <a class="linkedin" href="{{ route('share', ['network' => 'linkedin', 'url' => base64_encode(URL::current()), 'text' => base64_encode($ad->description->title)]) }}"><i class="lni-linkedin"></i></a>
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
                                <figure>
                                    <a href="#"><img src="#" alt=""></a>
                                </figure>
                                <div class="usercontent">
                                    <h3></h3>
                                    <h4><i class="lni-hone"></i> {{ $ad->owner->name }}</h4>
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
</div>
<!-- Ads Details End -->

<!-- featured Listing -->
@include('blocks.featured-listing')
<!-- featured Listing -->

@push('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/autolinker/3.1.0/Autolinker.min.js"></script>
<script>
    var adcontent = document.getElementById('adcontent');
    adcontent.innerHTML = Autolinker.link(adcontent.innerHTML, {
        hashtag: 'twitter',
        mention: 'twitter',
        replaceFn: function(match) {
            switch (match.getType()) {
                case 'hashtag':
                    var hashtag = match.getHashtag();
                    console.log(hashtag);
                    return '<a href="https://www.bachecubano.com/search?tags=' + hashtag + '">#' + hashtag + '</a>';
                    break;

                case 'mention':
                    var mention = match.getMention();
                    console.log(mention);
                    return '<a href="http://newplace.to.link.mention.to/">' + mention + '</a>';
                    break;
            }
        }
    });
</script>
@endpush

@endsection