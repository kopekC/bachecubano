@extends('layouts.app')

@section('hero')
@include('blocks.hero')
@endsection

@section('content')

@include('blocks.categories')

@include('blocks.top-stores')

@include('blocks.latest')

@include('blocks.counter')

@include('blocks.featured-listing')

@include('blocks.testimonial')

@include('blocks.blog-grid')

@include('blocks.subscribe')

@push('script')
<script>
    /* Counter
    ========================================================*/
    $('.counterUp').counterUp({
        delay: 10,
        time: 1000
    });

    /* Search
    ========================================================*/
    $('.search-query .form-control').on('click', function(e) {
        e.stopPropagation();
        $(this).parent().toggleClass('query-focus');
    });
    $('body').on('click', function() {
        if ($('.search-query').hasClass('query-focus')) {
            $('.search-query').removeClass('query-focus');
        }
    });
    $('.search-suggestion').on('click', function(e) {
        e.stopPropagation();
    });

    /* Testimonials Carousel 
    ========================================================*/
    var owl = $("#testimonials");
    owl.owlCarousel({
        navigation: false,
        pagination: true,
        slideSpeed: 1000,
        stopOnHover: true,
        autoPlay: true,
        items: 2,
        itemsDesktop: [1199, 2],
        itemsDesktopSmall: [980, 2],
        itemsTablet: [768, 1],
        itemsTablet: [767, 1],
        itemsTabletSmall: [480, 1],
        itemsMobile: [479, 1],
    });
</script>
@endpush

@endsection