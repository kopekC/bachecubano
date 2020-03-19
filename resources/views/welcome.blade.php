@extends('layouts.app')

@section('hero')
@include('blocks.hero')
@endsection

@section('content')

@include('blocks.categories')

{{--
@include('blocks.top-stores')
--}}

{{-- 
@include('blocks.latest') 
--}}

@include('blocks.featured-listing')

{{-- 
@include('blocks.testimonial') 
--}}

@include('blocks.blog-grid')

{{-- 
@include('blocks.subscribe')
--}}

@endsection