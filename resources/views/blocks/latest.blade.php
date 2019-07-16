<!-- Featured Section Start -->
<section class="featured section-padding bg-drack">
    <div class="container">
        <h1 class="section-title">Publicado recientemente</h1>
        <div class="row">
            @foreach($latest_ads as $ad)
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-4">
                <div class="featured-box">
                    <figure>
                        <div class="icon">
                            <i class="lni-heart"></i>
                        </div>
                        <a href="{{ ad_url($ad) }}"><img class="img-fluid lazyload" data-src="{{ ad_first_image($ad) }}" alt="{{ $ad->description->title }}"></a>
                    </figure>
                    <div class="feature-content">
                        <div class="product">
                            <a href="{{ ad_url($ad) }}"><i class="lni-{{ $ad->category->icon }}"></i> {{ $ad->category->description->name }}</a>
                        </div>
                        <h4><a href="{{ route('show_ad', ['category' => $ad->category->parent->description->slug, 'subcategory' => $ad->category->description->slug, 'ad_title' => Str::slug($ad->description->title), 'id' => $ad->id]) }}">{{ $ad->description->title }}</a></h4>
                        <span>{{ $ad->created_at->diffForHumans() }}</span>
                        <ul class="address">
                            <li>
                                <a href="#"><i class="lni-map-marker"></i> Location</a>
                            </li>
                            <li>
                                <a href="#"><i class="lni-alarm-clock"></i> {{ $ad->created_at->format("d-m H:m") }}</a>
                            </li>
                            <li>
                                <a href="#"><i class="lni-user"></i> {{ $ad->contact_name }}</a>
                            </li>
                            <li>
                                <a href="#"><i class="lni-package"></i> De uso/Nuevo/En Oferta</a>
                            </li>
                        </ul>
                        <div class="listing-bottom">
                            <h3 class="price float-left">{{ ad_price($ad) }}</h3>
                            <a href="account-myads.html" class="btn-verified float-right"><i class="lni-check-box"></i> Verificado</a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
<!-- Featured Section End -->