@extends('user.layout')

@section('user_section')
<div class="page-content">
    <div class="inner-box">
        <div class="dashboard-box">
            <h2 class="dashbord-title">Mis anuncios</h2>
        </div>
        <div class="dashboard-wrapper">
            <nav class="nav-table mb-1">
                <ul>
                    <li @if($request->has('all')) class="active" @endif><a href="{{ route('my_ads') }}?all=1">Todos ({{ $total_active_ads }})</a></li>
                    <li @if($request->has('active')) class="active" @endif><a href="{{ route('my_ads') }}?active=1">Activos</a></li>
                    <li @if($request->has('promoted')) class="active" @endif><a href="{{ route('my_ads') }}?promoted=1">Promovidos</a></li>
                    <li @if($request->has('inactive')) class="active" @endif><a href="{{ route('my_ads') }}?inactive=1">Inactivos</a></li>
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
                </ul>
            </nav>
            <table class="table dashboardtable tablemyads">
                <thead>
                    <tr>
                        <th class="text-center">Foto</th>
                        <th>Precio</th>
                        <th>Título</th>
                        <th class="text-center">Categoría</th>
                        <th class="text-center">Estado</th>
                        <th class="text-center">Ajustes</th>
                    </tr>
                </thead>
                <tbody>
                    @if($my_ads)
                    @foreach($my_ads as $ad)
                    <tr data-category="active">
                        <td class="photo">
                            <img class="img-fluid lazyload" src="{{ ad_first_image($ad) }}" alt="{{ $ad->description->title }}">
                        </td>
                        <td data-title="Price">
                            <h3>{{ ad_price($ad) }}</h3>
                        </td>
                        <td data-title="Title">
                            <a href="{{ ad_url($ad) }}">
                                <h3>{{ $ad->description->title }}</h3>
                            </a>
                            <span>ID: {{ $ad->id }}</span>
                            <span>Promo: {{ ad_promotion_text_type($ad->promo) }} Vence: {{ $ad->promo->end_promo }}</span>
                        </td>
                        <td data-title="Category"><span class="adcategories"><a href="{{ ad_category_url($ad) }}"><i class="lni-{{ $ad->category->description->icon }}"></i> {{ $ad->category->description->name }}</a></span></td>
                        <!-- adstatusactive/adstatusinactive/adstatussold-->
                        <td data-title="Ad Status"><span class="adstatus @if($ad->active == 1) adstatusactive @else adstatusinactive @endif">@if($ad->active == 1) ACTIVO @else INACTIVO @endif</span></td>
                        <td data-title="Action">
                            <div class="btns-actions">
                                <!-- <a class="btn-action btn-view" href="#"><i class="lni-eye"></i></a> Analiticas -->
                                <a class="btn-action btn-view" href="{{ route('promote_ad', ['ad' => $ad]) }}" title="Promocionar anuncio"><i class="lni-dollar"></i></a>
                                <a class="btn-action btn-edit" href="{{ route('ad.edit', ['ad' => $ad]) }}" title="Editar anuncio"><i class="lni-pencil"></i></a>
                                <a class="btn-action btn-delete" href="{{route('delete_ad', ['ad' => $ad])}}?api_token={{Auth::user()->api_token}}" title="Eliminar anuncio"><i class="lni-trash"></i></a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                    @endif
                </tbody>
            </table>
            {{ $my_ads->links() }}
        </div>
    </div>
</div>
@endsection