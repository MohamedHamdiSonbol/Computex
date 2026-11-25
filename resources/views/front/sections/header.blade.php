<!-- Single Page Header start -->
<div class="container page-header py-5"
     style="background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)),
            url('{{ isset($category) ? asset($category['image_url']) : asset('assets/front/img/default-header.jpg') }}');">

    <h1 class="text-center text-white display-6 wow fadeInUp" data-wow-delay="0.1s">
        {{ isset($category) ? $category['name'] : 'Shop Page' }}
    </h1>

    <ol class="breadcrumb justify-content-center mb-0 wow fadeInUp" data-wow-delay="0.3s">
        <li class="breadcrumb-item"><a href="{{ route('front.home') }}">Home</a></li>
        <li class="breadcrumb-item active text-white">
            {{ isset($category) ? $category['name'] : 'Shop' }}
        </li>
    </ol>
</div>
<!-- Single Page Header End -->
