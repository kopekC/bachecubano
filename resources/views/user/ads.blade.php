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
                    @include('gads.h')
                    @if($my_ads)
                    @foreach($my_ads as $ad)
                    @include('blocks.ad-block-h')
                    @endforeach
                    @endif
                    {{ $my_ads->links() }}
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