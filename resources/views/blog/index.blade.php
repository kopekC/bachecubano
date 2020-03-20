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
                            <p>{!! Str::words($blog_post->body, 100) !!}</p>
                        </div>
                    </div>
                    <!-- Post Content -->
                </div>
                <!-- End Post -->
                @endforeach
                @endif

                {{--
                <!-- Start Post -->
                <div class="blog-post quote-post">
                    <div class="quote-wrap">
                        <i class="fa fa-quote-left"></i>
                        <blockquote class="text-center">
                            Crafting visually stunning memorable experiences
                            <br>
                            for web and interfaces.
                        </blockquote>
                        <i class="fa fa-quote-right"></i>
                    </div>
                </div>
                <!-- End Post -->

                <!-- Start Post -->
                <div class="blog-post video-post">
                    <!-- Post thumb -->
                    <div class="post-thumb">
                        <div class="video-wrapper">
                            <iframe width="100%" height="315" src="https://www.youtube.com/embed/qighCE8WfBk" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
                        </div>
                    </div>
                    <!-- End Post post-thumb -->

                    <!-- Post Content -->
                    <div class="post-content">
                        <ul class="list-inline cat-meta">
                            <li class="tr-cats"><a href="#">Video</a></li>
                        </ul>
                        <h2 class="post-title"><a href="single-post.html">Exercitation Photo Booth</a></h2>
                        <div class="meta">
                            <span class="meta-part"><a href="#"><i class="lni-user"></i> Clasihub</a></span>
                            <span class="meta-part"><a href="#"><i class="lni-alarm-clock"></i> June 21, 2018</a></span>
                            <span class="meta-part"><a href="#"><i class="lni-folder"></i> Sticky</a></span>
                            <span class="meta-part"><a href="#"><i class="lni-comments-alt"></i> 1 Comments</a></span>
                        </div>
                        <div class="entry-summary">
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quis soluta libero molestiae, id reiciendis ipsum consequuntur odit sapiente accusantium odio. Esse nemo quos quaerat illo! Enim saepe impedit distinctio, placeat. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Voluptate voluptatum dolores mollitia consequatur velit, veritatis in pariatur ducimus numquam ipsa iusto! Rem eveniet dolorum, quisquam neque beatae quas ea tenetur!</p>
                        </div>
                        <a href="single-post.html" class="btn btn-common btn-rm">Read More</a>
                    </div>
                    <!-- Post Content -->
                </div>
                <!-- End Post -->
                --}}

                <!-- Start Pagination -->
                @if(isset($posts) && $posts->count() > 0)
                <div class="pagination-bar">
                    {{ $posts->links() }}
                </div>
                @endif
                <!-- End Pagination -->
            </div>

            @include('blog.sidebar')

        </div>
    </div>
</div>
<!-- End Content -->

@endsection