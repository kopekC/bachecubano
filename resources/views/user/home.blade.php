@extends('user.layout')

@section('user_section')

<div class="inner-box">
    <div class="dashboard-box">
        <h2 class="dashbord-title">Mis mejores anuncios</h2>
    </div>
    <div class="dashboard-wrapper">
        <div class="dashboard-sections">
            <div class="row">
                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-4">
                    <div class="dashboardbox">
                        <div class="icon"><i class="lni-write"></i></div>
                        <div class="contentbox">
                            <h2><a href="{{ route('my_ads') }}">Total de anuncios</a></h2>
                            <h3>{{ $total_active_ads }} Anuncos activos</h3>
                        </div>
                    </div>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-4">
                    <div class="dashboardbox">
                        <div class="icon"><i class="lni-star"></i></div>
                        <div class="contentbox">
                            <h2><a href="{{ route('my_ads') }}?promoted=1">Anuncios promovidos</a></h2>
                            <h3>{{ $total_promoted_ads }} Promociones</h3>
                        </div>
                    </div>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-4">
                    <div class="dashboardbox">
                        <div class="icon"><i class="lni-support"></i></div>
                        <div class="contentbox">
                            <h2><a href="#">Ofertas / mensajes</a></h2>
                            <h3>0 Mensajes</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <table class="table {{-- table-responsive --}} dashboardtable tablemyads">
            <thead>
                <tr>
                    <th>Foto</th>
                    <th>Visitas</th>
                    <th>Título</th>
                    <th>Categoría</th>
                    <th>Estado</th>
                    <th>Ajustes</th>
                </tr>
            </thead>
            <tbody>
                @if($popular_ads)
                @foreach($popular_ads as $ad)
                <tr data-category="active">
                    <td class="photo">
                        <img class="img-fluid lazyload" src="{{ ad_first_image($ad) }}" alt="{{ $ad->description->title }}">
                    </td>
                    <td data-title="Hits">
                        <h3>{{ $ad->hits }}</h3>
                    </td>
                    <td data-title="Title">
                        <a href="{{ ad_url($ad) }}">
                            <h3>{{ $ad->description->title }}</h3>
                        </a>
                        <span>ID: {{ $ad->id }}</span>
                    </td>
                    <td data-title="Category"><span class="adcategories"><a href="{{ ad_category_url($ad) }}"><i class="lni-{{ $ad->category->description->icon }}"></i> {{ $ad->category->description->name }}</a></span></td>
                    <!-- adstatusactive/adstatusinactive/adstatussold-->
                    <td data-title="Ad Status"><span class="adstatus adstatusactive">activo</span></td>
                    <td data-title="Action">
                        <div class="btns-actions">
                            <!-- <a class="btn-action btn-view" href="#"><i class="lni-eye"></i></a> Analiticas -->
                            <a class="btn-action btn-edit" href="{{ route('ad.edit', ['ad' => $ad]) }}"><i class="lni-pencil"></i></a>
                            <a class="btn-action btn-delete delete-ad" href="#" data-href="{{ route('ad.destroy', ['ad' => $ad]) }}" title="Eliminar anuncio"><i class="lni-trash"></i></a>
                        </div>
                    </td>
                </tr>
                @endforeach
                @endif
            </tbody>
        </table>
    </div>
</div>

@endsection