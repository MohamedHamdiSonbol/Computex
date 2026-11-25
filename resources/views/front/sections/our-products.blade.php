<!-- Our Products Start -->
<div class="container-fluid product my-5 wow fadeInUp"  style="background-color: rgba(0,0,0,0.035)">
    <div class="container py-2">
        <div class="tab-class">
            <div class="row g-4">
                <div class="col-lg-4 text-sm-center {{$lang==='ar'? 'text-lg-end':'text-lg-start'}}" >
                    <h1 class="">{{__('front/labels.our_products')}}</h1>
                </div>
                <div class="col-lg-8 text-sm-center {{$lang==='ar'? 'text-lg-start':'text-lg-end'}} pt-2" >
                    <ul class="nav nav-pills d-inline-flex text-center  mb-5">

                        <li class="nav-item mb-4 mx-sm-2 mx-lg-4">
                            <a class="d-flex py-2 px-2 shadow border btn btn-lg bg-light rounded-pill fw-bold active" data-bs-toggle="pill"
                               href="#tab-1">
                                <span class="text-dark">{{__('front/labels.all_products')}}</span>
                            </a>
                        </li>

                        <li class="nav-item mb-4 mx-sm-2 mx-lg-4">
                            <a class="d-flex py-2  px-3 btn btn-lg shadow border bg-light rounded-pill fw-bold " data-bs-toggle="pill" href="#tab-2" id="newArrivalsBtn" data-url="{{ route('front.newArrivalProducts') }}">
                                <span class="text-dark">{{__('front/labels.new_arrival')}}</span>
                            </a>
                        </li>

{{--                        <li class="nav-item mb-4">--}}
{{--                            <a class="d-flex mx-2 py-2 bg-light rounded-pill" data-bs-toggle="pill" href="#tab-3">--}}
{{--                                <span class="text-dark" style="width: 130px;">Featured</span>--}}
{{--                            </a>--}}
{{--                        </li>--}}

                        <li class="nav-item mb-4 {{$lang==='ar'? 'me-sm-2 me-lg-4':'ms-sm-2 ms-lg-4'}}">
                            <a class="d-flex  py-2 px-3 btn btn-lg shadow border bg-light rounded-pill fw-bold " data-bs-toggle="pill" href="#tab-4" id="topSellingBtn"  data-url="{{ route('front.topSellingProducts') }}" >
                                <span class="text-dark"> {{__('front/labels.top_selling')}}</span>
                            </a>
                        </li>

                    </ul>
                </div>
            </div>
            <div class="tab-content">
                <div id="tab-1" class="tab-pane fade show p-0 active">
                    <div class="row g-4">
                        @foreach($products as $product)

                            <div class="col-md-6 col-lg-4 col-xl-3 ">
                                {{-------------------------------------------------------------------------------}}
                                <div class="product-item shadow bg-white rounded wow fadeInUp product-data-container" data-wow-delay="0.1s">
                                    <div class="product-item-inner border rounded">
                                        <div class="product-item-inner-item">
                                            <img src="{{$product['image_url']}}" class=" rounded-top" alt="" style="height: 15rem; width: 100%;">
                                            @if($product['discount_amount'])
                                            <div class="product-sale text-center">{{$product['discount_percentage'] .' '. __('front/labels.off') }}  </div>
                                            @endif
                                            @if($product['new'])
                                            <div class="product-new">{{ __('front/labels.'.$product['new']) }}</div>
                                            @endif
                                            <div class="product-details">
                                                <a href="{{route('front.product.show', $product['slug'])}}" class="stretched-link"><i class="fa fa-eye fa-1x"></i></a>
                                            </div>
                                        </div>
                                        <div class="row m-0  rounded-bottom p-0 ">
                                            <div class="row m-0 mb-1 mt-1 p-0 justify-content-between">
                                                <a href="{{route('front.category.show', $product['category_slug'])}}" class="w-auto small-lg">{{ $product['category']}}</a>
                                                <a href="#" class="w-auto px-3 p-0 small-lg text-end" >{{ $product['brand']}}</a>
                                            </div>

                                            <div class="row m-0 my-1 p-0 ">
                                                <a href="{{route('front.product.show', $product['slug'])}}" class="col-md-12 h5">{{ $product['name']}}</a>
                                            </div>

                                            <div class="row m-0 mt-1 p-0 justify-content-sm-center justify-content-lg-start">
                                                <strong class="w-auto h5 {{$lang==='ar'? 'ps-3':'pe-3'}} text-primary ">{{ $product['final_price'] .' '. __('front/labels.currency') }}
                                                </strong>
                                                @if($product['discount_amount'])
                                                    <del class="w-auto p-0 small">{{$product['price'] .' '. __('front/labels.currency') }}
                                                    </del>
                                                @endif
                                            </div>

                                            <div class="row  my-1 ms-0 align-items-center">
                                                @if(count($product['colors']) > 0)
                                                    <p class="w-auto p-0 m-0">{{__('front/labels.colors')}}: </p>
                                                    <div class="w-auto {{$lang==='ar'? 'pe-3':'ps-3'}} row color-container">
                                                        @foreach($product['colors'] as $color )
                                                            <div class="rounded-circle color_btn w-auto me-2 " style="background-color:{{$color['name']}}; width: 20px; height: 20px" data-colorId="{{$color['id']}}"></div>
                                                       @endforeach()
                                                    </div>
                                                @endif
                                            </div>

                                            <div class="row col-md-12 mt-2 pb-2 ms-0 align-items-center">
                                                <small class="p-0">{{__('front/labels.available')}}: <strong class="{{ $product['quantity'] < 5 ? 'text-danger':'text-success' }}">{{$product['quantity'] }}  {{__('front/labels.items_in_stock')}}</strong></small>
                                            </div>
                                        </div>
                                    </div>

                                    <div
                                        class="product-item-add border border-top-0 rounded-bottom text-center  pt-0">
                                        <a href="#" class="btn btn-primary border-secondary rounded-pill py-2 px-4 my-2 position-relative z-1 js-add-to-cart" data-url="{{ route('front.cart.add', $product['product_id']) }}" data-colorId="{{$product['colors'][0]['id']?? null}}">
                                            <i class="fas fa-shopping-cart me-2"></i> {{__('front/labels.add_to_cart')}}
                                        </a>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="d-flex">
                                                <i class="fas fa-star text-primary"></i>
                                                <i class="fas fa-star text-primary"></i>
                                                <i class="fas fa-star text-primary"></i>
                                                <i class="fas fa-star text-primary"></i>
                                                <i class="fas fa-star"></i>
                                            </div>
                                            <div class="d-flex">
                                                <a href="#"
                                                   class="text-primary d-flex align-items-center justify-content-center me-3"><span
                                                        class="rounded-circle btn-sm-square border"><i
                                                            class="fas fa-random"></i></i></a>
                                                <a href="#"
                                                   class="text-primary d-flex align-items-center justify-content-center me-0"><span
                                                        class="rounded-circle btn-sm-square border"><i
                                                            class="fas fa-heart"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach

