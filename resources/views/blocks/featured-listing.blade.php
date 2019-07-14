<!-- Featured Listings Start -->
<section class="featured-lis section-padding bg-drack">
    <div class="container">
        <div class="row">
            <div class="col-md-12 wow fadeIn" data-wow-delay="0.5s">
                <h3 class="section-title">Anuncios Promocionados</h3>
                <div id="new-products" class="owl-carousel">
                    @foreach($promoted_ads as $ad)
                    <div class="item">
                        <div class="product-item">
                            <div class="carousel-thumb">
                                <a href="{{ ad_url($ad) }}">
                                    <img class="img-fluid" src="{{ asset('img/product/img3.jpg') }}" alt="{{ $ad->category->description->name }}">
                                </a>
                                <div class="overlay">
                                </div>
                                <div class="btn-product bg-red">
                                    <a href="#">Discount 50%</a>
                                </div>
                            </div>
                            <div class="product-content">
                                <h3 class="product-title"><a href="{{ ad_url($ad) }}">{{ $ad->category->description->name }}</a></h3>
                                <p>Lorem ipsum dolor sit</p>
                                <span class="price">$ 30.00</span>
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
                                        <div class="icon">
                                            <i class="lni-heart"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Featured Listings End -->