<!-- Blog Grid Start -->
<section class="blog-grid section-padding bg-drack">
    <div class="container">
        <h3 class="section-title">Últimas noticias</h3>
        <div class="row">
            @foreach($latest_blog_post as $blog_post)
            <div class="col-lg-4 col-md-6 col-xs-12">
                <div class="blog-post-item">
                    <div class="post-thumb">
                        <figure>
                            <img src="{{ config('app.img_url') }}/blog/{{ $blog_post->cover }}" alt="{{ $blog_post->title }}">
                        </figure>
                        <div class="post-categories">
                            <a href="#"></a>
                        </div>
                    </div>
                    <div class="post-item-content">
                        <div class="post-date">{{ $blog_post->created_at->diffForHumans() }}</div>
                        <h4 class="post-title"><a href="{{ route('blog_post', ['entry_slug' => $blog_post->slug]) }}">{{ $blog_post->title }}</a></h4>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
<!-- Blog Grid End -->