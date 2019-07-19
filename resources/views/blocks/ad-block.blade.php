<div class="col-xs-12 col-sm-12 col-md-4 col-lg-3 col-xl-2 p-1">
    <div class="featured-box">
        <figure>
            <div class="icon">
                <i class="lni-heart"></i>
            </div>
            <a href="{{ ad_url($ad) }}"><img class="img-fluid" src="{{ ad_first_image($ad) }}" alt="{{ $ad->description->title }}"></a>
        </figure>
        <div class="feature-content">
            <div class="product">
                <a href="{{ ad_category_url($ad) }}"><i class="lni-{{ $ad->category->icon }}"></i> {{ $ad->category->description->name }}</a>
            </div>
            <h4><a href="{{ ad_url($ad) }}">{{ $ad->description->title }}</a></h4>
            <span>@if($ad->updated_at != null) {{ $ad->updated_at->diffForHumans() }} @endif</span>
            <ul class="address">
                <li>
                    <a href="#"><i class="lni-user"></i> Maria Barlow</a>
                </li>
                <li>
                    <a href="#"><i class="lni-package"></i> Used</a>
                </li>
            </ul>
            <div class="listing-bottom">
                <h3 class="price float-left">{{ ad_price($ad) }}</h3>
                <a href="account-myads.html" class="btn-verified float-right"><i class="lni-check-box"></i> Verificado</a>
            </div>
        </div>
    </div>
</div>