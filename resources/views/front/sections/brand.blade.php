<!-- Shop Page Start -->
<div class="container-fluid shop py-5">
    <div class="container py-5">
        <div class="row g-4">
            <div class="col-lg-3 mt-1 ps-0 wow fadeInUp" >
                <div class="product-categories rounded" style="background-color: rgba(0,0,0,0.075); height: 20.75rem; margin-bottom: 2.45rem;">
                    <h3 class="py-2 px-2 mt-1 mb-3">{{ __('front/labels.other_brands') }}</h3>
                    @isset($brands)
                        <div class="row m-0 px-2 py-1 justify-content-between">
                        @foreach($brands as $bra)
                            @if($bra['brand_id'] == $brand['brand_id'])
                                @continue
                            @endif

                                <div class=" col-md-6 px-1 py-1 m-0 mb-3 categories-item rounded bg-white" style="width: max-content">
                                    <a href="{{route('front.brand.show', $bra['slug'])}}" class="m-0 p-0 text-dark" style="font-size: 1.1rem;">
                                        <strong>
{{--                                                                                    <i class="fas fa-apple-alt text-secondary me-1"></i>--}}
                                            {{$bra['name']}}
                                        </strong>
                                    </a>
                                </div>

                        @endforeach
                        </div>
                    @endisset
                </div>


