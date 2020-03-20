<aside id="sidebar" class="col-lg-4 col-md-12 col-xs-12 right-sidebar">
    <!-- Searcg Widget -->
    <div class="widget_search">
        <form id="search-form">
            <input type="search" class="form-control" autocomplete="off" name="s" placeholder="Buscar..." id="search-input" value="">
            <button type="submit" id="search-submit" class="search-btn"><i class="lni-search"></i></button>
        </form>
    </div>

    @auth
    @if(Auth::id() == 1)
    <a class="btn btn-common btn-block mb-5 mt-0" href="{{ route('blog.create') }}">Publicar noticia</a>
    @endif
    @endauth

    <!-- Categories Widget -->
    {{--
    <div class="widget categories">
        <h4 class="widget-title">Todas las Categorías</h4>
        <ul class="categories-list">
            <li>
                <a href="#">
                    <i class="lni-dinner"></i>
                    Hotel & Travels <span class="category-counter">(5)</span>
                </a>
            </li>
            <li>
                <a href="#">
                    <i class="lni-control-panel"></i>
                    Services <span class="category-counter">(8)</span>
                </a>
            </li>
            <li>
                <a href="#">
                    <i class="lni-github"></i>
                    Pets <span class="category-counter">(2)</span>
                </a>
            </li>
            <li>
                <a href="#">
                    <i class="lni-coffee-cup"></i>
                    Restaurants <span class="category-counter">(3)</span>
                </a>
            </li>
            <li>
                <a href="#">
                    <i class="lni-home"></i>
                    Real Estate <span class="category-counter">(4)</span>
                </a>
            </li>
            <li>
                <a href="#">
                    <i class="lni-pencil"></i>
                    Jobs <span class="category-counter">(5)</span>
                </a>
            </li>
            <li>
                <a href="#">
                    <i class="lni-display"></i>
                    Electronics <span class="category-counter">(9)</span>
                </a>
            </li>
        </ul>
    </div>
    --}}

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