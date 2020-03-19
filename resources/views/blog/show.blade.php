@extends('layouts.app')

@section('content')
<!-- Page Header Start -->
<div class="page-header">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="breadcrumb-wrapper">
                    <a href="{{ URL::current() }}">
                        <h2 class="product-title">{{ $blog_post->title }}</h2>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Page Header End -->

<!-- Start Content -->
<div id="content" class="section-padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-12 col-xs-12">
                <!-- Start Post -->
                <div class="blog-post single-post">

                    <!-- Post thumb -->
                    <div class="post-thumb">
                        <a href="{{ URL::current() }}">
                            <img class="img-fluid" src="{{ config('app.img_url') }}blog/{{ $blog_post->cover }}" alt="{{ $blog_post->title }}" loading=lazy>
                        </a>
                        <div class="hover-wrap"></div>
                    </div>
                    <!-- End Post post-thumb -->

                    <!-- Post Content -->
                    <div class="post-content pb-2">
                        <div class="meta">
                            <span class="meta-part"><i class="lni-user"></i> {{ $blog_post->owner->name }}</span>
                            <span class="meta-part"><i class="lni-alarm-clock"></i> {{ $blog_post->created_at->format('d/m/Y') }}</span>
                            <span class="meta-part"><a href="{{ route('blog_index', ['blog_category_slug' => $blog_post->category->slug]) }}"><i class="lni-folder"></i> {{ $blog_post->category->name }}</a></span>
                        </div>
                        <div class="entry-summary">
                            {!! nl2br($blog_post->body) !!}
                        </div>
                        <div class="share-items">
                            <ul class="list-inline">
                                <li>Compartir: </li>
                                <li class="fb-share"><a href="{{ route('share', ['network' => 'facebook', 'url' => base64_encode(URL::current()), 'text' => base64_encode($blog_post->title)]) }}"><i class="lni-facebook-filled"></i></a></li>
                                <li class="tw-share"><a href="{{ route('share', ['network' => 'twitter', 'url' => base64_encode(URL::current()), 'text' => base64_encode($blog_post->title)]) }}"><i class="lni-twitter-filled"></i></a></li>
                                <li class="li-share"><a href="{{ route('share', ['network' => 'linkedin', 'url' => base64_encode(URL::current()), 'text' => base64_encode($blog_post->title)]) }}"><i class="lni-linkedin-filled"></i></a></li>
                            </ul>
                        </div>
                    </div>
                    <!-- Post Content -->
                </div>
                <!-- End Post -->
            </div>
            @include('blog.sidebar')
        </div>
    </div>
</div>
<!-- End Content -->

@endsection