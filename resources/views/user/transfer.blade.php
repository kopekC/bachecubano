@extends('user.layout')

@section('user_section')
<div class="page-content">
    <div class="inner-box">
        <div class="dashboard-box">
            <h2 class="dashbord-title">Transferir saldo entre usuarios</h2>
        </div>
        <div class="dashboard-wrapper">
            <div class="row form-dashboard">
                @foreach($my_likes as $liked)
                @php
                $ad = $liked->likable
                @endphp
                @include('blocks.ad-block')
                @endforeach
            </div>
        </div>
    </div>
</div>

@endsection