@extends('user.layout')

@section('user_section')

@push('style')
<!-- Button Toggle -->
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
@endpush

<div class="page-content">
    <div class="inner-box">
        <div class="dashboard-box">
            <h2 class="dashbord-title">Mis anuncios</h2>
        </div>
        <div class="dashboard-wrapper">
            <nav class="nav-table mb-1">
                <ul>
                    <li @if(Request::has('all')) class="active" @endif><a href="{{ route('my_ads') }}?all=1">Todos ({{ $total_active_ads }})</a></li>
                    <li @if(Request::has('active')) class="active" @endif><a href="{{ route('my_ads') }}?active=1">Activos</a></li>
                    <li @if(Request::has('promoted')) class="active" @endif><a href="{{ route('my_ads') }}?promoted=1">Promovidos</a></li>
                    <li @if(Request::has('inactive')) class="active" @endif><a href="{{ route('my_ads') }}?inactive=1">Inactivos</a></li>
                    <li class="float-right">
                        <select class="form-control" name="category_id" onchange="this.options[this.selectedIndex].value && (window.location = '{{ URL::current() }}?category_id=' + this.options[this.selectedIndex].value);">
                            <option value="">Agrupar Categoría</option>
                            @foreach($parent_categories as $super_category)
                            <optgroup label="{{ $super_category->description->name }}">
                                @foreach($category_formatted[$super_category->id] as $category)
                                @if(Request::input('category_id') == $category->category_id)
                                <option value="{{ $category->category_id }}" selected>{{ $category->name }}</option>
                                @else
                                <option value="{{ $category->category_id }}">{{ $category->name }}</option>
                                @endif
                                @endforeach
                            </optgroup>
                            @endforeach
                        </select>
                    </li>
                    <li class="float-right">
                        <form action="{{ route('my_ads') }}">
                            <div class="search-inner">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="search-query">
                                            <input type="text" name="s" class="form-control" placeholder="Buscar entre tus anuncios" autocomplete="on" value="{{ Request::input('s') }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </li>
                </ul>
            </nav>

            <div id="list-view" class="tab-pane fade active show">
                <div class="row">

                    <!-- Explicit Horizontal Ad -->
                    <ins class="adsbygoogle" style="display:block" data-ad-client="ca-pub-9876511577005081" data-ad-slot="2887444455" data-ad-format="auto" data-full-width-responsive="true"></ins>
                    <script>
                        (adsbygoogle = window.adsbygoogle || []).push({});
                    </script>

                    @if($my_ads)
                    @foreach($my_ads as $ad)
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
                    @endforeach
                    @endif
                    {{ $my_ads->links() }}
                    <hr>
                    <a class="e-widget no-button" href="https://gleam.io/ZdsXz/pullover-bachecubano-youtube" rel="nofollow">Pullover Bachecubano Youtube</a>
                    <script type="text/javascript" src="https://widget.gleamjs.io/e.js" async="true"></script>
                </div>
            </div>
        </div>
    </div>
</div>

@push('script')
<!-- Button Toggle -->
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $('.bs-toggle').change(function() {
        //Ajax call here to the Ad->id;
        var ad = $(this);
        //Disable
        ad.bootstrapToggle('disable');
        $.post("{{ route('disable-ad-ajax') }}?ad_id=" + ad.data("ad_id") + "&api_token=" + user_token, function(data) {
            ad.bootstrapToggle('enable');
        });
    });
</script>
@endpush

@endsection