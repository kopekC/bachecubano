<!-- Featured Listings Start -->
<section class="featured-lis section-padding bg-drack">
    <div class="container">
        <h3 class="section-title">Anuncios Promocionados</h3>
        <div class="row" data-wow-delay="0.5s">
            @foreach($promoted_ads as $ad)
            @include('blocks.ad-block')
            @endforeach
        </div>
    </div>
</section>
<!-- Featured Listings End -->