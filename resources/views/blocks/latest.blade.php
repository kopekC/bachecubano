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
                        <a href="{{ route('show_ad', ['category' => $ad->category->parent->description->slug, 'subcategory' => $ad->category->description->slug, 'ad_title' => Str::slug($ad->description->title), 'id' => $ad->id]) }}"><img class="img-fluid" src="@if(isset($ad->resources[0]->name) && isset($ad->resources[0]->extension))https://www.bachecubano.com/images/{{ $ad->resources[0]->name }}.{{ $ad->resources[0]->extension }}@else https://www.bachecubano.com/android-chrome-192x192.png @endif" alt="{{ $ad->description->title }}"></a>
                    </figure>
                    <div class="feature-content">
                        <div class="product">
                            <a href="{{ route('category_index', ['category' => $ad->category->parent->description->slug, 'subcategory' => $ad->category->description->slug]) }}"><i class="lni-{{ $ad->category->icon }}"></i> {{ $ad->category->description->name }}</a>
                        </div>
                        <h4><a href="{{ route('show_ad', ['category' => $ad->category->parent->description->slug, 'subcategory' => $ad->category->description->slug, 'ad_title' => Str::slug($ad->description->title), 'id' => $ad->id]) }}">{{ $ad->description->title }}</a></h4>
                        <span>{{ $ad->created_at->diffForHumans() }}</span>
                        <ul class="address">
                            <li>
                                <a href="#"><i class="lni-map-marker"></i> Location</a>
                            </li>
                            <li>
                                <a href="#"><i class="lni-alarm-clock"></i> {{ $ad->created_at }}</a>
                            </li>
                            <li>
                                <a href="#"><i class="lni-user"></i> {{ $ad->contact_name }}</a>
                            </li>
                            <li>
                                <a href="#"><i class="lni-package"></i> De uso/Nuevo/En Oferta</a>
                            </li>
                        </ul>
                        <div class="listing-bottom">
                            <h3 class="price float-left">@if($ad->price > 0 && $ad->price != null) $ {{ $ad->price / 1000000 }} @endif</h3>
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