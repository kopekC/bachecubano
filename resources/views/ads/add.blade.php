@extends('layouts.app')

@section('content')

<!-- Page Header Start -->
<div class="page-header">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="breadcrumb-wrapper">
                    <a href="{{ route('add') }}">
                        <h1 class="h2 product-title">Publicar anuncio</h1>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Page Header End -->

<!-- Start Content -->
<div id="content" class="section-padding">
    <div class="container-luid">
        <div class="row">

            <div class="col-sm-12 col-md-4 col-lg-3 page-sidebar">
                @auth
                @include('user.sidebar')
                @endauth
            </div>

            <div class="col-sm-12 col-md-8 col-lg-9">
                <div class="row page-content">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-7">
                        <div class="inner-box">
                            <div class="dashboard-box">
                                <h2 class="dashbord-title">Ad Detail</h2>
                            </div>
                            <div class="dashboard-wrapper">
                                <div class="form-group mb-3">
                                    <label class="control-label">Project Title</label>
                                    <input class="form-control input-md" name="Title" placeholder="Title" type="text">
                                </div>
                                <div class="form-group mb-3 tg-inputwithicon">
                                    <label class="control-label">Categories</label>
                                    <div class="tg-select form-control">
                                        <select>
                                            <option value="none">Select Categories</option>
                                            <option value="none">Mobiles</option>
                                            <option value="none">Electronics</option>
                                            <option value="none">Training</option>
                                            <option value="none">Real Estate</option>
                                            <option value="none">Services</option>
                                            <option value="none">Training</option>
                                            <option value="none">Vehicles</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group mb-3">
                                    <label class="control-label">Price Title</label>
                                    <input class="form-control input-md" name="price" placeholder="Ad your Price" type="text">
                                    <div class="tg-checkbox mt-3">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="tg-priceoncall">
                                            <label class="custom-control-label" for="tg-priceoncall">Price On Call</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group md-3">
                                    <textarea name="description"></textarea>
                                </div>
                                <label class="tg-fileuploadlabel" for="tg-photogallery">
                                    <span>Drop files anywhere to upload</span>
                                    <span>Or</span>
                                    <span class="btn btn-common">Select Files</span>
                                    <span>Maximum upload file size: 500 KB</span>
                                    <input id="tg-photogallery" class="tg-fileinput" type="file" name="file">
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-5">
                        <div class="inner-box">
                            <div class="tg-contactdetail">
                                <div class="dashboard-box">
                                    <h2 class="dashbord-title">Contact Detail</h2>
                                </div>
                                <div class="dashboard-wrapper">
                                    <div class="form-group mb-3">
                                        <strong>I’m a:</strong>
                                        <div class="tg-selectgroup">
                                            <span class="tg-radio">
                                                <input id="tg-sameuser" type="radio" name="usertype" value="same user" checked="">
                                                <label for="tg-sameuser">Same User</label>
                                            </span>
                                            <span class="tg-radio">
                                                <input id="tg-someoneelse" type="radio" name="usertype" value="someone else">
                                                <label for="tg-someoneelse">Someone Else</label>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label class="control-label">First Name*</label>
                                        <input class="form-control input-md" name="name" type="text">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label class="control-label">Last Name*</label>
                                        <input class="form-control input-md" name="name" type="text">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label class="control-label">Phone*</label>
                                        <input class="form-control input-md" name="phone" type="text">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label class="control-label">Enter Address</label>
                                        <input class="form-control input-md" name="address" type="text">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label class="control-label">Enter Address</label>
                                        <input class="form-control input-md" name="address" type="text">
                                    </div>
                                    <div class="form-group mb-3 tg-inputwithicon">
                                        <label class="control-label">Country</label>
                                        <div class="tg-select form-control">
                                            <select>
                                                <option value="none">Select Country</option>
                                                <option value="none">Country 1</option>
                                                <option value="none">Country 2</option>
                                                <option value="none">Country 3</option>
                                                <option value="none">Country 4</option>
                                                <option value="none">Country 5</option>
                                                <option value="none">Country 6</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group mb-3 tg-inputwithicon">
                                        <label class="control-label">State</label>
                                        <div class="tg-select form-control">
                                            <select>
                                                <option value="none">Select State</option>
                                                <option value="none">Select State</option>
                                                <option value="none">Select State</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group mb-3 tg-inputwithicon">
                                        <label class="control-label">City</label>
                                        <div class="tg-select form-control">
                                            <select>
                                                <option value="none">Select City</option>
                                                <option value="none">Select City</option>
                                                <option value="none">Select City</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="tg-checkbox">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="tg-agreetermsandrules">
                                            <label class="custom-control-label" for="tg-agreetermsandrules">I agree to all <a href="javascript:void(0);">Terms of Use &amp; Posting Rules</a></label>
                                        </div>
                                    </div>
                                    <button class="btn btn-common" type="button">Post Ad</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Content -->

<!-- featured Listing -->
@include('blocks.featured-listing')
<!-- featured Listing -->

@push('script')
<script src="{{ asset('js/form-validator.min.js') }}"></script>
@endpush

@endsection