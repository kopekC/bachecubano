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

        <div id="list-view" class="tab-pane fade active show">
            <div class="row">
                @include('gads.h')
                @if($popular_ads)
                @foreach($popular_ads as $ad)
                @include('blocks.ad-block-h')
                @endforeach
                @endif
            </div>
        </div>
    </div>
</div>

@endsection