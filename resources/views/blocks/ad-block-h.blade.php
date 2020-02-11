<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    <div class="featured-box">
        @if($ad->promo->promotype > 0)
        <div class="progress" style="height: 4px;" title="Anuncio con promoción {{ ad_promotion_text_type($ad->promo) }}">
            @php $vence = new \Carbon\Carbon($ad->promo->end_promo); $difference = ($vence->diff($today)->days < 1) ? 0 : $vence->diffInDays($today); $percent = ($difference/30)*100; @endphp
                <div class="progress-bar progress-bar-striped progress-bar-animated @if($percent < 10) bg-danger @endif" role="progressbar" style="width: {{ $percent }}%" aria-valuenow="{{ $percent }}" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
        @endif
        <figure>
            <div class="icon">
                <i class="lni-heart"></i>
            </div>
            <a href="{{ ad_url($ad) }}"><img class="img-fluid lazyload" src="{{ ad_first_image($ad) }}" alt="{{ $ad->description->title }}"></a>
        </figure>
        <div class="feature-content">
            <div class="product">
                <a href="{{ ad_category_url($ad) }}"><i class="lni-{{ $ad->category->parent->icon }}"></i> {{ $ad->category->description->name }}</a>
            </div>
            <h4><a href="{{ ad_url($ad) }}">{{ $ad->description->title }}</a></h4>
            <span>Actualizado: {{ $ad->created_at->diffForHumans() }}</span>
            <ul class="address">
                <li>
                    <a href="#" title="ID del anuncio"><i class="lni-information"></i> {{ $ad->id }}</a>
                </li>
                <li class="ml-2">
                    <a href="#" title="Ubicación del anuncio"><i class="lni-map-marker"></i>{{ $ad->location->title }}</a>
                </li>
                <li class="ml-2">
                    <a href="#" title="Tipo de promoción del anuncio"><i class="lni-dollar"></i>{{ ad_promotion_text_type($ad->promo) }}</a>
                </li>
                <li class="ml-2">
                    <a href="#" title="Cantidad de visitas"><i class="lni-eye"></i>{{ $ad->stats->hits > 0 ? $ad->stats->hits : 0 }}</a>
                </li>
            </ul>
            <input type="checkbox" class="bs-toggle" @if($ad->active == 1) checked @endif data-toggle="toggle" data-size="mini" data-ad_id="{{ $ad->id }}" data-onstyle="success" data-style="float-right" data-offstyle="danger" data-on="Activo" data-off="Inactivo">
            <div class="listing-bottom">
                <h3 class="price float-left">{{ ad_price($ad) }}</h3>
                <!--
                                    <a href="#" class="btn-verified float-right"><i class="lni-check-box"></i> Verificado</a>
                                    -->
                <a class="btn btn-verified btn-delete float-right" href="{{route('delete_ad', ['ad' => $ad])}}?api_token={{Auth::user()->api_token}}" title="Eliminar anuncio"><i class="lni-trash"></i></a>
                <a class="btn btn-verified btn-edit float-right" href="{{ route('ad.edit', ['ad' => $ad]) }}" title="Editar anuncio"><i class="lni-pencil"></i></a>
                <a class="btn btn-verified btn-view float-right" href="{{ route('promote_ad', ['ad' => $ad]) }}" title="Promocionar anuncio"><i class="lni-dollar"></i></a>
            </div>
        </div>
    </div>
</div>