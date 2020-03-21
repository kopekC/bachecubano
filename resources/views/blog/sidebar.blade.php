<aside id="sidebar" class="col-lg-4 col-md-12 col-xs-12 right-sidebar">
    <!-- Searcg Widget -->
    <div class="widget_search">
        <form id="search-form" action="{{ route('blog_index') }}" method="get">
            <input type="search" class="form-control" autocomplete="off" name="s" placeholder="Buscar..." id="search-input" value="">
            <button type="submit" id="search-submit" class="search-btn"><i class="lni-search"></i></button>
        </form>
    </div>

    @auth
    @if(Auth::id() == 1)
    <a class="btn btn-primary btn-block mb-2 mt-0" href="{{ route('blog.create') }}">Publicar noticia</a>
    @endif
    @if(isset($blog_post) && Auth::id() == $blog_post->user_id)
    <a class="btn btn-warning btn-block mb-5 mt-0" href="{{ route('blog_post_edit', ['post_id' => $blog_post->id]) }}">Editar noticia</a>
    @endif
    @endauth

    <!-- Categories Widget -->
    <div class="widget categories">
        <h4 class="widget-title">Todas las Categorías</h4>
        <ul class="categories-list">
            @if(isset($blog_categories))
            @foreach($blog_categories as $blog_category)
            <li>
                <a href="{{ config('app.url') . 'blog' . DIRECTORY_SEPARATOR . $blog_category->slug }}">
                    <i class="lni-briefcase"></i> {{ $blog_category->name }} {{--<span class="category-counter">(5)</span>--}}
                </a>
            </li>
            @endforeach
            @endif
        </ul>
    </div>

    @include('gads.v')

    <!-- Popular Posts widget -->
    <div class="widget widget-popular-posts">
        <h4 class="widget-title">Publicaciones recientes</h4>
        <ul class="posts-list">
            @if(isset($posts) && $posts->count() > 0)
            @foreach($posts as $blog_post)
            <li>
                <div class="widget-thumb">
                    <a href="{{ post_url($blog_post) }}"><img src="{{ config('app.img_url') }}/blog/{{ $blog_post->cover }}" alt="{{ $blog_post->title }}" loading=lazy></a>
                </div>
                <div class="widget-content">
                    <a href="{{ post_url($blog_post) }}">{{ $blog_post->title }}</a>
                    <span><i class="icon-calendar"></i>{{ $blog_post->updated_at->format('d/m/Y') }}</span>
                </div>
                <div class="clearfix"></div>
            </li>
            @endforeach
            @endif
        </ul>
    </div>
</aside>