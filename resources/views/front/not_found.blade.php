@extends('layouts.site')

@section('content')
    @include('front.sections.404')
@endsection



@push('scripts')
    <!-- JavaScript Libraries -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{asset('assets/front/lib/wow/wow.min.js')}}"></script>
    <script src="{{asset('assets/front/lib/owlcarousel/owl.carousel.min.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/15.7.1/nouislider.min.js"></script>
    <!-- Template Javascript -->
    <script src="{{asset('assets/front/js/main.js')}}"></script>
@endpush
