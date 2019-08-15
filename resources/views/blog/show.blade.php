@extends('layouts.app')

@section('content')
<!-- Page Header Start -->
<div class="page-header">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="breadcrumb-wrapper">
                    <a href="{{ URL::current() }}">
                        <h2 class="product-title">{{ $post->title }}</h2>
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
                        <a href="{{ URL::current() }}"><img class="img-fluid" src="{{ config('app.img_url') }}/blog/{{ $post->cover }}" alt="{{ $post->title }}"></a>
                        <div class="hover-wrap"></div>
                    </div>
                    <!-- End Post post-thumb -->

                    <!-- Post Content -->
                    <div class="post-content pb-2">
                        <div class="meta">
                            <span class="meta-part"><i class="lni-user"></i> Admin</span>
                            <span class="meta-part"><i class="lni-alarm-clock"></i> {{ $post->created_at->format('d-m-Y') }}</span>
                            <span class="meta-part"><a href="#"><i class="lni-folder"></i> Noticias</a></span>
                            <!-- <span class="meta-part"><a href="#"><i class="lni-comments-alt"></i> 1 Comments</a></span> -->
                        </div>
                        <div class="entry-summary">
                            {!! nl2br($post->body) !!}
                        </div>
                        <div class="share-items">
                            <ul class="list-inline">
                                <li>Compartir: </li>
                                <li class="fb-share"><a href="{{ route('share', ['network' => 'facebook', 'url' => base64_encode(URL::current()), 'text' => base64_encode($post->title)]) }}"><i class="lni-facebook-filled"></i></a></li>
                                <li class="tw-share"><a href="{{ route('share', ['network' => 'twitter', 'url' => base64_encode(URL::current()), 'text' => base64_encode($post->title)]) }}"><i class="lni-twitter-filled"></i></a></li>
                                <li class="li-share"><a href="{{ route('share', ['network' => 'linkedin', 'url' => base64_encode(URL::current()), 'text' => base64_encode($post->title)]) }}"><i class="lni-linkedin-filled"></i></a></li>
                            </ul>
                        </div>
                    </div>
                    <!-- Post Content -->
                </div>
                <!-- End Post -->

                <!-- Disqus -->
                <div id="disqus_thread"></div>
                @push('script')
                <script>
                    var disqus_config = function() {
                        this.page.url = "{{ URL::current() }}";
                        this.page.identifier = "{{ $post->id . $post->slug }}";
                    };
                    (function() { // DON'T EDIT BELOW THIS LINE
                        var d = document,
                            s = d.createElement('script');
                        s.src = 'https://bachecubano.disqus.com/embed.js';
                        s.setAttribute('data-timestamp', +new Date());
                        (d.head || d.body).appendChild(s);
                    })();
                </script>
                <noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
                @endpush

            </div>
            @include('blog.sidebar')
        </div>
    </div>
</div>
<!-- End Content -->

@endsection