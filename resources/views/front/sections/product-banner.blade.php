<!-- Product Banner Start -->
<div class="container-fluid py-5">
    <div class="container">
        <div class="row g-4">

{{--            <div class="col-lg-6 wow fadeInLeft" data-wow-delay="0.1s">--}}
{{--                <a href="#">--}}
{{--                    <div class="bg-primary rounded position-relative">--}}
{{--                        <img src="{{asset('assets/front/img/product-banner.jpg')}}" class="img-fluid w-100 rounded" alt="">--}}
{{--                        <div class="position-absolute top-0 start-0 w-100 h-100 d-flex flex-column justify-content-center rounded p-4"--}}
{{--                             style="background: rgba(255, 255, 255, 0.5);">--}}
{{--                            <h3 class="display-5 text-primary">EOS Rebel <br> <span>T7i Kit</span></h3>--}}
{{--                            <p class="fs-4 text-muted">$899.99</p>--}}
{{--                            <a href="#" class="btn btn-primary rounded-pill align-self-start py-2 px-4">Shop Now</a>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </a>--}}
{{--            </div>--}}

            @isset($biggestDiscountProduct)
                <div class="col-lg-6 wow fadeInRight" data-wow-delay="0.2s">
                    <a href="{{route('front.product.show', $biggestDiscountProduct['slug'])}}">
                        <div class="text-center  rounded position-relative">
                            <img src="{{ $biggestDiscountProduct['image_url'] }}"  style="width: 636px; height: 424px;" alt="">
                            <div class="position-absolute top-0 start-0 w-100 h-100 d-flex flex-column justify-content-center rounded p-4"
                                 style="background: rgba(242, 139, 0, 0.6);">
                                <h2 class="display-2 text-secondary">SALE</h2>
                                <h4 class="display-5 text-white mb-4">Biggest Discount!! Get {{$biggestDiscountProduct['discount_percentage']}} </h4>
                                <a href="{{route('front.product.show', $biggestDiscountProduct['slug'])}}" class="btn btn-secondary rounded-pill align-self-center py-2 px-4">Get It
                                    Now</a>
                            </div>
                        </div>
                    </a>
                </div>
            @endisset

{{--            @if($topSellingProduct && $topSellingProduct->count() > 0)--}}
{{--                <div class="col-lg-6 wow fadeInRight" data-wow-delay="0.2s">--}}
{{--                    <a href="{{route('front.product.show', $topSellingProduct->slug)}}">--}}
{{--                        <div class="text-center bg-primary rounded position-relative">--}}
{{--                            <img src="{{ $topSellingProduct->image_url }}"  style="width: 636px; height: 424px;" alt="">--}}
{{--                            <div class="position-absolute top-0 start-0 w-100 h-100 d-flex flex-column justify-content-center rounded p-4"--}}
{{--                                 style="background: rgba(242, 139, 0, 0.5);">--}}
{{--                                <h2 class="display-2 text-secondary">{{ $topSellingProduct->name }}</h2>--}}
{{--                                <h4 class="display-5 text-white mb-4">Top Selling for this month</h4>--}}
{{--                                <p class="fs-4 text-muted">{{ $topSellingProduct->final_price ?? $topSellingProduct->price }}$ </p>--}}
{{--                                <a href="{{route('front.product.show', $topSellingProduct->slug)}}" class="btn btn-secondary rounded-pill align-self-center py-2 px-4">Get It--}}
{{--                                    Now</a>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </a>--}}
{{--                </div>--}}
{{--            @endif--}}

        </div>
    </div>
</div>
<!-- Product Banner End -->
