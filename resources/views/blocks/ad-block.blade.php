<!--
<div class="col-xs-12 col-sm-6 col-md-4 col-lg-3 col-xl-2">
    <div class="featured-box">
        <figure>
            <div class="icon">
                <a href="#!" class="like" data-ad_id="{{ $ad->id }}"><i class="lni-thumbs-up"></i></a>
            </div>
            <a href="{{ ad_url($ad) }}">
                <img class="img-fluid lazyload" data-src="{{ ad_first_image($ad) }}" alt="{{ $ad->description->title }}">
            </a>
        </figure>
        <div class="feature-content">
            <div class="product">
                <a href="{{ ad_category_url($ad) }}"><i class="lni-{{ $ad->category->description->icon }}"></i> {{ $ad->category->description->name }}</a>
            </div>
            <h4>
                <a href="{{ ad_url($ad) }}">{{ $ad->description->title }}</a>
            </h4>
            <ul class="address">
                <li>
                    <a href="@if(isset($ad->phone) && $ad->phone != '')tel:{{ $ad->phone }}@endif"><i class="lni-user"></i> {{ $ad->contact_name }}</a>
                </li>
            </ul>
            @if(ad_price($ad) != "")
            <div class="listing-bottom">
                <h3 class="price">{{ ad_price($ad) }}</h3>
            </div>
            @endif
        </div>
    </div>
</div>
-->

<div class="col-xs-12 col-sm-6 col-md-4 col-lg-3 col-xl-2">
    <div class="product-item featured-box">
        <div class="carousel-thumb text-center">
            <a href="{{ ad_url($ad) }}">
                <img class="img-fluid lazyload" data-src="{{ ad_first_image($ad) }}" alt="{{ $ad->description->title }}">
            </a>
            <div class="overlay"></div>
            <div class="btn-product bg-red">
                <a href="{{ ad_url($ad) }}">{{ ad_promotion_text_type($ad) }}</a>
            </div>
        </div>
        <div class="product-content">
            <h3 class="product-title">
                <a href="{{ ad_url($ad) }}">{{ $ad->description->title }}</a>
            </h3>
            <p><a href="{{ ad_category_url($ad) }}"><i class="lni-{{ $ad->category->description->icon }}"></i> {{ $ad->category->description->name }}</a></p>
            <span class="price">{{ ad_price($ad) }}</span>
            <div class="meta">
                <span class="icon-wrap">
                    <i class="lni-star-filled"></i>
                    <i class="lni-star-filled"></i>
                    <i class="lni-star-filled"></i>
                    <i class="lni-star-filled"></i>
                    <i class="lni-star"></i>
                </span>
                <span class="count-review">
                    <span>1</span> Reviews
                </span>
            </div>
            <div class="card-text">
                <div class="float-left">
                    <a href="#"><i class="lni-map-marker"></i> Louis, Missouri, US</a>
                </div>
                <div class="float-right">
                    <a href="#!" class="icon like" data-ad_id="{{ $ad->id }}">
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
                </div>
            </div>
        </div>
    </div>
</div>