<!-- Featured Listings Start -->
<section class="featured-lis section-padding bg-drack">
    <div class="container">
        <h3 class="section-title">Anuncios Promocionados</h3>
        <div class="row" data-wow-delay="0.5s">
            @foreach($promoted_ads as $ad)
            <div class="col-sm-12 col-md-6 col-lg-3">
                <div class="product-item">
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
                                <i class="lni-star"></i>
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
            @endforeach
        </div>
    </div>
</section>
<!-- Featured Listings End -->