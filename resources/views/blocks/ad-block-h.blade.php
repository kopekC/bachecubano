<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    <div class="featured-box">
        <figure>
            <div class="icon">
                <a href="#!" class="like" data-ad_id="{{ $ad->id }}"><i class="lni-heart"></i></a>
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
            <span>Last Updated: 4 hours ago</span>
            <ul class="address">
                <li>
                    <a href="#"><i class="lni-user"></i> {{ $ad->contact_name }}</a>
                </li>
            </ul>
            <div class="listing-bottom">
                <h3 class="price float-left">{{ ad_price($ad) }}</h3>
            </div>
        </div>
    </div>
</div>