{{--                        <div class="col-md-6 col-lg-4 col-xl-3">--}}
{{--                            <div class="product-item rounded wow fadeInUp" data-wow-delay="0.3s">--}}
{{--                                <div class="product-item-inner border rounded">--}}
{{--                                    <div class="product-item-inner-item">--}}
{{--                                        <img src="{{asset('assets/front/img/product-4.png')}}" class="img-fluid w-100 rounded-top"--}}
{{--                                             alt="Image" >--}}
{{--                                        <div class="product-sale">sale</div>--}}
{{--                                        <div class="product-details">--}}
{{--                                            <a href="#"><i class="fa fa-eye fa-1x"></i></a>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <div class="text-center rounded-bottom p-4">--}}
{{--                                        <a href="#" class="d-block mb-2">SmartPhone</a>--}}
{{--                                        <a href="#" class="d-block h4">Apple iPad Mini <br> G2356</a>--}}
{{--                                        <del class="me-2 fs-5">$1,250.00</del>--}}
{{--                                        <span class="text-primary fs-5">$1,050.00</span>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <div--}}
{{--                                    class="product-item-add border border-top-0 rounded-bottom  text-center p-4 pt-0">--}}
{{--                                    <a href="#"--}}
{{--                                       class="btn btn-primary border-secondary rounded-pill py-2 px-4 mb-4"><i--}}
{{--                                            class="fas fa-shopping-cart me-2"></i> Add To Cart</a>--}}
{{--                                    <div class="d-flex justify-content-between align-items-center">--}}
{{--                                        <div class="d-flex">--}}
{{--                                            <i class="fas fa-star text-primary"></i>--}}
{{--                                            <i class="fas fa-star text-primary"></i>--}}
{{--                                            <i class="fas fa-star text-primary"></i>--}}
{{--                                            <i class="fas fa-star text-primary"></i>--}}
{{--                                            <i class="fas fa-star"></i>--}}
{{--                                        </div>--}}
{{--                                        <div class="d-flex">--}}
{{--                                            <a href="#"--}}
{{--                                               class="text-primary d-flex align-items-center justify-content-center me-3"><span--}}
{{--                                                    class="rounded-circle btn-sm-square border"><i--}}
{{--                                                        class="fas fa-random"></i></i></a>--}}
{{--                                            <a href="#"--}}
{{--                                               class="text-primary d-flex align-items-center justify-content-center me-0"><span--}}
{{--                                                    class="rounded-circle btn-sm-square border"><i--}}
{{--                                                        class="fas fa-heart"></i></a>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="col-md-6 col-lg-4 col-xl-3">--}}
{{--                            <div class="product-item rounded wow fadeInUp" data-wow-delay="0.5s">--}}
{{--                                <div class="product-item-inner border rounded">--}}
{{--                                    <div class="product-item-inner-item">--}}
{{--                                        <img src="{{asset('assets/front/img/product-5.png')}}" class="img-fluid w-100 rounded-top"--}}
{{--                                             alt="Image">--}}
{{--                                        <div class="product-details">--}}
{{--                                            <a href="#"><i class="fa fa-eye fa-1x"></i></a>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <div class="text-center rounded-bottom p-4">--}}
{{--                                        <a href="#" class="d-block mb-2">SmartPhone</a>--}}
{{--                                        <a href="#" class="d-block h4">Apple iPad Mini <br> G2356</a>--}}
{{--                                        <del class="me-2 fs-5">$1,250.00</del>--}}
{{--                                        <span class="text-primary fs-5">$1,050.00</span>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <div--}}
{{--                                    class="product-item-add border border-top-0 rounded-bottom  text-center p-4 pt-0">--}}
{{--                                    <a href="#"--}}
{{--                                       class="btn btn-primary border-secondary rounded-pill py-2 px-4 mb-4"><i--}}
{{--                                            class="fas fa-shopping-cart me-2"></i> Add To Cart</a>--}}
{{--                                    <div class="d-flex justify-content-between align-items-center">--}}
{{--                                        <div class="d-flex">--}}
{{--                                            <i class="fas fa-star text-primary"></i>--}}
{{--                                            <i class="fas fa-star text-primary"></i>--}}
{{--                                            <i class="fas fa-star text-primary"></i>--}}
{{--                                            <i class="fas fa-star text-primary"></i>--}}
{{--                                            <i class="fas fa-star"></i>--}}
{{--                                        </div>--}}
{{--                                        <div class="d-flex">--}}
{{--                                            <a href="#"--}}
{{--                                               class="text-primary d-flex align-items-center justify-content-center me-3"><span--}}
{{--                                                    class="rounded-circle btn-sm-square border"><i--}}
{{--                                                        class="fas fa-random"></i></i></a>--}}
{{--                                            <a href="#"--}}
{{--                                               class="text-primary d-flex align-items-center justify-content-center me-0"><span--}}
{{--                                                    class="rounded-circle btn-sm-square border"><i--}}
{{--                                                        class="fas fa-heart"></i></a>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="col-md-6 col-lg-4 col-xl-3">--}}
{{--                            <div class="product-item rounded wow fadeInUp" data-wow-delay="0.7s">--}}
{{--                                <div class="product-item-inner border rounded">--}}
{{--                                    <div class="product-item-inner-item">--}}
{{--                                        <img src="{{asset('assets/front/img/product-6.png')}}" class="img-fluid w-100 rounded-top"--}}
{{--                                             alt="Image">--}}
{{--                                        <div class="product-new">New</div>--}}
{{--                                        <div class="product-details">--}}
{{--                                            <a href="#"><i class="fa fa-eye fa-1x"></i></a>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <div class="text-center rounded-bottom p-4">--}}
{{--                                        <a href="#" class="d-block mb-2">SmartPhone</a>--}}
{{--                                        <a href="#" class="d-block h4">Apple iPad Mini <br> G2356</a>--}}
{{--                                        <del class="me-2 fs-5">$1,250.00</del>--}}
{{--                                        <span class="text-primary fs-5">$1,050.00</span>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <div--}}
{{--                                    class="product-item-add border border-top-0 rounded-bottom  text-center p-4 pt-0">--}}
{{--                                    <a href="#"--}}
{{--                                       class="btn btn-primary border-secondary rounded-pill py-2 px-4 mb-4"><i--}}
{{--                                            class="fas fa-shopping-cart me-2"></i> Add To Cart</a>--}}
{{--                                    <div class="d-flex justify-content-between align-items-center">--}}
{{--                                        <div class="d-flex">--}}
{{--                                            <i class="fas fa-star text-primary"></i>--}}
{{--                                            <i class="fas fa-star text-primary"></i>--}}
{{--                                            <i class="fas fa-star text-primary"></i>--}}
{{--                                            <i class="fas fa-star text-primary"></i>--}}
{{--                                            <i class="fas fa-star"></i>--}}
{{--                                        </div>--}}
{{--                                        <div class="d-flex">--}}
{{--                                            <a href="#"--}}
{{--                                               class="text-primary d-flex align-items-center justify-content-center me-3"><span--}}
{{--                                                    class="rounded-circle btn-sm-square border"><i--}}
{{--                                                        class="fas fa-random"></i></i></a>--}}
{{--                                            <a href="#"--}}
{{--                                               class="text-primary d-flex align-items-center justify-content-center me-0"><span--}}
{{--                                                    class="rounded-circle btn-sm-square border"><i--}}
{{--                                                        class="fas fa-heart"></i></a>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="col-md-6 col-lg-4 col-xl-3">--}}
{{--                            <div class="product-item rounded wow fadeInUp" data-wow-delay="0.1s">--}}
{{--                                <div class="product-item-inner border rounded">--}}
{{--                                    <div class="product-item-inner-item">--}}
{{--                                        <img src="{{asset('assets/front/img/product-7.png')}}" class="img-fluid w-100 rounded-top"--}}
{{--                                             alt="Image">--}}
{{--                                        <div class="product-sale">Sale</div>--}}
{{--                                        <div class="product-details">--}}
{{--                                            <a href="#"><i class="fa fa-eye fa-1x"></i></a>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <div class="text-center rounded-bottom p-4">--}}
{{--                                        <a href="#" class="d-block mb-2">SmartPhone</a>--}}
{{--                                        <a href="#" class="d-block h4">Apple iPad Mini <br> G2356</a>--}}
{{--                                        <del class="me-2 fs-5">$1,250.00</del>--}}
{{--                                        <span class="text-primary fs-5">$1,050.00</span>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <div--}}
{{--                                    class="product-item-add border border-top-0 rounded-bottom  text-center p-4 pt-0">--}}
{{--                                    <a href="#"--}}
{{--                                       class="btn btn-primary border-secondary rounded-pill py-2 px-4 mb-4"><i--}}
{{--                                            class="fas fa-shopping-cart me-2"></i> Add To Cart</a>--}}
{{--                                    <div class="d-flex justify-content-between align-items-center">--}}
{{--                                        <div class="d-flex">--}}
{{--                                            <i class="fas fa-star text-primary"></i>--}}
{{--                                            <i class="fas fa-star text-primary"></i>--}}
{{--                                            <i class="fas fa-star text-primary"></i>--}}
{{--                                            <i class="fas fa-star text-primary"></i>--}}
{{--                                            <i class="fas fa-star"></i>--}}
{{--                                        </div>--}}
{{--                                        <div class="d-flex">--}}
{{--                                            <a href="#"--}}
{{--                                               class="text-primary d-flex align-items-center justify-content-center me-3"><span--}}
{{--                                                    class="rounded-circle btn-sm-square border"> </span><i--}}
{{--                                                    class="fas fa-random"></i></a>--}}

