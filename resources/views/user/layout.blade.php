@extends('layouts.app')

@section('content')

<!-- Page Header Start -->
<div class="page-header">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="breadcrumb-wrapper">
                    <a href="{{ URL::current() }}">
                        <h2 class="product-title">{{ $section_name }}</h2>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Page Header End -->

<!-- Start Content -->
<div id="content" class="section-padding">
    <div class="container-fluid">
        <div class="row">

            <div class="col-sm-12 col-md-4 col-lg-3 col-xl-2 page-sidebar">
                @auth
                @include('user.sidebar')
                @endauth
            </div>

            <div class="col-sm-12 col-md-8 col-lg-9 col-xl-10">

                <!-- notifications area -->
                @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
                @endif
                @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <!-- Dinamic section -->
                @yield('user_section')
            </div>
        </div>
    </div>
</div>
<!-- End Content -->

@push('script')
<!-- ManyChat only visible on user pages -->
<script async src="//widget.manychat.com/1407854356137306.js"></script>
@endpush

@endsection