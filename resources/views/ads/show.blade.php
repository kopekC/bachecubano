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
            <div class="col-lg-3 col-md-12 col-xs-12">
                @if(count($ad->resources) >= 1)
                <div class="owl-carousel owl-theme" id="product-carousel">
                    @foreach($ad->resources as $resource)
                    <div class="item">
                        <img src="{{ ad_image_url($resource) }}" class="img-fluid">
                    </div>
                    @endforeach
                </div>

                @push('script')
                <script>
                    $('#product-carousel').owlCarousel({
                        center: true,
                        loop: true,
                        margin: 10,
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
                        }
                    })
                </script>
                @endpush

                @else
                <img src="{{ ad_first_image($ad) }}" class="img-fluid">
                @endif
            </div>
            <div class="col-lg-6 col-md-12 col-xs-12 pr-5 pl-5">
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
                            <ul class="list-specification">
                                <li><i class="lni-check-mark-circle"></i> xxx</li>
                                <li><i class="lni-check-mark-circle"></i> xxx</li>
                            </ul>
                            <div class="details-meta">
                                <span><a href="#" title="Creado el {{ $ad->created_at->format('d-m-Y') }} a las {{ $ad->created_at->format('H:m') }}"><i class="lni-alarm-clock"></i> {{ $ad->created_at->diffForHumans() }}</a></span>
                                <span><a href="#"><i class="lni-eye"></i> {{ $ad->stats->hits > 0 ? $ad->stats->hits : 0 }} Visitas</a></span>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div>
                        {!! nl2br($ad->description->description) !!}
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-xs-12">
                <!-- Product Description Start -->
                <div class="description-info" style="float: right">
                    <div class="short-info">

                        <div class="ads-btn mb-4">
                            <h3 class="text-center h3">{{ ad_price($ad) }}</h3>
                            <a href="mailto:{{ $ad->contact_email }}" class="btn btn-common btn-reply btn-block mb-1"><i class="lni-envelope"></i> Correo</a>
                            <a href="tel:XXXXXXXXX" class="btn btn-common btn-block"><i class="lni-phone-handset"></i> XXXXXXXXX</a>
                        </div>

                        <div class="share">
                            <span>Compartir: </span>
                            <div class="social-link">
                                <a class="facebook" href="#"><i class="lni-facebook"></i></a>
                                <a class="twitter" href="#"><i class="lni-twitter"></i></a>
                                <a class="linkedin" href="#"><i class="lni-linkedin"></i></a>
                                <a class="google" href="#"><i class="lni-google-plus"></i></a>
                            </div>
                        </div>

                        <h4 class="mt-4">Perfil de contacto</h4>
                        <ul>
                            <li><a href="#"><i class="lni-users"></i> <span>{{ $ad->contact_name }}</span></a></li>
                            <li><a href="#"><i class="lni-printer"></i> Imprimir anuncio</a></li>
                            <li><a href="#"><i class="lni-reply"></i> Enviar a un amigo</a></li>
                            <li><a href="#"><i class="lni-warning"></i> reportar anuncio</a></li>
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
    var text = $(".description").val();

    var linkedText = Autolinker.link(text, {

        replaceFn: function(match) {

            console.log("href = ", match.getAnchorHref());
            console.log("text = ", match.getAnchorText());

            switch (match.getType()) {
                case 'url':
                    console.log("url: ", match.getUrl());
                    if (match.getUrl().indexOf('mysite.com') === -1) {
                        var tag = match.buildTag(); // returns an `Autolinker.HtmlTag` instance, which provides mutator methods for easy changes
                        tag.setAttr('rel', 'nofollow');
                        tag.addClass('external-link');
                        return tag;
                    } else {
                        return true; // let Autolinker perform its normal anchor tag replacement
                    }
                    break;
                case 'email':
                    var email = match.getEmail();
                    console.log("email: ", email);
                    return;
                    break;

                case 'phone':
                    var phoneNumber = match.getPhoneNumber();
                    console.log(phoneNumber);
                    return '<a href="http://newplace.to.link.phone.numbers.to/">' + phoneNumber + '</a>';
                    break;
                case 'hashtag':
                    var hashtag = match.getHashtag();
                    console.log(hashtag);
                    return '<a href="https://www.bachecubano.com/search?tags=' + hashtag + '">' + hashtag + '</a>';
                    break;
                case 'mention':
                    var mention = match.getMention();
                    console.log(mention);
                    return '<a href="http://newplace.to.link.mention.to/">' + mention + '</a>';
                    break;
            }
        }
    });

    /**
     * Example Code:
        var autolinker = new Autolinker( {
            urls : {
                schemeMatches : true,
                wwwMatches    : true,
                tldMatches    : true
            },
            email       : true,
            phone       : true,
            mention     : false,
            hashtag     : false,
            stripPrefix : true,
            stripTrailingSlash : true,
            newWindow   : true,
            truncate : {
                length   : 0,
                location : 'end'
            },
            className : ''
        } );
        var myLinkedHtml = autolinker.link( myText );
     */
</script>
@endpush

@endsection