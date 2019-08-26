@extends('layouts.app')

@section('hero')
@include('blocks.hero')
@endsection

@section('content')

@include('blocks.categories')

@include('blocks.top-stores')

{{-- @include('blocks.latest') --}}

@include('blocks.counter')

@include('blocks.featured-listing')

{{-- @include('blocks.testimonial') --}}

@include('blocks.blog-grid')

@include('blocks.subscribe')

@push('script')
<script src="{{ asset('js/jquery.counterup.min.js') }}"></script>
<script>
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
</script>
@endpush

@endsection