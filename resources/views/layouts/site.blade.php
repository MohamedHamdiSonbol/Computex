<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="utf-8">
    <title>Electro - Electronics Website Template</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500;600;700&family=Roboto:wght@400;500;700&display=swap"
        rel="stylesheet">


    <!-- Icon Font Stylesheet -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="{{asset('assets/front/lib/animate/animate.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets/front/lib/owlcarousel/assets/owl.carousel.min.css')}}" rel="stylesheet">


    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{asset('assets/front/css/bootstrap.min.css')}}" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="{{asset('assets/front/css/style.css')}}" rel="stylesheet">


{{--@if(app()->getLocale() == 'ar')--}}

    <!-- مهم جدا لاجل تحويل الواجهة الى اللغة العربية -->
{{--  نقوم بعمل ملف ستايل يعدل على التصميم الاصلي  "تظبيط اشياء بسيطة"--}}
{{--@endif--}}

    <style>
        .track-order-stepper {
            display: flex;
            justify-content: space-between;
            list-style: none;
            padding: 0;
            position: relative;
            margin-top: 30px;
        }

        .track-order-stepper li {
            width: 100%;
            text-align: center;
            position: relative;
            z-index: 1;
        }

        /* THE LINE: Represents the path coming INTO the step */
        .track-order-stepper li::before {
            content: '';
            position: absolute;
            top: 25px;

            /*
               Instead of -50% (the center), we start a bit further right
               and make the width a bit shorter to create the gap.
            */
            left: calc(-50% + 25px); /* +25px pushes the start to the right border of previous circle */
            width: calc(100% - 50px); /* -50px (25px from each side) stops it at the borders */

            height: 3px;
            background: #e0e0e0;
            z-index: -1;
        }

        /* Hide line for the first step */
        .track-order-stepper li:first-child::before {
            display: none;
        }

        /* Change line color to green when this step is reached */
        .track-order-stepper li.active::before {
            background: #28a745;
        }

        /* ICON STYLING */
        .track-order-stepper .icon {
            width: 50px;
            height: 50px;
            background-color: #fff; /* MUST HAVE: This masks the line */
            border: 2px solid #e0e0e0;
            border-radius: 50%;

            /* Center the font-awesome icon */
            display: flex;
            align-items: center;
            justify-content: center;

            margin: 0 auto 10px;
            position: relative; /* Ensures it stays above the ::before line */
            z-index: 2; /* Higher than the line's z-index */

            transition: all 0.3s;
        }

        /* ACTIVE ICON STYLING */
        .track-order-stepper li.active .icon {
            background-color: #28a745; /* Green covers the line for active steps */
            border-color: #28a745;
            color: #fff;
        }

        .track-order-stepper .step-title {
            font-weight: bold;
            margin-bottom: 0;
            font-size: 14px;
        }

        /* This highlights only the most recent completed step */
        .track-order-stepper li.active:last-child .icon,
        .track-order-stepper li.active:not(:has(+ li.active)) .icon {
            box-shadow: 0 0 0 5px rgba(40, 167, 69, 0.25);
            transform: scale(1.1);
        }
    </style>

</head>


<body>

{{--    @include('front.includes.top-bar')--}}
    @includeWhen(!empty($lang), 'front.includes.navbar')

    @yield('content')

    @includeWhen(!empty($lang), 'front.includes.footer')

    @yield('CopyWrite&BackToTop')

    @stack('scripts')

</body>
</html>
