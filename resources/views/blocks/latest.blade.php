<!-- Featured Section Start -->
<section class="featured section-padding bg-drack">
    <div class="container">
        <h1 class="section-title">Publicado recientemente</h1>
        <div class="row">
            @foreach($latest_ads as $ad)
            @include('blocks.ad-block')
            @endforeach
        </div>
    </div>
</section>
<!-- Featured Section End -->