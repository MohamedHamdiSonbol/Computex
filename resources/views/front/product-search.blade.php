@extends('layouts.site')

@section('content')
{{--    @include('front.sections.header')--}}
    @include('front.sections.search')
    {{--    @include('front.sections.carousel')--}}
    {{--    @include('front.sections.services')--}}
    {{--    @include('front.sections.product-list')--}}
    {{--    @include('front.sections.our-products')--}}
    {{--    @include('front.sections.product-banner')--}}
    {{--    @include('front.sections.products-offer')--}}
    {{--    @include('front.sections.bestseller-products')--}}
@endsection

@section('CopyWrite&BackToTop')
    @include('front.includes.copyright')
    @include('front.includes.back-to-top')
@endsection


@push('scripts')
    <!-- JavaScript Libraries -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{asset('assets/front/lib/wow/wow.min.js')}}"></script>
    <script src="{{asset('assets/front/lib/owlcarousel/owl.carousel.min.js')}}"></script>

    <!-- Template Javascript -->
    <script src="{{asset('assets/front/js/main.js')}}"></script>
@endpush