{{--                <div class="price mb-4">--}}
{{--                    <h4 class="mb-2">Price</h4>--}}
{{--                    <input type="range" class="form-range w-100" id="rangeInput" name="rangeInput" min="0" max="500"--}}
{{--                           value="0" oninput="amount.value=rangeInput.value">--}}
{{--                    <output id="amount" name="amount" min-velue="0" max-value="500" for="rangeInput">0</output>--}}
{{--                    <div class=""></div>--}}
{{--                </div>--}}
{{--                <div class="product-color mb-3">--}}
{{--                    <h4>Select By Color</h4>--}}
{{--                    <ul class="list-unstyled">--}}
{{--                        <li>--}}
{{--                            <div class="product-color-item">--}}
{{--                                <a href="#" class="text-dark"><i class="fas fa-apple-alt text-secondary me-2"></i>--}}
{{--                                    Gold</a>--}}
{{--                                <span>(1)</span>--}}
{{--                            </div>--}}
{{--                        </li>--}}
{{--                        <li>--}}
{{--                            <div class="product-color-item">--}}
{{--                                <a href="#" class="text-dark"><i class="fas fa-apple-alt text-secondary me-2"></i>--}}
{{--                                    Green</a>--}}
{{--                                <span>(1)</span>--}}
{{--                            </div>--}}
{{--                        </li>--}}
{{--                        <li>--}}
{{--                            <div class="product-color-item">--}}
{{--                                <a href="#" class="text-dark"><i class="fas fa-apple-alt text-secondary me-2"></i>--}}
{{--                                    White</a>--}}
{{--                                <span>(1)</span>--}}
{{--                            </div>--}}
{{--                        </li>--}}
{{--                    </ul>--}}
{{--                </div>--}}
{{--                <div class="additional-product mb-4">--}}
{{--                    <h4>Additional Products</h4>--}}
{{--                    <div class="additional-product-item">--}}
{{--                        <input type="radio" class="me-2" id="Categories-1" name="Categories-1" value="Beverages">--}}
{{--                        <label for="Categories-1" class="text-dark"> Accessories</label>--}}
{{--                    </div>--}}
{{--                    <div class="additional-product-item">--}}
{{--                        <input type="radio" class="me-2" id="Categories-2" name="Categories-1" value="Beverages">--}}
{{--                        <label for="Categories-2" class="text-dark"> Electronics & Computer</label>--}}
{{--                    </div>--}}
{{--                    <div class="additional-product-item">--}}
{{--                        <input type="radio" class="me-2" id="Categories-3" name="Categories-1" value="Beverages">--}}
{{--                        <label for="Categories-3" class="text-dark"> Laptops & Desktops</label>--}}
{{--                    </div>--}}
{{--                    <div class="additional-product-item">--}}
{{--                        <input type="radio" class="me-2" id="Categories-4" name="Categories-1" value="Beverages">--}}
{{--                        <label for="Categories-4" class="text-dark"> Mobiles & Tablets</label>--}}
{{--                    </div>--}}
{{--                    <div class="additional-product-item">--}}
{{--                        <input type="radio" class="me-2" id="Categories-5" name="Categories-1" value="Beverages">--}}
{{--                        <label for="Categories-5" class="text-dark"> SmartPhone & Smart TV</label>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="featured-product mb-4">--}}
{{--                    <h4 class="mb-3">Featured products</h4>--}}
{{--                    <div class="featured-product-item">--}}
{{--                        <div class="rounded me-4" style="width: 100px; height: 100px;">--}}
{{--                            <img src="{{asset('assets/front/img/product-3.png')}}" class="img-fluid rounded" alt="Image">--}}
{{--                        </div>--}}
{{--                        <div>--}}
{{--                            <h6 class="mb-2">SmartPhone</h6>--}}
{{--                            <div class="d-flex mb-2">--}}
{{--                                <i class="fa fa-star text-secondary"></i>--}}
{{--                                <i class="fa fa-star text-secondary"></i>--}}
{{--                                <i class="fa fa-star text-secondary"></i>--}}
{{--                                <i class="fa fa-star text-secondary"></i>--}}
{{--                                <i class="fa fa-star"></i>--}}
{{--                            </div>--}}
{{--                            <div class="d-flex mb-2">--}}
{{--                                <h5 class="fw-bold me-2">2.99 $</h5>--}}
{{--                                <h5 class="text-danger text-decoration-line-through">4.11 $</h5>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="featured-product-item">--}}
{{--                        <div class="rounded me-4" style="width: 100px; height: 100px;">--}}
{{--                            <img src="{{asset('assets/front/img/product-4.png')}}" class="img-fluid rounded" alt="Image">--}}
{{--                        </div>--}}
{{--                        <div>--}}
{{--                            <h6 class="mb-2">Smart Camera</h6>--}}
{{--                            <div class="d-flex mb-2">--}}
{{--                                <i class="fa fa-star text-secondary"></i>--}}
{{--                                <i class="fa fa-star text-secondary"></i>--}}
{{--                                <i class="fa fa-star text-secondary"></i>--}}
{{--                                <i class="fa fa-star text-secondary"></i>--}}
{{--                                <i class="fa fa-star"></i>--}}
{{--                            </div>--}}
{{--                            <div class="d-flex mb-2">--}}
{{--                                <h5 class="fw-bold me-2">2.99 $</h5>--}}
{{--                                <h5 class="text-danger text-decoration-line-through">4.11 $</h5>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="featured-product-item">--}}
{{--                        <div class="rounded me-4" style="width: 100px; height: 100px;">--}}
{{--                            <img src="{{asset('assets/front/img/product-5.png')}}" class="img-fluid rounded" alt="Image">--}}
{{--                        </div>--}}
{{--                        <div>--}}
{{--                            <h6 class="mb-2">Camera Leance</h6>--}}
{{--                            <div class="d-flex mb-2">--}}
{{--                                <i class="fa fa-star text-secondary"></i>--}}
{{--                                <i class="fa fa-star text-secondary"></i>--}}
{{--                                <i class="fa fa-star text-secondary"></i>--}}
{{--                                <i class="fa fa-star text-secondary"></i>--}}
{{--                                <i class="fa fa-star"></i>--}}
{{--                            </div>--}}
{{--                            <div class="d-flex mb-2">--}}
{{--                                <h5 class="fw-bold me-2">2.99 $</h5>--}}
{{--                                <h5 class="text-danger text-decoration-line-through">4.11 $</h5>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="d-flex justify-content-center my-4">--}}
{{--                        <a href="#" class="btn btn-primary px-4 py-3 rounded-pill w-100">Vew More</a>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <a href="#">--}}
{{--                    <div class="position-relative">--}}
{{--                        <img src="{{asset('assets/front/img/product-banner-2.jpg')}}" class="img-fluid w-100 rounded" alt="Image">--}}
{{--                        <div class="text-center position-absolute d-flex flex-column align-items-center justify-content-center rounded p-4"--}}
{{--                             style="width: 100%; height: 100%; top: 0; right: 0; background: rgba(242, 139, 0, 0.3);">--}}
{{--                            <h5 class="display-6 text-primary">SALE</h5>--}}
{{--                            <h4 class="text-secondary">Get UP To 50% Off</h4>--}}
{{--                            <a href="#" class="btn btn-primary rounded-pill px-4">Shop Now</a>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </a>--}}
{{--                <div class="product-tags py-4">--}}
{{--                    <h4 class="mb-3">PRODUCT TAGS</h4>--}}
{{--                    <div class="product-tags-items bg-light rounded p-3">--}}
{{--                        <a href="#" class="border rounded py-1 px-2 mb-2">New</a>--}}
{{--                        <a href="#" class="border rounded py-1 px-2 mb-2">brand</a>--}}
{{--                        <a href="#" class="border rounded py-1 px-2 mb-2">black</a>--}}
{{--                        <a href="#" class="border rounded py-1 px-2 mb-2">white</a>--}}
{{--                        <a href="#" class="border rounded py-1 px-2 mb-2">tablats</a>--}}
{{--                        <a href="#" class="border rounded py-1 px-2 mb-2">phone</a>--}}
{{--                        <a href="#" class="border rounded py-1 px-2 mb-2">camera</a>--}}
{{--                        <a href="#" class="border rounded py-1 px-2 mb-2">drone</a>--}}
{{--                        <a href="#" class="border rounded py-1 px-2 mb-2">talevision</a>--}}
{{--                        <a href="#" class="border rounded py-1 px-2 mb-2">slaes</a>--}}
{{--                    </div>--}}
{{--                </div>--}}


                <div class="row p-0 m-0 justify-content-center rounded " style="background-color: rgba(0,0,0,0.075); position: sticky; top: 6.6%;">

                    <h3 class="py-2 px-2 mt-1 mb-3">{{ __('front/labels.filters') }}</h3>

                    @if($attributes)
                        <div class="accordion p-2 ps-2 " id="accordionPanelsStayOpenExample" style="max-height: 63rem; overflow-y: auto; ">

                            <div class="accordion-item mb-2 price-range-filter">
                                <h1 class="accordion-header lh-lg" id="panelsStayOpen-headingOnePrice">
                                    <button class="accordion-button collapsed fs-5" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOnePrice" aria-expanded="false" aria-controls="panelsStayOpen-collapseOnePrice" style="font-weight: 900 !important; ">
                                        {{ __('front/labels.price') }}
                                    </button>
                                </h1>
                                <div id="panelsStayOpen-collapseOnePrice" class="accordion-collapse collapse " aria-labelledby="panelsStayOpen-headingOnePrice">
                                    <div class="accordion-body">
                                        <div class="row">
                                            <div class="col-12 align-items-center" id="price-container">
                                                <input type="number" id="price-min" class="form-control price-input text-dark" style="font-weight: 900;" placeholder="Min" min="{{$minPrice?? 0}}" value="{{$minPrice?? 0}}">
                                                <span style="font-weight: 900;">{{ __('front/labels.to') }}</span>
                                                <input type="number" id="price-max" class="form-control price-input text-dark" style="font-weight: 900;" placeholder="Max" max="{{$maxPrice?? 0}}" value="{{$maxPrice?? 0}}">
                                            </div>

                                            <div id="price-slider"></div>

                                            <div class="price-output mt-2">
                                                <strong><small>
                                                    <span class="me-3">{{ __('front/labels.min') }}: <span id="min-label" class="text-dark">{{$minPrice?? 0}} {{ __('front/labels.currency') }}</span></span>
                                                    <span>{{ __('front/labels.max') }}: <span id="max-label" class="text-dark">{{$maxPrice?? 0}} {{ __('front/labels.currency') }}</span></span>
                                                </small> </strong>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>

                        @foreach($attributes as $index => $attr)
                                <div class="accordion-item mb-2">
                                    <h1 class="accordion-header lh-lg" id="panelsStayOpen-headingOne{{$index}}">
                                        <button class="accordion-button collapsed fs-5" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne{{$index}}" aria-expanded="false" aria-controls="panelsStayOpen-collapseOne{{$index}}" style="font-weight: 900 !important; ">
                                            {{$attr['name']}}
                                        </button>
                                    </h1>
                                    <div id="panelsStayOpen-collapseOne{{$index}}" class="accordion-collapse collapse " aria-labelledby="panelsStayOpen-headingOne{{$index}}">
                                        <div class="accordion-body">
                                            <div class="row">
                                                @foreach($attr['values'] as $j => $value)
                                                    <div class="col-12 ">
                                                        <div class="form-check text-start my-2">
                                                            <input type="checkbox" class="attribute-filter attribute-checkbox form-check-input bg-primary " id="attr_val{{$j}}"
                                                                   name="{{$attr['name']}}" value="{{$value['attr_val_id']}}" data-url="{{ route('front.brand.filter', $brand['brand_id']) }}">
                                                            <strong><label class="form-check-label text-dark" for="attr_val{{$j}}">{{$value['value']}}  <small class="product-counter" data-val-id="{{$value['attr_val_id']}}"> ({{$value['count']}})</small></label></strong>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>



            </div>
            <div class="col-lg-9 mt-1 pt-1 pe-0 wow fadeInUp">
                <div class="rounded mb-4 position-relative">
                    <img src="{{asset('assets/front/img/product-banner-3.jpg')}}" class="img-fluid rounded w-100" style="height: 250px;"
                         alt="Image">
                    <div class="position-absolute rounded d-flex flex-column align-items-center justify-content-center text-center"
                         style="width: 100%; height: 250px; top: 0; left: 0; background: rgba(242, 139, 0, 0.3);">
                        <h4 class="display-5 text-primary">SALE</h4>
                        <h3 class="display-4 text-white mb-4">Get UP To 50% Off</h3>
                        <a href="#" class="btn btn-primary rounded-pill">Shop Now</a>
                    </div>
                </div>
                <div class="row g-4 mb-2">
                    <div class="col-xl-7">
                        <div class="input-group w-100 mx-auto d-flex">

                            <input type="search" class="form-control p-3" placeholder="keywords"
                                   aria-describedby="search-icon-1" id="search-field">

                            <input type="hidden" value="{{$brand['brand_id']}}" id="brand-id">

                            <a href="{{ route('front.search') }}" id="search-btn" class="input-group-text p-3" >
                                <i class="fa fa-search fa-lg"></i>
                            </a>

                        </div>
                    </div>
                    <div class="col-xl-3 text-end">
                        <div class="bg-light ps-3 py-3 rounded d-flex justify-content-between">
                            <label for="sort-products">{{ __('front/labels.sort_by') }}:</label>
{{--                            data-url="{{route('front.brand.sort', $brand['brand_id']) }}"--}}
                            <select id="sort-products" name="brand_products"
                                    class="border-0 form-select-sm bg-light me-3"  form="electronicsform">
                                <option value="default">{{ __('front/labels.default') }}</option>
                                <option value="popular">{{ __('front/labels.popular') }}</option>
                                <option value="new">{{ __('front/labels.newest') }}</option>
{{--                                <option value="rating">Average Rating</option>--}}
                                <option value="low">{{ __('front/labels.low_to_high') }}</option>
                                <option value="high">{{ __('front/labels.high_to_low') }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-4 col-xl-2">
                        <ul class="nav nav-pills d-inline-flex text-center py-2 px-2 rounded bg-light mb-4">
                            <li class="nav-item me-4">
                                <a class="bg-light d-block" data-bs-toggle="pill" href="#tab-5">
                                    <i class="fas fa-th fa-3x text-primary"></i>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="bg-light d-block" data-bs-toggle="pill" href="#tab-6">
                                    <i class="fas fa-bars fa-3x text-primary"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="tab-content">
                    <div id="tab-5" class="tab-pane fade show p-0 active">
                        <div class="row g-4 product" id="search-container">

                            @isset($products)
                                @foreach($products as $product)
                                        <div class="col-lg-4">
                                            <div class="product-item rounded wow fadeInUp position-relative" data-wow-delay="0.1s">
                                                <div class="product-item-inner border rounded">
                                                    <div class="product-item-inner-item">
                                                        <img src="{{ asset($product['image_url']) }}" class="img-fluid w-100 rounded-top" alt="">
                                                        @if($product['discount_amount'])
                                                            <div class="product-sale text-center">{{$product['discount_percentage']}} {{ __('front/labels.off') }}</div>
                                                        @endif
                                                        @if($product['new'])
                                                            <div class="product-new">{{ __('front/labels.New') }}</div>
                                                        @endif
{{--                                                        <div class="product-new">New</div>--}}
                                                        <div class="product-details">
                                                            {{-- This eye icon will still work because it has a higher z-index/stacking --}}
                                                            <a href="{{route('front.product.show', $product['slug'])}}" class="stretched-link"><i class="fa fa-eye fa-1x"></i></a>
                                                        </div>
                                                    </div>

                                                    <div class="text-center rounded-bottom p-4">
                                                        <a href="{{route('front.product.show', $product['slug'])}}" class="d-block h4 ">
                                                            {{ $product['name'] }}
                                                        </a>
{{--                                                        <a href="{{route('front.product.show', $product->translation->slug)}}" class="d-block h4 stretched-link">--}}
{{--                                                            {{ $product->translation->name }}--}}
{{--                                                        </a>--}}
                                                        @if($product['discount_amount'])
                                                            <del class="me-2 fs-5">{{$product['price'] .  __('front/labels.currency') }}</del>
                                                        @endif
                                                        <span class="text-primary fs-5">{{ $product['final_price'] . __('front/labels.currency') }}</span>
                                                    </div>
                                                </div>

                                                <div class="product-item-add border border-top-0 rounded-bottom text-center p-4 pt-0">
                                                    {{-- 3. IMPORTANT: Any button inside must have 'position: relative' and 'z-index'
                                                         to stay clickable over the stretched link --}}
                                                    <a href="#" class="btn btn-primary border-secondary rounded-pill py-2 px-4 mb-4 position-relative z-1 js-add-to-cart" data-product-id="{{ $product['product_id']}}"  data-url="{{ route('front.cart.add', $product['product_id']) }}">
                                                        <i class="fas fa-shopping-cart me-2"></i> {{ __('front/labels.add_to_cart') }}
                                                    </a>

                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <div class="d-flex">
                                                            <i class="fas fa-star text-primary"></i>
                                                            <i class="fas fa-star text-primary"></i>
                                                            <i class="fas fa-star text-primary"></i>
                                                            <i class="fas fa-star text-primary"></i>
                                                            <i class="fas fa-star"></i>
                                                        </div>
                                                        <div class="d-flex position-relative z-1">
                                                            <a href="#" class="text-primary d-flex align-items-center justify-content-center me-3">
                                                                <span class="rounded-circle btn-sm-square border"><i class="fas fa-random"></i></span>
                                                            </a>
                                                            <a href="#" class="text-primary d-flex align-items-center justify-content-center me-0">
                                                                <span class="rounded-circle btn-sm-square border"><i class="fas fa-heart"></i></span>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                @endforeach
                            @endisset


                            <div class="col-lg-4">
                                <div class="product-item rounded wow fadeInUp" data-wow-delay="0.3s">
                                    <div class="product-item-inner border rounded">
                                        <div class="product-item-inner-item">
                                            <img src="{{asset('assets/front/img/product-4.png')}}" class="img-fluid w-100 rounded-top" alt="">
                                            <div class="product-new">New</div>
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
                            <div class="col-lg-4">
                                <div class="product-item rounded wow fadeInUp" data-wow-delay="0.5s">
                                    <div class="product-item-inner border rounded">
                                        <div class="product-item-inner-item">
                                            <img src="{{asset('assets/front/img/product-5.png')}}" class="img-fluid w-100 rounded-top" alt="">
                                            <div class="product-new">New</div>
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
                            <div class="col-lg-4">
                                <div class="product-item rounded wow fadeInUp" data-wow-delay="0.1s">
                                    <div class="product-item-inner border rounded">
                                        <div class="product-item-inner-item">
                                            <img src="{{asset('assets/front/img/product-6.png')}}" class="img-fluid w-100 rounded-top" alt="">
                                            <div class="product-new">New</div>
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
                            <div class="col-lg-4">
                                <div class="product-item rounded wow fadeInUp" data-wow-delay="0.3s">
                                    <div class="product-item-inner border rounded">
                                        <div class="product-item-inner-item">
                                            <img src="{{asset('assets/front/img/product-7.png')}}" class="img-fluid w-100 rounded-top" alt="">
                                            <div class="product-new">New</div>
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
                            <div class="col-lg-4">
                                <div class="product-item rounded wow fadeInUp" data-wow-delay="0.5s">
                                    <div class="product-item-inner border rounded">
                                        <div class="product-item-inner-item">
                                            <img src="{{asset('assets/front/img/product-8.png')}}" class="img-fluid w-100 rounded-top" alt="">
                                            <div class="product-new">New</div>
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
                            <div class="col-lg-4">
                                <div class="product-item rounded wow fadeInUp" data-wow-delay="0.1s">
                                    <div class="product-item-inner border rounded">
                                        <div class="product-item-inner-item">
                                            <img src="{{asset('assets/front/img/product-9.png')}}" class="img-fluid w-100 rounded-top" alt="">
                                            <div class="product-new">New</div>
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
                            <div class="col-lg-4">
                                <div class="product-item rounded wow fadeInUp" data-wow-delay="0.3s">
                                    <div class="product-item-inner border rounded">
                                        <div class="product-item-inner-item">
                                            <img src="{{asset('assets/front/img/product-10.png')}}" class="img-fluid w-100 rounded-top"
                                                 alt="">
                                            <div class="product-new">New</div>
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
                            <div class="col-lg-4">
                                <div class="product-item rounded wow fadeInUp" data-wow-delay="0.5s">
                                    <div class="product-item-inner border rounded">
                                        <div class="product-item-inner-item">
                                            <img src="{{asset('assets/front/img/product-11.png')}}" class="img-fluid w-100 rounded-top"
                                                 alt="">
                                            <div class="product-new">New</div>
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
                    <div id="tab-6" class="product tab-pane fade show p-0">
                        <div class="row products-mini">

                            @foreach($products as $product)

                                <div class="col-md-12 mb-4">
                                    {{-------------------------------------------------------------------------------}}
                                    <div class="product-item rounded wow fadeInUp product-data-container" data-wow-delay="0.1s">
                                        <div class="row m-0 p-0 product-item-inner border rounded">

                                            <div class="col-5 row m-0 p-0 product-item-inner-item">
                                                <img src="{{$product['image_url']}}" class="img-fluid w-100 p-0 rounded-start" alt="" >
                                                @if($product['discount_amount'])
                                                    <div class="product-sale text-center">{{$product['discount_percentage'] . __('front/labels.off')}}</div>
                                                @endif
                                                @if($product['new'])
                                                    <div class="product-new">{{ __('front/labels.'.$product['new']) }}</div>
                                                @endif
                                                <div class="product-details p-0">
                                                    <a href="{{route('front.product.show', $product['slug'])}}" class="stretched-link"><i class="fa fa-eye fa-1x"></i></a>
                                                </div>
                                            </div>

                                            <div class="col-7 row m-0 p-0 rounded-bottom  ">
                                                <div class="row m-0 mt-1 p-0 justify-content-between">
                                                    <a href="{{route('front.category.show', $product['category_slug'])}}" class="col-md-7 small">{{ $product['category']}}</a>
                                                    <a href="#" class="col-md-4 small text-end" >{{ $product['brand']}}</a>
                                                </div>

                                                <div class="row m-0 mt-1 p-0 ">
                                                    <a href="{{route('front.product.show', $product['slug'])}}" class="col-md-12 h5">{{ $product['name']}}</a>
                                                </div>

                                                <div class="row m-0 mt-1 p-0 justify-content-start">
                                                    <strong class="col-md-5 pe-1 text-primary ">{{ $product['final_price'] .' '. __('front/labels.currency') }}</strong>
                                                    @if($product['discount_amount'])
                                                        <del class="col-md-4 p-0 small">{{$product['price'] .' '. __('front/labels.currency') }}</del>
                                                    @endif
                                                </div>

                                                <div class="row  mt-2 mb-2 ms-0 align-items-center">
                                                    @if(count($product['colors']) > 0)
                                                        <p class="col-md-3 p-0 m-0">{{__('front/labels.colors')}}: </p>
                                                        <div class="col-md-9 row color-container">
                                                            @foreach($product['colors'] as $color )
                                                                <div class="rounded-circle color_btn col-md-2 me-2 " style="background-color:{{$color['name']}}; width: 20px; height: 20px" data-colorId="{{$color['id']}}"></div>
                                                            @endforeach()
                                                        </div>
                                                    @endif
                                                </div>

                                                <div class="row col-md-12 mt-2 mb-2 ms-0 align-items-center">
                                                    <small class="p-0">{{__('front/labels.available')}}: <strong class="{{ $product['quantity'] < 5 ? 'text-danger':'text-success' }}">{{$product['quantity'] }}  {{__('front/labels.items_in_stock')}}</strong></small>
                                                </div>

                                                <div class="row col-12 m-0 p-0  rounded-bottom text-center">
                                                    <a href="#" class="btn btn-primary border-secondary rounded-pill py-2 px-4 mb-3 js-add-to-cart" data-url="{{ route('front.cart.add', $product['product_id']) }}" data-colorId="{{$product['colors'][0]['id']?? null}}">
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


                                    </div>
                                </div>
                            @endforeach



{{--                            @isset($products)--}}
{{--                                @foreach($products as $product)--}}
{{--                                    <div class="col-12 mb-5">--}}
{{--                                        <div class="card mb-3 ">--}}
{{--                                            <div class="row product-item g-0 m-0 p-0 product-data-container">--}}
{{--                                                <div class="col-md-5 row m-0 p-0 ">--}}

{{--                                                    <div class="row col-12 m-0 p-0 position-relative">--}}
{{--                                                        <img src="{{$product['image_url']}}" class="col-12 p-0 m-0 img-fluid w-100 rounded-start" alt="" >--}}
{{--                                                        @if($product['discount_amount'])--}}
{{--                                                            <div class="product-sale text-center position-absolute bg-secondary rounded-circle" style="top:3%; left:2%; width: 13%; height: 13%; z-index:9;">{{$product['discount_percentage'] . __('front/labels.off')}}</div>--}}
{{--                                                        @endif--}}
{{--                                                        @if($product['new'])--}}
{{--                                                            <div class="product-new position-absolute bg-primary d-flex align-items-center justify-content-center rounded-circle" style="top:3%; right:2%;  width: 13%; height: 13%; z-index:9;">{{ __('front/labels.'.$product['new']) }}</div>--}}
{{--                                                        @endif--}}
{{--                                                        <div class="product-details p-0 position-absolute" style="top:0; z-index:8; width: 100%; height:100%;">--}}
{{--                                                            <a href="{{route('front.product.show', $product['slug'])}}" class="stretched-link"></a>--}}
{{--                                                        </div>--}}
{{--                                                    </div>--}}

{{--                                                </div>--}}
{{--                                                <div class="col-md-7">--}}
{{--                                                    <div class="card-body">--}}
{{--                                                        <div class="row m-0  rounded-bottom p-0 ">--}}

{{--                                                            <div class="row m-0 p-0 justify-content-between ">--}}
{{--                                                                <a href="{{route('front.category.show', $product['category_slug'])}}" class="col-auto">{{ $product['category']}}</a>--}}
{{--                                                                <a href="#" class="col-auto text-end" >{{ $product['brand']}}</a>--}}
{{--                                                            </div>--}}

{{--                                                            <div class="row m-0 mt-1 p-0 ">--}}
{{--                                                                <a href="{{route('front.product.show', $product['slug'])}}" class="col-md-12 fw-bold fs-4">{{ $product['name']}}</a>--}}
{{--                                                            </div>--}}

{{--                                                            <div class="row m-0 mt-1 p-0 justify-content-start bg-danger border">--}}
{{--                                                                <strong class="col-md-5 pe-1 text-primary ">{{ $product['final_price'] .' '. __('front/labels.currency') }}</strong>--}}
{{--                                                                @if($product['discount_amount'])--}}
{{--                                                                    <del class="col-md-4 p-0 small">{{$product['price'] .' '. __('front/labels.currency') }}</del>--}}
{{--                                                                @endif--}}
{{--                                                            </div>--}}

{{--                                                            <div class="row  mt-2 mb-2 ms-0 align-items-center">--}}
{{--                                                                @if(count($product['colors']) > 0)--}}
{{--                                                                    <p class="col-md-3 p-0 m-0">{{__('front/labels.colors')}}: </p>--}}
{{--                                                                    <div class="col-md-9 row color-container">--}}
{{--                                                                        @foreach($product['colors'] as $color )--}}
{{--                                                                            <div class="rounded-circle color_btn col-md-2 me-2 " style="background-color:{{$color['name']}}; width: 20px; height: 20px" data-colorId="{{$color['id']}}"></div>--}}
{{--                                                                        @endforeach()--}}
{{--                                                                    </div>--}}
{{--                                                                @endif--}}
{{--                                                            </div>--}}

{{--                                                            <div class="row col-md-12 mt-2 mb-2 ms-0 align-items-center">--}}
{{--                                                                <small class="p-0">{{__('front/labels.available')}}: <strong class="{{ $product['quantity'] < 5 ? 'text-danger':'text-success' }}">{{$product['quantity'] }}  {{__('front/labels.items_in_stock')}}</strong></small>--}}
{{--                                                            </div>--}}

{{--                                                        </div>--}}
{{--                                                    </div>--}}

{{--                                                    <div--}}
{{--                                                        class="product-item-add border border-top-0 rounded-bottom text-center p-4 pt-0">--}}
{{--                                                        <a href="#" class="btn btn-primary border-secondary rounded-pill py-2 px-4 mb-3  js-add-to-cart" data-url="{{ route('front.cart.add', $product['product_id']) }}" data-colorId="{{$product['colors'][0]['id']?? null}}">--}}
{{--                                                            <i class="fas fa-shopping-cart me-2"></i> {{__('front/labels.add_to_cart')}}--}}
{{--                                                        </a>--}}
{{--                                                        <div class="d-flex justify-content-between align-items-center">--}}
{{--                                                            <div class="d-flex">--}}
{{--                                                                <i class="fas fa-star text-primary"></i>--}}
{{--                                                                <i class="fas fa-star text-primary"></i>--}}
{{--                                                                <i class="fas fa-star text-primary"></i>--}}
{{--                                                                <i class="fas fa-star text-primary"></i>--}}
{{--                                                                <i class="fas fa-star"></i>--}}
{{--                                                            </div>--}}
{{--                                                            <div class="d-flex">--}}
{{--                                                                <a href="#"--}}
{{--                                                                   class="text-primary d-flex align-items-center justify-content-center me-3"><span--}}
{{--                                                                        class="rounded-circle btn-sm-square border"><i--}}
{{--                                                                            class="fas fa-random"></i></i></a>--}}
{{--                                                                <a href="#"--}}
{{--                                                                   class="text-primary d-flex align-items-center justify-content-center me-0"><span--}}
{{--                                                                        class="rounded-circle btn-sm-square border"><i--}}
{{--                                                                            class="fas fa-heart"></i></a>--}}
{{--                                                            </div>--}}
{{--                                                        </div>--}}
{{--                                                    </div>--}}

{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{----------------------------------------------------------------------------------------------------------}}

{{--                                    </div>--}}
{{--                                @endforeach--}}
{{--                            @endisset--}}

                            <div class="col-lg-6">
                                <div class="products-mini-item border">
                                    <div class="row g-0">
                                        <div class="col-5">
                                            <div class="products-mini-img border-end h-100">
                                                <img src="{{asset('assets/front/img/product-3.png')}}" class="img-fluid w-100 h-100"
                                                     alt="Image">
                                                <div class="products-mini-icon rounded-circle bg-primary">
                                                    <a href="#"><i class="fa fa-eye fa-1x text-white"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-7">
                                            <div class="products-mini-content p-3">
                                                <a href="#" class="d-block mb-2">SmartPhone</a>
                                                <a href="#" class="d-block h4">Apple iPad Mini <br> G2356</a>
                                                <del class="me-2 fs-5">$1,250.00</del>
                                                <span class="text-primary fs-5">$1,050.00</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="products-mini-add border p-3">
                                        <a href="#"
                                           class="btn btn-primary border-secondary rounded-pill py-2 px-4"><i
                                                class="fas fa-shopping-cart me-2"></i> Add To Cart</a>
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
                            <div class="col-lg-6">
                                <div class="products-mini-item border">
                                    <div class="row g-0">
                                        <div class="col-5">
                                            <div class="products-mini-img border-end h-100">
                                                <img src="{{asset('assets/front/img/product-4.png')}}" class="img-fluid w-100 h-100"
                                                     alt="Image">
                                                <div class="products-mini-icon rounded-circle bg-primary">
                                                    <a href="#"><i class="fa fa-eye fa-1x text-white"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-7">
                                            <div class="products-mini-content p-3">
                                                <a href="#" class="d-block mb-2">SmartPhone</a>
                                                <a href="#" class="d-block h4">Apple iPad Mini <br> G2356</a>
                                                <del class="me-2 fs-5">$1,250.00</del>
                                                <span class="text-primary fs-5">$1,050.00</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="products-mini-add border p-3">
                                        <a href="#"
                                           class="btn btn-primary border-secondary rounded-pill py-2 px-4"><i
                                                class="fas fa-shopping-cart me-2"></i> Add To Cart</a>
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
                            <div class="col-lg-6">
                                <div class="products-mini-item border">
                                    <div class="row g-0">
                                        <div class="col-5">
                                            <div class="products-mini-img border-end h-100">
                                                <img src="{{asset('assets/front/img/product-5.png')}}" class="img-fluid w-100 h-100"
                                                     alt="Image">
                                                <div class="products-mini-icon rounded-circle bg-primary">
                                                    <a href="#"><i class="fa fa-eye fa-1x text-white"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-7">
                                            <div class="products-mini-content p-3">
                                                <a href="#" class="d-block mb-2">SmartPhone</a>
                                                <a href="#" class="d-block h4">Apple iPad Mini <br> G2356</a>
                                                <del class="me-2 fs-5">$1,250.00</del>
                                                <span class="text-primary fs-5">$1,050.00</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="products-mini-add border p-3">
                                        <a href="#"
                                           class="btn btn-primary border-secondary rounded-pill py-2 px-4"><i
                                                class="fas fa-shopping-cart me-2"></i> Add To Cart</a>
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
                            <div class="col-lg-6">
                                <div class="products-mini-item border">
                                    <div class="row g-0">
                                        <div class="col-5">
                                            <div class="products-mini-img border-end h-100">
                                                <img src="{{asset('assets/front/img/product-6.png')}}" class="img-fluid w-100 h-100"
                                                     alt="Image">
                                                <div class="products-mini-icon rounded-circle bg-primary">
                                                    <a href="#"><i class="fa fa-eye fa-1x text-white"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-7">
                                            <div class="products-mini-content p-3">
                                                <a href="#" class="d-block mb-2">SmartPhone</a>
                                                <a href="#" class="d-block h4">Apple iPad Mini <br> G2356</a>
                                                <del class="me-2 fs-5">$1,250.00</del>
                                                <span class="text-primary fs-5">$1,050.00</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="products-mini-add border p-3">
                                        <a href="#"
                                           class="btn btn-primary border-secondary rounded-pill py-2 px-4"><i
                                                class="fas fa-shopping-cart me-2"></i> Add To Cart</a>
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
                            <div class="col-lg-6">
                                <div class="products-mini-item border">
                                    <div class="row g-0">
                                        <div class="col-5">
                                            <div class="products-mini-img border-end h-100">
                                                <img src="{{asset('assets/front/img/product-7.png')}}" class="img-fluid w-100 h-100"
                                                     alt="Image">
                                                <div class="products-mini-icon rounded-circle bg-primary">
                                                    <a href="#"><i class="fa fa-eye fa-1x text-white"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-7">
                                            <div class="products-mini-content p-3">
                                                <a href="#" class="d-block mb-2">SmartPhone</a>
                                                <a href="#" class="d-block h4">Apple iPad Mini <br> G2356</a>
                                                <del class="me-2 fs-5">$1,250.00</del>
                                                <span class="text-primary fs-5">$1,050.00</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="products-mini-add border p-3">
                                        <a href="#"
                                           class="btn btn-primary border-secondary rounded-pill py-2 px-4"><i
                                                class="fas fa-shopping-cart me-2"></i> Add To Cart</a>
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
                            <div class="col-lg-6">
                                <div class="products-mini-item border">
                                    <div class="row g-0">
                                        <div class="col-5">
                                            <div class="products-mini-img border-end h-100">
                                                <img src="{{asset('assets/front/img/product-8.png')}}" class="img-fluid w-100 h-100"
                                                     alt="Image">
                                                <div class="products-mini-icon rounded-circle bg-primary">
                                                    <a href="#"><i class="fa fa-eye fa-1x text-white"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-7">
                                            <div class="products-mini-content p-3">
                                                <a href="#" class="d-block mb-2">SmartPhone</a>
                                                <a href="#" class="d-block h4">Apple iPad Mini <br> G2356</a>
                                                <del class="me-2 fs-5">$1,250.00</del>
                                                <span class="text-primary fs-5">$1,050.00</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="products-mini-add border p-3">
                                        <a href="#"
                                           class="btn btn-primary border-secondary rounded-pill py-2 px-4"><i
                                                class="fas fa-shopping-cart me-2"></i> Add To Cart</a>
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
                            <div class="col-lg-6">
                                <div class="products-mini-item border">
                                    <div class="row g-0">
                                        <div class="col-5">
                                            <div class="products-mini-img border-end h-100">
                                                <img src="{{asset('assets/front/img/product-9.png')}}" class="img-fluid w-100 h-100"
                                                     alt="Image">
                                                <div class="products-mini-icon rounded-circle bg-primary">
                                                    <a href="#"><i class="fa fa-eye fa-1x text-white"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-7">
                                            <div class="products-mini-content p-3">
                                                <a href="#" class="d-block mb-2">SmartPhone</a>
                                                <a href="#" class="d-block h4">Apple iPad Mini <br> G2356</a>
                                                <del class="me-2 fs-5">$1,250.00</del>
                                                <span class="text-primary fs-5">$1,050.00</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="products-mini-add border p-3">
                                        <a href="#"
                                           class="btn btn-primary border-secondary rounded-pill py-2 px-4"><i
                                                class="fas fa-shopping-cart me-2"></i> Add To Cart</a>
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
                            <div class="col-lg-6">
                                <div class="products-mini-item border">
                                    <div class="row g-0">
                                        <div class="col-5">
                                            <div class="products-mini-img border-end h-100">
                                                <img src="{{asset('assets/front/img/product-12.png')}}" class="img-fluid w-100 h-100"
                                                     alt="Image">
                                                <div class="products-mini-icon rounded-circle bg-primary">
                                                    <a href="#"><i class="fa fa-eye fa-1x text-white"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-7">
                                            <div class="products-mini-content p-3">
                                                <a href="#" class="d-block mb-2">SmartPhone</a>
                                                <a href="#" class="d-block h4">Apple iPad Mini <br> G2356</a>
                                                <del class="me-2 fs-5">$1,250.00</del>
                                                <span class="text-primary fs-5">$1,050.00</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="products-mini-add border p-3">
                                        <a href="#"
                                           class="btn btn-primary border-secondary rounded-pill py-2 px-4"><i
                                                class="fas fa-shopping-cart me-2"></i> Add To Cart</a>
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
                            <div class="col-lg-6">
                                <div class="products-mini-item border">
                                    <div class="row g-0">
                                        <div class="col-5">
                                            <div class="products-mini-img border-end h-100">
                                                <img src="{{asset('assets/front/img/product-13.png')}}" class="img-fluid w-100 h-100"
                                                     alt="Image">
                                                <div class="products-mini-icon rounded-circle bg-primary">
                                                    <a href="#"><i class="fa fa-eye fa-1x text-white"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-7">
                                            <div class="products-mini-content p-3">
                                                <a href="#" class="d-block mb-2">SmartPhone</a>
                                                <a href="#" class="d-block h4">Apple iPad Mini <br> G2356</a>
                                                <del class="me-2 fs-5">$1,250.00</del>
                                                <span class="text-primary fs-5">$1,050.00</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="products-mini-add border p-3">
                                        <a href="#"
                                           class="btn btn-primary border-secondary rounded-pill py-2 px-4"><i
                                                class="fas fa-shopping-cart me-2"></i> Add To Cart</a>
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
                            <div class="col-lg-6">
                                <div class="products-mini-item border">
                                    <div class="row g-0">
                                        <div class="col-5">
                                            <div class="products-mini-img border-end h-100">
                                                <img src="{{asset('assets/front/img/product-14.png')}}" class="img-fluid w-100 h-100"
                                                     alt="Image">
                                                <div class="products-mini-icon rounded-circle bg-primary">
                                                    <a href="#"><i class="fa fa-eye fa-1x text-white"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-7">
                                            <div class="products-mini-content p-3">
                                                <a href="#" class="d-block mb-2">SmartPhone</a>
                                                <a href="#" class="d-block h4">Apple iPad Mini <br> G2356</a>
                                                <del class="me-2 fs-5">$1,250.00</del>
                                                <span class="text-primary fs-5">$1,050.00</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="products-mini-add border p-3">
                                        <a href="#"
                                           class="btn btn-primary border-secondary rounded-pill py-2 px-4"><i
                                                class="fas fa-shopping-cart me-2"></i> Add To Cart</a>
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
                            <div class="col-lg-6">
                                <div class="products-mini-item border">
                                    <div class="row g-0">
                                        <div class="col-5">
                                            <div class="products-mini-img border-end h-100">
                                                <img src="{{asset('assets/front/img/product-15.png')}}" class="img-fluid w-100 h-100"
                                                     alt="Image">
                                                <div class="products-mini-icon rounded-circle bg-primary">
                                                    <a href="#"><i class="fa fa-eye fa-1x text-white"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-7">
                                            <div class="products-mini-content p-3">
                                                <a href="#" class="d-block mb-2">SmartPhone</a>
                                                <a href="#" class="d-block h4">Apple iPad Mini <br> G2356</a>
                                                <del class="me-2 fs-5">$1,250.00</del>
                                                <span class="text-primary fs-5">$1,050.00</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="products-mini-add border p-3">
                                        <a href="#"
                                           class="btn btn-primary border-secondary rounded-pill py-2 px-4"><i
                                                class="fas fa-shopping-cart me-2"></i> Add To Cart</a>
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
                            <div class="col-lg-6">
                                <div class="products-mini-item border">
                                    <div class="row g-0">
                                        <div class="col-5">
                                            <div class="products-mini-img border-end h-100">
                                                <img src="{{asset('assets/front/img/product-16.png')}}" class="img-fluid w-100 h-100"
                                                     alt="Image">
                                                <div class="products-mini-icon rounded-circle bg-primary">
                                                    <a href="#"><i class="fa fa-eye fa-1x text-white"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-7">
                                            <div class="products-mini-content p-3">
                                                <a href="#" class="d-block mb-2">SmartPhone</a>
                                                <a href="#" class="d-block h4">Apple iPad Mini <br> G2356</a>
                                                <del class="me-2 fs-5">$1,250.00</del>
                                                <span class="text-primary fs-5">$1,050.00</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="products-mini-add border p-3">
                                        <a href="#"
                                           class="btn btn-primary border-secondary rounded-pill py-2 px-4"><i
                                                class="fas fa-shopping-cart me-2"></i> Add To Cart</a>
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
                            <div class="col-12 wow fadeInUp" data-wow-delay="0.1s">
                                <div class="pagination d-flex justify-content-center mt-5">
                                    <a href="#" class="rounded">&laquo;</a>
                                    <a href="#" class="active rounded">1</a>
                                    <a href="#" class="rounded">2</a>
                                    <a href="#" class="rounded">3</a>
                                    <a href="#" class="rounded">4</a>
                                    <a href="#" class="rounded">5</a>
                                    <a href="#" class="rounded">6</a>
                                    <a href="#" class="rounded">&raquo;</a>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 wow fadeInUp" data-wow-delay="0.1s">
                <div class="pagination d-flex justify-content-center mt-5">

                    {{-- I used  $rawProducts  instead of  $products  due to pagination problem --}}
                    {{ $rawProducts->links() }}
                    {{--                                    <a href="#" class="rounded">&laquo;</a>--}}
                    {{--                                    <a href="#" class="active rounded">1</a>--}}
                    {{--                                    <a href="#" class="rounded">2</a>--}}
                    {{--                                    <a href="#" class="rounded">3</a>--}}
                    {{--                                    <a href="#" class="rounded">4</a>--}}
                    {{--                                    <a href="#" class="rounded">5</a>--}}
                    {{--                                    <a href="#" class="rounded">6</a>--}}
                    {{--                                    <a href="#" class="rounded">&raquo;</a>--}}
                </div>
            </div>

        </div>
    </div>
</div>
<!-- Shop Page End -->
