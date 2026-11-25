<!-- Cart Page Start -->
<div class="container-fluid py-5">
    @if($cartProducts)
    <div class="container py-5">
        <div class="table-responsive">
            <table class="table">
                <thead>
                <tr class="fs-5">
                    <th scope="col">{{ __('front/labels.item') }}</th>
{{--                    <th scope="col">Model</th>--}}
                    <th scope="col">{{ __('front/labels.price') }}</th>
                    <th scope="col">{{ __('front/labels.quantity') }}</th>
                    <th scope="col">{{ __('front/labels.product_total') }}</th>
                    <th scope="col">{{ __('front/labels.delete') }}</th>
                </tr>
                </thead>
                <tbody>

                    @guest('customers')
                        @foreach($cartProducts as $product)
                            <tr>
                                <th scope="row" class="row m-0 pb-1 justify-content-between">
                                    <div class="col-md-2 p-0"> <img src="{{$product['image_url']}}" alt="{{$product['product_name']}}" width="100" height="100"> </div>
                                    <p class="col-md-9 mb-0 ps-1">{{$product['product_name']}}</p>
                                    <div class="col-md-12 row mt-2 justify-content-between">
                                        <div class="col-md-6"><small>{{ __('front/labels.color') }}</small></div>
                                        <div class="col-md-1 rounded color-id" style="background-color: {{$product['color_name']}};" data-color="{{$product['color_id']}}"></div>
                                    </div>
                                </th>

                                <td>
                                    <p class="mb-0 py-4">{{$product['final_price']}}</p>
                                </td>
                                <td>
                                    <div class="input-group py-4 cart-btn-container" style="width: 100px;">
                                        <div class="input-group-btn">
                                            <button class="btn btn-sm rounded-circle bg-light border decrease-items" data-url="{{ route('front.cart.decrease', $product['product_id']) }}">
                                                <i class="fa fa-minus"></i>
                                            </button>
                                        </div>
                                        <input type="text" class="form-control form-control-sm text-center border-0 items-quantity"
                                               value="{{$product['quantity']}}">
                                            <div class="input-group-btn">
                                            <button class="btn btn-sm  rounded-circle bg-light border increase-items" data-url="{{ route('front.cart.increase', $product['product_id']) }}">
                                                <i class="fa fa-plus"></i>
                                            </button>

                                           </div>
                                        </div>
                                </td>
                                <td>
                                    <p class="mb-0 py-4 total">{{($product['total_price']) }}</p>
                                </td>
                                <td class="py-4">
                                    <button class="btn btn-md rounded-circle bg-light border remove-product" data-url="{{ route('front.cart.destroy', $product['product_id']) }}">
                                        <i class="fa fa-times text-danger"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    @endguest

                    @auth('customers')
                        @foreach($cartProducts as $product)
                            <tr>
                                <th scope="row" class="row m-0 justify-content-between">
                                    <div class="col-md-2 p-0"> <img src="{{$product['image_url']}}" alt="{{$product['product_name']}}" width="100" height="100"> </div>
                                    <p class="col-md-9 mb-0 ps-1">{{$product['product_name']}}</p>
                                    <div class="col-md-12 row mt-2 justify-content-between">
                                        <div class="col-md-6"><small>{{ __('front/labels.color') }}</small></div>
                                        <div class="col-md-1 rounded color-id" style="background-color: {{$product['color_name']}};" data-color="{{$product['color_id']}}"></div>
                                    </div>
                                </th>

                                <td>
                                    <p class="mb-0 py-4">{{$product['final_price'] .' '.  __('front/labels.currency') }}</p>
                                </td>
                                <td>
                                    <div class="input-group py-4 cart-btn-container" style="width: 100px;">
                                        <div class="input-group-btn">
                                            <button class="btn btn-sm rounded-circle bg-light border decrease-items" data-url="{{ route('front.cart.decrease', $product['product_id']) }}">
                                                <i class="fa fa-minus"></i>
                                            </button>
                                        </div>
                                        <input type="text" class="form-control form-control-sm text-center border-0 items-quantity"
                                               value="{{$product['quantity']}}">
                                            <div class="input-group-btn">
                                            <button class="btn btn-sm  rounded-circle bg-light border increase-items" data-url="{{ route('front.cart.increase', $product['product_id']) }}">
                                                <i class="fa fa-plus"></i>
                                            </button>

                                           </div>
                                        </div>
                                </td>
                                <td>
                                    <p class="mb-0 py-4 total">{{$product['total_price'] .' '. __('front/labels.currency') }}</p>
                                </td>
                                <td class="py-4">
                                    <button class="btn btn-md rounded-circle bg-light border remove-product" data-url="{{ route('front.cart.destroy', $product['product_id']) }}">
                                        <i class="fa fa-times text-danger"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    @endauth

                </tbody>
            </table>

        </div>

        @auth('customers')
            <div class="mt-5" id="coupon-container">
                <input type="text" class="border-0 border-bottom rounded me-5 py-3 mb-4" placeholder="{{ __('front/labels.coupon_code') }}" id="coupon-input">
                <a href="{{route('front.cart.addCoupon')}}" class="btn btn-primary rounded-pill px-4 py-3" id="coupon-btn">{{ __('front/labels.apply_coupon') }} </a>
            </div>
        @endauth


        <div class="row g-4 justify-content-end">
            <div class="col-8"></div>
            <div class="col-sm-8 col-md-7 col-lg-6 col-xl-4">
                <div class="bg-light rounded">
                    <div class="p-4">
                        <h1 class="display-6 mb-4">{{ __('front/labels.cart_total') }}</h1>
                        <div class="d-flex justify-content-between mb-4" id="subTotal">
                            <h5 class="mb-0 me-4">{{ __('front/labels.sub_total') }}:</h5>
                            <p class="mb-0" id="cart-sub-total"> {{$cartGrandTotal .' '.  __('front/labels.currency') }} </p>
                        </div>

                        <div class="" id="coupon-parent">
                        </div>

                    </div>
                    <div class="py-4 mb-4 border-top border-bottom d-flex justify-content-between">
                        <h5 class="mb-0 ps-4 me-4">{{ __('front/labels.cart_total') }}</h5>
                        <h5 class="mb-0 pe-4" id="cart-final-total">{{$cartGrandTotal .' '.  __('front/labels.currency') }}</h5>
                    </div>
                    <a href="{{ route('front.checkout') }}" class="btn btn-primary rounded-pill px-4 py-3 text-uppercase mb-4 ms-4"
                            type="button">{{ __('front/labels.proceed_to_checkout') }} </a>
                </div>
            </div>
        </div>
    </div>


    @else
            <div class="container rounded py-2 w-100 h-100 shadow-sm position-relative" style="background-color: rgba(0,0,0,0.025);">
                <div>
                    <img src="{{asset('assets/front/img/empty-cart.png')}}" class="position-relative d-block m-auto" style="bottom: 1rem;">
                <h1 class="w-50 text-center ps-4 m-auto" style="color: rgba(0,0,0,0.4); word-spacing: 0.4rem">Cart is empty !!</h1>
                </div>
            </div>
    @endif
</div>
<!-- Cart Page End -->
