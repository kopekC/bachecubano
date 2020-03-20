@extends('layouts.app')

@section('content')

<!-- Page Header Start -->
<div class="page-header">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="breadcrumb-wrapper">
                    <a href="{{ URL::current() }}">
                        <h1 class="product-title">Blog Bachecubano</h1>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Page Header End -->

<ol class="breadcrumb">
    <li><a href="{{ config('app.url') }}">Inicio</a></li>
    <li class="ml-2">/</li>
    <li class="ml-2"><a href="{{ URL::current() }}">Blog Bachecubano</a></li>
</ol>

<!-- Start Content -->
<div id="content" class="section-padding">
    <div class="container">
        <div class="row">

            <div class="col-lg-8 col-md-12 col-xs-12">

                @if(isset($posts) && $posts->count() > 0)
                @foreach($posts as $blog_post)

                <!-- Start Post -->
                <div class="blog-post">
                    <!-- Post thumb -->
                    <div class="post-thumb">
                        <a href="{{ post_url($blog_post) }}"><img class="img-fluid" src="{{ config('app.img_url') }}blog/{{ $blog_post->cover }}" alt="{{ $blog_post->title }}"></a>
                        <div class="hover-wrap"></div>
                    </div>
                    <!-- End Post post-thumb -->

                    <!-- Post Content -->
                    <div class="post-content">
                        <ul class="list-inline cat-meta">
                            <li class="tr-cats"><a href="{{ route('blog_index', ['blog_category_slug' => $blog_post->category->slug]) }}"> {{ $blog_post->category->name }}</a></li>
                        </ul>
                        <h2 class="post-title"><a href="{{ post_url($blog_post) }}">{{ $blog_post->title }}</a></h2>
                        <div class="meta">
                            <span class="meta-part"><a href="#"><i class="lni-user"></i> {{ $blog_post->owner->name }}</a></span>
                            <span class="meta-part"><a href="#"><i class="lni-alarm-clock"></i> {{ $blog_post->updated_at->format('d/m/Y') }}</a></span>
                            {{-- <span class="meta-part"><a href="#"><i class="lni-comments-alt"></i> Comentarios</a></span> --}}
                        </div>
                        <div class="entry-summary">
                            {!! Str::words($blog_post->body, 100) !!}
                        </div>
                    </div>
                    <!-- Post Content -->
                </div>
                <!-- End Post -->

                @endforeach
                @endif
                
            </div>

            <!-- Start Pagination -->
            @if(isset($posts) && $posts->count() > 0)
            <div class="pagination-bar">
                {{ $posts->links() }}
            </div>
            @endif
            <!-- End Pagination -->

            @include('blog.sidebar')

        </div>
    </div>
</div>
<!-- End Content -->

@endsection