{{--                                            <a href="#"--}}
{{--                                               class="text-primary d-flex align-items-center justify-content-center me-0"><span--}}
{{--                                                    class="rounded-circle btn-sm-square border"> </span><i--}}
{{--                                                    class="fas fa-heart"></i></a>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="col-md-6 col-lg-4 col-xl-3">--}}
{{--                            <div class="product-item rounded wow fadeInUp" data-wow-delay="0.3s">--}}
{{--                                <div class="product-item-inner border rounded">--}}
{{--                                    <div class="product-item-inner-item">--}}
{{--                                        <img src="{{asset('assets/front/img/product-8.png')}}" class="img-fluid w-100 rounded-top"--}}
{{--                                             alt="Image">--}}
{{--                                        <div class="product-details">--}}
{{--                                            <a href="#"><i class="fa fa-eye fa-1x"></i></a>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <div class="text-center rounded-bottom p-4">--}}
{{--                                        <a href="#" class="d-block mb-2">SmartPhone</a>--}}
{{--                                        <a href="#" class="d-block h4">Apple iPad Mini <br> G2356</a>--}}
{{--                                        <del class="me-2 fs-5">$1,250.00</del>--}}
{{--                                        <span class="text-primary fs-5">$1,050.00</span>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <div--}}
{{--                                    class="product-item-add border border-top-0 rounded-bottom  text-center p-4 pt-0">--}}
{{--                                    <a href="#"--}}
{{--                                       class="btn btn-primary border-secondary rounded-pill py-2 px-4 mb-4"><i--}}
{{--                                            class="fas fa-shopping-cart me-2"></i> Add To Cart</a>--}}
{{--                                    <div class="d-flex justify-content-between align-items-center">--}}
{{--                                        <div class="d-flex">--}}
{{--                                            <i class="fas fa-star text-primary"></i>--}}
{{--                                            <i class="fas fa-star text-primary"></i>--}}
{{--                                            <i class="fas fa-star text-primary"></i>--}}
{{--                                            <i class="fas fa-star text-primary"></i>--}}
{{--                                            <i class="fas fa-star"></i>--}}
{{--                                        </div>--}}
{{--                                        <div class="d-flex">--}}
{{--                                            <a href="#"--}}
{{--                                               class="text-primary d-flex align-items-center justify-content-center me-3"><span--}}
{{--                                                    class="rounded-circle btn-sm-square border"><i--}}
{{--                                                        class="fas fa-random"></i></i></a>--}}
{{--                                            <a href="#"--}}
{{--                                               class="text-primary d-flex align-items-center justify-content-center me-0"><span--}}
{{--                                                    class="rounded-circle btn-sm-square border"><i--}}
{{--                                                        class="fas fa-heart"></i></a>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="col-md-6 col-lg-4 col-xl-3">--}}
{{--                            <div class="product-item rounded wow fadeInUp" data-wow-delay="0.5s">--}}
{{--                                <div class="product-item-inner border rounded">--}}
{{--                                    <div class="product-item-inner-item">--}}
{{--                                        <img src="{{asset('assets/front/img/product-9.png')}}" class="img-fluid w-100 rounded-top"--}}
{{--                                             alt="Image">--}}
{{--                                        <div class="product-new">New</div>--}}
{{--                                        <div class="product-details">--}}
{{--                                            <a href="#"><i class="fa fa-eye fa-1x"></i></a>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <div class="text-center rounded-bottom p-4">--}}
{{--                                        <a href="#" class="d-block mb-2">SmartPhone</a>--}}
{{--                                        <a href="#" class="d-block h4">Apple iPad Mini <br> G2356</a>--}}
{{--                                        <del class="me-2 fs-5">$1,250.00</del>--}}
{{--                                        <span class="text-primary fs-5">$1,050.00</span>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <div--}}
{{--                                    class="product-item-add border border-top-0 rounded-bottom  text-center p-4 pt-0">--}}
{{--                                    <a href="#"--}}
{{--                                       class="btn btn-primary border-secondary rounded-pill py-2 px-4 mb-4"><i--}}
{{--                                            class="fas fa-shopping-cart me-2"></i> Add To Cart</a>--}}
{{--                                    <div class="d-flex justify-content-between align-items-center">--}}
{{--                                        <div class="d-flex">--}}
{{--                                            <i class="fas fa-star text-primary"></i>--}}
{{--                                            <i class="fas fa-star text-primary"></i>--}}
{{--                                            <i class="fas fa-star text-primary"></i>--}}
{{--                                            <i class="fas fa-star text-primary"></i>--}}
{{--                                            <i class="fas fa-star"></i>--}}
{{--                                        </div>--}}
{{--                                        <div class="d-flex">--}}
{{--                                            <a href="#"--}}
{{--                                               class="text-primary d-flex align-items-center justify-content-center me-3"><span--}}
{{--                                                    class="rounded-circle btn-sm-square border"><i--}}
{{--                                                        class="fas fa-random"></i></i></a>--}}
{{--                                            <a href="#"--}}
{{--                                               class="text-primary d-flex align-items-center justify-content-center me-0"><span--}}
{{--                                                    class="rounded-circle btn-sm-square border"><i--}}
{{--                                                        class="fas fa-heart"></i></a>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="col-md-6 col-lg-4 col-xl-3">--}}
{{--                            <div class="product-item rounded wow fadeInUp" data-wow-delay="0.7s">--}}
{{--                                <div class="product-item-inner border rounded">--}}
{{--                                    <div class="product-item-inner-item">--}}
{{--                                        <img src="{{asset('assets/front/img/product-10.png')}}" class="img-fluid w-100 rounded-top" alt="">--}}
{{--                                        <div class="product-sale">Sale</div>--}}
{{--                                        <div class="product-details">--}}
{{--                                            <a href="#"><i class="fa fa-eye fa-1x"></i></a>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <div class="text-center rounded-bottom p-4">--}}
{{--                                        <a href="#" class="d-block mb-2">SmartPhone</a>--}}
{{--                                        <a href="#" class="d-block h4">Apple iPad Mini <br> G2356</a>--}}
{{--                                        <del class="me-2 fs-5">$1,250.00</del>--}}
{{--                                        <span class="text-primary fs-5">$1,050.00</span>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <div--}}
{{--                                    class="product-item-add border border-top-0 rounded-bottom  text-center p-4 pt-0">--}}
{{--                                    <a href="#"--}}
{{--                                       class="btn btn-primary border-secondary rounded-pill py-2 px-4 mb-4"><i--}}
{{--                                            class="fas fa-shopping-cart me-2"></i> Add To Cart</a>--}}
{{--                                    <div class="d-flex justify-content-between align-items-center">--}}
{{--                                        <div class="d-flex">--}}
{{--                                            <i class="fas fa-star text-primary"></i>--}}
{{--                                            <i class="fas fa-star text-primary"></i>--}}
{{--                                            <i class="fas fa-star text-primary"></i>--}}
{{--                                            <i class="fas fa-star text-primary"></i>--}}
{{--                                            <i class="fas fa-star"></i>--}}
{{--                                        </div>--}}
{{--                                        <div class="d-flex">--}}
{{--                                            <a href="#"--}}
{{--                                               class="text-primary d-flex align-items-center justify-content-center me-3"><span--}}
{{--                                                    class="rounded-circle btn-sm-square border"><i--}}
{{--                                                        class="fas fa-random"></i></i></a>--}}
{{--                                            <a href="#"--}}
{{--                                               class="text-primary d-flex align-items-center justify-content-center me-0"><span--}}
{{--                                                    class="rounded-circle btn-sm-square border"><i--}}
{{--                                                        class="fas fa-heart"></i></a>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}

                    </div>
                </div>
                <div id="tab-2" class="tab-pane fade show p-0">
                    <div class="row g-4"  id="newArrivalsContainer" >

                    </div>
                </div>

                <div id="tab-3" class="tab-pane fade show p-0">
                    <div class="row g-4">
                        <div class="col-md-6 col-lg-4 col-xl-3">
                            <div class="product-item rounded wow fadeInUp" data-wow-delay="0.1s">
                                <div class="product-item-inner border rounded">
                                    <div class="product-item-inner-item">
                                        <img src="{{asset('assets/front/img/product-9.png')}}" class="img-fluid w-100 rounded-top" alt="">
                                        <div class="product-details">
                                            <a href="#"><i class="fa fa-eye fa-1x"></i></a>
                                        </div>
                                    </div>
                                    <div class="text-center rounded-bottom p-4">
                                        <a href="#" class="d-block mb-2">SmartPhone</a>
                                        <a href="#" class="d-block h4">Apple iPad Mini <br> G2356</a>
                                        <del class="me-2 fs-5">$1,250.00</del>
                                        <span class="text-primary fs-5">$1,050.00</span>
                                    </div>
                                </div>
                                <div
                                    class="product-item-add border border-top-0 rounded-bottom  text-center p-4 pt-0">
                                    <a href="#"
                                       class="btn btn-primary border-secondary rounded-pill py-2 px-4 mb-4"><i
                                            class="fas fa-shopping-cart me-2"></i> Add To Cart</a>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="d-flex">
                                            <i class="fas fa-star text-primary"></i>
                                            <i class="fas fa-star text-primary"></i>
                                            <i class="fas fa-star text-primary"></i>
                                            <i class="fas fa-star text-primary"></i>
                                            <i class="fas fa-star"></i>
                                        </div>
                                        <div class="d-flex">
                                            <a href="#"
                                               class="text-primary d-flex align-items-center justify-content-center me-3"><span
                                                    class="rounded-circle btn-sm-square border"><i
                                                        class="fas fa-random"></i></i></a>
                                            <a href="#"
                                               class="text-primary d-flex align-items-center justify-content-center me-0"><span
                                                    class="rounded-circle btn-sm-square border"><i
                                                        class="fas fa-heart"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-4 col-xl-3">
                            <div class="product-item rounded wow fadeInUp" data-wow-delay="0.3s">
                                <div class="product-item-inner border rounded">
                                    <div class="product-item-inner-item">
                                        <img src="{{asset('assets/front/img/product-10.png')}}" class="img-fluid w-100 rounded-top"
                                             alt="Image">
                                        <div class="product-details">
                                            <a href="#"><i class="fa fa-eye fa-1x"></i></a>
                                        </div>
                                    </div>
                                    <div class="text-center rounded-bottom p-4">
                                        <a href="#" class="d-block mb-2">SmartPhone</a>
                                        <a href="#" class="d-block h4">Apple iPad Mini <br> G2356</a>
                                        <del class="me-2 fs-5">$1,250.00</del>
                                        <span class="text-primary fs-5">$1,050.00</span>
                                    </div>
                                </div>
                                <div
                                    class="product-item-add border border-top-0 rounded-bottom  text-center p-4 pt-0">
                                    <a href="#"
                                       class="btn btn-primary border-secondary rounded-pill py-2 px-4 mb-4"><i
                                            class="fas fa-shopping-cart me-2"></i> Add To Cart</a>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="d-flex">
                                            <i class="fas fa-star text-primary"></i>
                                            <i class="fas fa-star text-primary"></i>
                                            <i class="fas fa-star text-primary"></i>
                                            <i class="fas fa-star text-primary"></i>
                                            <i class="fas fa-star"></i>
                                        </div>
                                        <div class="d-flex">
                                            <a href="#"
                                               class="text-primary d-flex align-items-center justify-content-center me-3"><span
                                                    class="rounded-circle btn-sm-square border"><i
                                                        class="fas fa-random"></i></i></a>
                                            <a href="#"
                                               class="text-primary d-flex align-items-center justify-content-center me-0"><span
                                                    class="rounded-circle btn-sm-square border"><i
                                                        class="fas fa-heart"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-4 col-xl-3">
                            <div class="product-item rounded wow fadeInUp" data-wow-delay="0.5s">
                                <div class="product-item-inner border rounded">
                                    <div class="product-item-inner-item">
                                        <img src="{{asset('assets/front/img/product-11.png')}}" class="img-fluid w-100 rounded-top"
                                             alt="Image">
                                        <div class="product-details">
                                            <a href="#"><i class="fa fa-eye fa-1x"></i></a>
                                        </div>
                                    </div>
                                    <div class="text-center rounded-bottom p-4">
                                        <a href="#" class="d-block mb-2">SmartPhone</a>
                                        <a href="#" class="d-block h4">Apple iPad Mini <br> G2356</a>
                                        <del class="me-2 fs-5">$1,250.00</del>
                                        <span class="text-primary fs-5">$1,050.00</span>
                                    </div>
                                </div>
                                <div
                                    class="product-item-add border border-top-0 rounded-bottom  text-center p-4 pt-0">
                                    <a href="#"
                                       class="btn btn-primary border-secondary rounded-pill py-2 px-4 mb-4"><i
                                            class="fas fa-shopping-cart me-2"></i> Add To Cart</a>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="d-flex">
                                            <i class="fas fa-star text-primary"></i>
                                            <i class="fas fa-star text-primary"></i>
                                            <i class="fas fa-star text-primary"></i>
                                            <i class="fas fa-star text-primary"></i>
                                            <i class="fas fa-star"></i>
                                        </div>
                                        <div class="d-flex">
                                            <a href="#"
                                               class="text-primary d-flex align-items-center justify-content-center me-3"><span
                                                    class="rounded-circle btn-sm-square border"><i
                                                        class="fas fa-random"></i></i></a>
                                            <a href="#"
                                               class="text-primary d-flex align-items-center justify-content-center me-0"><span
                                                    class="rounded-circle btn-sm-square border"><i
                                                        class="fas fa-heart"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-4 col-xl-3">
                            <div class="product-item rounded wow fadeInUp" data-wow-delay="0.7s">
                                <div class="product-item-inner border rounded">
                                    <div class="product-item-inner-item">
                                        <img src="{{asset('assets/front/img/product-12.png')}}" class="img-fluid w-100 rounded-top"
                                             alt="Image">
                                        <div class="product-details">
                                            <a href="#"><i class="fa fa-eye fa-1x"></i></a>
                                        </div>
                                    </div>
                                    <div class="text-center rounded-bottom p-4">
                                        <a href="#" class="d-block mb-2">SmartPhone</a>
                                        <a href="#" class="d-block h4">Apple iPad Mini <br> G2356</a>
                                        <del class="me-2 fs-5">$1,250.00</del>
                                        <span class="text-primary fs-5">$1,050.00</span>
                                    </div>
                                </div>
                                <div
                                    class="product-item-add border border-top-0 rounded-bottom  text-center p-4 pt-0">
                                    <a href="#"
                                       class="btn btn-primary border-secondary rounded-pill py-2 px-4 mb-4"><i
                                            class="fas fa-shopping-cart me-2"></i> Add To Cart</a>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="d-flex">
                                            <i class="fas fa-star text-primary"></i>
                                            <i class="fas fa-star text-primary"></i>
                                            <i class="fas fa-star text-primary"></i>
                                            <i class="fas fa-star text-primary"></i>
                                            <i class="fas fa-star"></i>
                                        </div>
                                        <div class="d-flex">
                                            <a href="#"
                                               class="text-primary d-flex align-items-center justify-content-center me-3"><span
                                                    class="rounded-circle btn-sm-square border"><i
                                                        class="fas fa-random"></i></i></a>
                                            <a href="#"
                                               class="text-primary d-flex align-items-center justify-content-center me-0"><span
                                                    class="rounded-circle btn-sm-square border"><i
                                                        class="fas fa-heart"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="tab-4" class="tab-pane fade show p-0">
                    <div class="row g-4"  id="topSellingContainer">

{{--                        <div class="col-md-6 col-lg-4 col-xl-3">--}}
{{--                            <div class="product-item rounded wow fadeInUp" data-wow-delay="0.1s">--}}
{{--                                <div class="product-item-inner border rounded">--}}
{{--                                    <div class="product-item-inner-item">--}}
{{--                                        <img src="{{asset('assets/front/img/product-14.png')}}" class="img-fluid w-100 rounded-top"--}}
{{--                                             alt="Image">--}}
{{--                                        <div class="product-details">--}}
{{--                                            <a href="#"><i class="fa fa-eye fa-1x"></i></a>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <div class="text-center rounded-bottom p-4">--}}
{{--                                        <a href="#" class="d-block mb-2">SmartPhone</a>--}}
{{--                                        <a href="#" class="d-block h4">Apple iPad Mini <br> G2356</a>--}}
{{--                                        <del class="me-2 fs-5">$1,250.00</del>--}}
{{--                                        <span class="text-primary fs-5">$1,050.00</span>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <div--}}
{{--                                    class="product-item-add border border-top-0 rounded-bottom  text-center p-4 pt-0">--}}
{{--                                    <a href="#"--}}
{{--                                       class="btn btn-primary border-secondary rounded-pill py-2 px-4 mb-4"><i--}}
{{--                                            class="fas fa-shopping-cart me-2"></i> Add To Cart</a>--}}
{{--                                    <div class="d-flex justify-content-between align-items-center">--}}
{{--                                        <div class="d-flex">--}}
{{--                                            <i class="fas fa-star text-primary"></i>--}}
{{--                                            <i class="fas fa-star text-primary"></i>--}}
{{--                                            <i class="fas fa-star text-primary"></i>--}}
{{--                                            <i class="fas fa-star text-primary"></i>--}}
{{--                                            <i class="fas fa-star"></i>--}}
{{--                                        </div>--}}
{{--                                        <div class="d-flex">--}}
{{--                                            <a href="#"--}}
{{--                                               class="text-primary d-flex align-items-center justify-content-center me-3"><span--}}
{{--                                                    class="rounded-circle btn-sm-square border"><i--}}
{{--                                                        class="fas fa-random"></i></i></a>--}}
{{--                                            <a href="#"--}}
{{--                                               class="text-primary d-flex align-items-center justify-content-center me-0"><span--}}
{{--                                                    class="rounded-circle btn-sm-square border"><i--}}
{{--                                                        class="fas fa-heart"></i></a>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="col-md-6 col-lg-4 col-xl-3">--}}
{{--                            <div class="product-item rounded wow fadeInUp" data-wow-delay="0.3s">--}}
{{--                                <div class="product-item-inner border rounded">--}}
{{--                                    <div class="product-item-inner-item">--}}
{{--                                        <img src="{{asset('assets/front/img/product-15.png')}}" class="img-fluid w-100 rounded-top"--}}
{{--                                             alt="Image">--}}
{{--                                        <div class="product-details">--}}
{{--                                            <a href="#"><i class="fa fa-eye fa-1x"></i></a>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <div class="text-center rounded-bottom p-4">--}}
{{--                                        <a href="#" class="d-block mb-2">SmartPhone</a>--}}
{{--                                        <a href="#" class="d-block h4">Apple iPad Mini <br> G2356</a>--}}
{{--                                        <del class="me-2 fs-5">$1,250.00</del>--}}
{{--                                        <span class="text-primary fs-5">$1,050.00</span>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <div--}}
{{--                                    class="product-item-add border border-top-0 rounded-bottom  text-center p-4 pt-0">--}}
{{--                                    <a href="#"--}}
{{--                                       class="btn btn-primary border-secondary rounded-pill py-2 px-4 mb-4"><i--}}
{{--                                            class="fas fa-shopping-cart me-2"></i> Add To Cart</a>--}}
{{--                                    <div class="d-flex justify-content-between align-items-center">--}}
{{--                                        <div class="d-flex">--}}
{{--                                            <i class="fas fa-star text-primary"></i>--}}
{{--                                            <i class="fas fa-star text-primary"></i>--}}
{{--                                            <i class="fas fa-star text-primary"></i>--}}
{{--                                            <i class="fas fa-star text-primary"></i>--}}
{{--                                            <i class="fas fa-star"></i>--}}
{{--                                        </div>--}}
{{--                                        <div class="d-flex">--}}
{{--                                            <a href="#"--}}
{{--                                               class="text-primary d-flex align-items-center justify-content-center me-3"><span--}}
{{--                                                    class="rounded-circle btn-sm-square border"><i--}}
{{--                                                        class="fas fa-random"></i></i></a>--}}
{{--                                            <a href="#"--}}
{{--                                               class="text-primary d-flex align-items-center justify-content-center me-0"><span--}}
{{--                                                    class="rounded-circle btn-sm-square border"><i--}}
{{--                                                        class="fas fa-heart"></i></a>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="col-md-6 col-lg-4 col-xl-3">--}}
{{--                            <div class="product-item rounded wow fadeInUp" data-wow-delay="0.5s">--}}
{{--                                <div class="product-item-inner border rounded">--}}
{{--                                    <div class="product-item-inner-item">--}}
{{--                                        <img src="{{asset('assets/front/img/product-17.png')}}" class="img-fluid w-100 rounded-top"--}}
{{--                                             alt="Image">--}}
{{--                                        <div class="product-details">--}}
{{--                                            <a href="#"><i class="fa fa-eye fa-1x"></i></a>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <div class="text-center rounded-bottom p-4">--}}
{{--                                        <a href="#" class="d-block mb-2">SmartPhone</a>--}}
{{--                                        <a href="#" class="d-block h4">Apple iPad Mini <br> G2356</a>--}}
{{--                                        <del class="me-2 fs-5">$1,250.00</del>--}}
{{--                                        <span class="text-primary fs-5">$1,050.00</span>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <div--}}
{{--                                    class="product-item-add border border-top-0 rounded-bottom  text-center p-4 pt-0">--}}
{{--                                    <a href="#"--}}
{{--                                       class="btn btn-primary border-secondary rounded-pill py-2 px-4 mb-4"><i--}}
{{--                                            class="fas fa-shopping-cart me-2"></i> Add To Cart</a>--}}
{{--                                    <div class="d-flex justify-content-between align-items-center">--}}
{{--                                        <div class="d-flex">--}}
{{--                                            <i class="fas fa-star text-primary"></i>--}}
{{--                                            <i class="fas fa-star text-primary"></i>--}}
{{--                                            <i class="fas fa-star text-primary"></i>--}}
{{--                                            <i class="fas fa-star text-primary"></i>--}}
{{--                                            <i class="fas fa-star"></i>--}}
{{--                                        </div>--}}
{{--                                        <div class="d-flex">--}}
{{--                                            <a href="#"--}}
{{--                                               class="text-primary d-flex align-items-center justify-content-center me-3"><span--}}
{{--                                                    class="rounded-circle btn-sm-square border"><i--}}
{{--                                                        class="fas fa-random"></i></i></a>--}}
{{--                                            <a href="#"--}}
{{--                                               class="text-primary d-flex align-items-center justify-content-center me-0"><span--}}
{{--                                                    class="rounded-circle btn-sm-square border"><i--}}
{{--                                                        class="fas fa-heart"></i></a>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="col-md-6 col-lg-4 col-xl-3">--}}
{{--                            <div class="product-item rounded wow fadeInUp" data-wow-delay="0.7s">--}}
{{--                                <div class="product-item-inner border rounded">--}}
{{--                                    <div class="product-item-inner-item">--}}
{{--                                        <img src="{{asset('assets/front/img/product-16.png')}}" class="img-fluid w-100 rounded-top"--}}
{{--                                             alt="Image">--}}
{{--                                        <div class="product-details">--}}
{{--                                            <a href="#"><i class="fa fa-eye fa-1x"></i></a>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <div class="text-center rounded-bottom p-4">--}}
{{--                                        <a href="#" class="d-block mb-2">SmartPhone</a>--}}
{{--                                        <a href="#" class="d-block h4">Apple iPad Mini <br> G2356</a>--}}
{{--                                        <del class="me-2 fs-5">$1,250.00</del>--}}
{{--                                        <span class="text-primary fs-5">$1,050.00</span>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <div--}}
{{--                                    class="product-item-add border border-top-0 rounded-bottom  text-center p-4 pt-0">--}}
{{--                                    <a href="#"--}}
{{--                                       class="btn btn-primary border-secondary rounded-pill py-2 px-4 mb-4"><i--}}
{{--                                            class="fas fa-shopping-cart me-2"></i> Add To Cart</a>--}}
{{--                                    <div class="d-flex justify-content-between align-items-center">--}}
{{--                                        <div class="d-flex">--}}
{{--                                            <i class="fas fa-star text-primary"></i>--}}
{{--                                            <i class="fas fa-star text-primary"></i>--}}
{{--                                            <i class="fas fa-star text-primary"></i>--}}
{{--                                            <i class="fas fa-star text-primary"></i>--}}
{{--                                            <i class="fas fa-star"></i>--}}
{{--                                        </div>--}}
{{--                                        <div class="d-flex">--}}
{{--                                            <a href="#"--}}
{{--                                               class="text-primary d-flex align-items-center justify-content-center me-3"><span--}}
{{--                                                    class="rounded-circle btn-sm-square border"><i--}}
{{--                                                        class="fas fa-random"></i></i></a>--}}
{{--                                            <a href="#"--}}
{{--                                               class="text-primary d-flex align-items-center justify-content-center me-0"><span--}}
{{--                                                    class="rounded-circle btn-sm-square border"><i--}}
{{--                                                        class="fas fa-heart"></i></a>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Our Products End -->
