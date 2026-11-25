@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
@auth('customers')

<!-- Checkout Page Start -->
<div class="container-fluid bg-light overflow-hidden py-5 m-0 row justify-content-center wow fadeInUp" >
    <div class=" p-0 m-0 row col-md-9 justify-content-center shadow" style="max-width: 71.1%;">

        <div class="row m-0 col-md-7 px-0  align-content-start">

            <div class="row col-md-12 m-0 ps-0 pe-2">
                <h1 class="mb-4 ">{{ __('front/labels.billing_details') }}</h1>
            </div>

            <div class="row col-md-12 m-0 ps-0 pe-2">
                <div class="">

                    <div class="accordion" id="accordionPanelsStayOpenExample">
                        <div class="accordion-item mb-4">
                            <h1 class="accordion-header lh-lg" id="panelsStayOpen-headingOne">
                                <button class="accordion-button fs-4" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true" aria-controls="panelsStayOpen-collapseOne" style="font-weight: 900 !important; ">
                                    {{ __('front/labels.customer_information') }}
                                </button>
                            </h1>
                            <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse show" aria-labelledby="panelsStayOpen-headingOne">
                                <div class="accordion-body">
                                    <div class="row">
                                        @isset($customerData)
                                            <div class="col-md-12  " >
                                                <div class="row mb-4">

                                                    <div class="col-md-12 col-lg-6">
                                                        <div class="form-item w-100">
                                                            <strong><label class="form-label text-dark">{{ __('front/labels.first_name') }}<sup>*</sup></label></strong>
                                                            <input type="text" class="form-control" value="{{$customerData['first_name']}}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 col-lg-6">
                                                        <div class="form-item w-100">
                                                            <strong><label class="form-label text-dark">{{ __('front/labels.last_name') }}<sup>*</sup></label></strong>
                                                            <input type="text" class="form-control" value="{{$customerData['last_name']}}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row mb-4">
                                                    <div class="col-md-6 form-item">
                                                        <strong><label class="form-label text-dark">{{ __('front/labels.mobile') }}<sup>*</sup></label></strong>
                                                        <input type="tel" class="form-control" value="{{$customerData['mobile']}}">
                                                    </div>
                                                    <div class="col-md-6 form-item">
                                                        <strong><label class="form-label text-dark">{{ __('front/labels.email') }} Address<sup>*</sup></label></strong>
                                                        <input type="email" class="form-control" value="{{$customerData['email']}}">
                                                    </div>
                                                </div>
                                                <div class="form-item mb-4">
                                                    <strong><label class="form-label text-dark">{{ __('front/labels.address') }} <sup>*</sup></label></strong>
                                                    <input type="text" class="form-control" value="{{$customerData['address']}}">
                                                </div>
                                                <hr>
                                                <div class="form-check mb-4">
                                                    <input class="form-check-input" type="checkbox" id="Address-1" name="Address"
                                                           value="Address">
                                                    <strong><label class="form-check-label text-dark" for="Address-1">{{ __('front/labels.ship_different_address') }}</label></strong>
                                                </div>
                                                <div class="form-item">
                                                    <textarea name="text" class="form-control" spellcheck="false" cols="30" rows="5"
                                                     placeholder="{{ __('front/labels.order_notes') .' '. __('front/labels.optional')  }}" style="resize: none;"></textarea>
                                                </div>
                                            </div>
                                        @endisset
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item  mb-4">
                            <h2 class="accordion-header lh-lg" id="panelsStayOpen-headingTwo">
                                <button class="accordion-button fs-4 collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseTwo" aria-expanded="false" aria-controls="panelsStayOpen-collapseTwo" style="font-weight: 900 !important; ">
                                    {{ __('front/labels.ship_methods') }}
                                </button>
                            </h2>
                            <div id="panelsStayOpen-collapseTwo" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingTwo">
                                <div class="accordion-body">
                                    <tr>
                                        <div class="row p-0 py-2 m-0">
                                            <div class="col-md-12 mb-3 lh-lg form-check text-start">
                                                <input type="radio" class="form-check-input bg-primary border-0"
                                                       id="Shipping-1" name="Shipping" value="1" data-url="{{ route('front.checkout.shipping') }}">
                                                <strong><label class="form-check-label text-dark" for="Shipping-1">{{ __('front/labels.fast_ship') }}  50 {{ __('front/labels.currency') }}</label></strong>
                                            </div>
                                            <hr>
                                            <div class="col-md-12 form-check lh-lg text-start">
                                                <input type="radio" class="form-check-input bg-primary border-0"
                                                       id="Shipping-2" name="Shipping" value="0" data-url="{{ route('front.checkout.shipping') }}">
                                                <strong><label class="form-check-label text-dark" for="Shipping-2">{{ __('front/labels.free_ship') }}
                                                   </label></strong>
                                            </div>
                                        </div>
                                    </tr>
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item  ">
                            <h2 class="accordion-header lh-lg" id="panelsStayOpen-headingThree">
                                <button class="accordion-button fs-4 collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseThree" aria-expanded="false" aria-controls="panelsStayOpen-collapseThree" style="font-weight: 900 !important;">
                                    {{ __('front/labels.payment') }}
                                </button>
                            </h2>
                            <div id="panelsStayOpen-collapseThree" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingThree">
                                <div class="accordion-body">
                                    <div class="row g-4 text-center align-items-center justify-content-center border-bottom py-2">
                                        <div class="col-12">
                                            <div class="form-check text-start my-2">
                                                <input type="radio" class="form-check-input bg-primary border-0" id="Delivery-1"
                                                       name="payment" value="Delivery">
                                                <strong><label class="form-check-label text-dark" for="Delivery-1">{{ __('front/labels.cash_on_delivery') }}</label></strong>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row g-4 text-center align-items-center justify-content-center  py-2">
                                        <div class="col-12">
                                            <div class="form-check text-start my-2">
                                                <input type="radio" class="form-check-input bg-primary " id="Paypal-1"
                                                       name="payment" value="Paypal">
                                                <strong><label class="form-check-label text-dark" for="Paypal-1">{{ __('front/labels.paypal') }}</label></strong>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>

        <div class="row m-0 pe-2 ps-0 col-md-5 position-relative align-content-start" >

            <div class="row col-md-12" style="height: 4.6rem;">
                    <h1 class="mb-4  ">{{ __('front/labels.summary') }}</h1>
            </div>

            <div class="col-md-12 row  m-0 p-0  my-auto "  style="min-height: 39rem;">

                        <div class="row col-md-12 m-0 p-0 " style="background-color: white; height:max-content; max-height: 21rem; overflow-y: auto;">
                            @foreach($cartProducts as $product)
                                <div class="row m-0 mt-3 p-0 " style="height: 9.5rem; border-bottom: 1px solid rgba(0,0,0,0.15);">
                                    <div class="col-md-3 pe-0 ps-2 pt-1 ">
                                        <img src="{{$product['image_url']}}" class="d-block m-auto" width="125" height="125" alt="photo">
                                    </div>
                                    <div class="col-md-7">
                                        <div class="col-md-12 mb-1 fs-5 text-dark"><strong>{{$product['product_name']}}</strong></div>
                                        <div class="col-md-12"><small><strong>{{ __('front/labels.color') }}:</strong> {{$product['color_name']}}</small></div>
                                        <div class="col-md-12"><small><strong>{{ __('front/labels.quantity') }}:</strong> {{$product['quantity']}}</small></div>
                                    </div>
                                    <div class="col-md-2 px-0 pt-1 text-dark"><strong>{{$product['total_price']}} {{ __('front/labels.currency') }}</strong></div>
                                </div>
                            @endforeach
                        </div>

                        <div class="row col-md-12 m-0  p-0 pe-2 position-absolute bottom-0" style="height: 17rem;">
                                <div class="row col-md-12 mb-4 m-0  p-0 pt-2 " style="background-color: white; height: 60%;" >
                                    <div class="row col-md-12 m-0 p-0">
                                        <p class="col-md-6 fs-5 text-dark"><strong>{{ __('front/labels.sub_total') }}</strong></p>
                                        <p class="col-md-6 fs-5 text-end text-dark" id="subtotal-val"><strong>{{ ($couponData && $couponData['finalTotal'])? $couponData['finalTotal'] : $cartGrandTotal}} {{ __('front/labels.currency') }}</strong></p>
                                    </div>
                                    <div class="row col-md-12 m-0 p-0">
                                        <p class="col-md-6 mb-1"><strong>{{ __('front/labels.coupon') }}
                                            @if($couponData && $couponData['couponName'])
                                               <span class=" ms-2 text-end" id="coupon-name"><small>( {{$couponData['couponName']}} )</small></span>
                                            @endif
                                            </strong>
                                        </p>
                                        <p class="col-md-6 mb-1 text-end {{ ($couponData && $couponData['discount'])? 'text-success' : '' }}" id="coupon-val"><strong><small>{{($couponData && $couponData['discount'])? '- '.$couponData['discount'].' '. __('front/labels.currency')  :  __('front/labels.no_coupon') }}</small></strong></p>
                                    </div>
                                    <div class="row col-md-12 m-0 p-0">
                                        <p class="col-md-6 mb-1" id="shipping-name"><strong>{{ __('front/labels.shipping') }} <small></small></strong></p>
                                        <p class="col-md-6 mb-1 text-end" id="shipping-val"><strong><small>_____</small></strong></p>
                                    </div>
                                    <div class="row col-md-12 m-0 p-0">
                                        <p class="col-md-6 mb-1" id="fees-name"><strong>{{ __('front/labels.fees') }}</strong></p>
                                        <p class="col-md-6 mb-1 text-end" id="fees-val"><strong><small>_____</small></strong></p>
                                    </div>
                                </div>
                                <div class="row col-md-12 m-0 px-2 align-items-center" style="background-color: white; height: 30%;">
                                    <p class="col-md-6 m-0 p-0 fs-3 text-dark"><strong>{{ __('front/labels.total_amount') }}</strong></p>
                                    <p class="col-md-6 m-0 p-0 fs-3 text-end text-dark"><strong>{{$orderTotalPrice .' '. __('front/labels.currency')}} </strong></p>
                                </div>
                        </div>

            </div>

        </div>



{{--        <form action="#">--}}
{{--            <div class="row g-5">--}}
{{--                @isset($customerData)--}}
{{--                <div class="col-md-12 col-lg-6 col-xl-6 wow fadeInUp" data-wow-delay="0.1s">--}}
{{--                    <div class="row">--}}

{{--                        <div class="col-md-12 col-lg-6">--}}
{{--                            <div class="form-item w-100">--}}
{{--                                <label class="form-label my-3">First Name<sup>*</sup></label>--}}
{{--                                <input type="text" class="form-control" value="{{$customerData['first_name']}}">--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="col-md-12 col-lg-6">--}}
{{--                            <div class="form-item w-100">--}}
{{--                                <label class="form-label my-3">Last Name<sup>*</sup></label>--}}
{{--                                <input type="text" class="form-control" value="{{$customerData['last_name']}}">--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="form-item">--}}
{{--                        <label class="form-label my-3">Mobile<sup>*</sup></label>--}}
{{--                        <input type="tel" class="form-control" value="{{$customerData['mobile']}}">--}}
{{--                    </div>--}}
{{--                    <div class="form-item">--}}
{{--                        <label class="form-label my-3">Email Address<sup>*</sup></label>--}}
{{--                        <input type="email" class="form-control" value="{{$customerData['email']}}">--}}
{{--                    </div>--}}
{{--                    <div class="form-item">--}}
{{--                        <label class="form-label my-3">Address <sup>*</sup></label>--}}
{{--                        <input type="text" class="form-control" placeholder="House Number Street Name" value="{{$customerData['address']}}">--}}
{{--                    </div>--}}

{{--                    <div class="form-item">--}}
{{--                        <label class="form-label my-3">Company Name<sup>*</sup></label>--}}
{{--                        <input type="text" class="form-control">--}}
{{--                    </div>--}}
{{--                    <div class="form-item">--}}
{{--                        <label class="form-label my-3">Town/City<sup>*</sup></label>--}}
{{--                        <input type="text" class="form-control">--}}
{{--                    </div>--}}
{{--                    <div class="form-item">--}}
{{--                        <label class="form-label my-3">Country<sup>*</sup></label>--}}
{{--                        <input type="text" class="form-control">--}}
{{--                    </div>--}}
{{--                    <div class="form-item">--}}
{{--                        <label class="form-label my-3">Postcode/Zip<sup>*</sup></label>--}}
{{--                        <input type="text" class="form-control">--}}
{{--                    </div>--}}

{{--                    <hr>--}}
{{--                    <div class="form-check my-3">--}}
{{--                        <input class="form-check-input" type="checkbox" id="Address-1" name="Address"--}}
{{--                               value="Address">--}}
{{--                        <label class="form-check-label" for="Address-1">Ship to a different address?</label>--}}
{{--                    </div>--}}
{{--                    <div class="form-item">--}}
{{--                            <textarea name="text" class="form-control" spellcheck="false" cols="30" rows="11"--}}
{{--                                      placeholder="Oreder Notes (Optional)"></textarea>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                @endisset--}}
{{--                <div class="col-md-12 col-lg-6 col-xl-6 wow fadeInUp" data-wow-delay="0.3s">--}}
{{--                    <div class="table-responsive">--}}
{{--                        <table class="table">--}}
{{--                            <thead>--}}
{{--                            <tr class="text-center">--}}
{{--                                <th scope="col" class="text-start">Name</th>--}}
{{--                                <th scope="col">Price</th>--}}
{{--                                <th scope="col">Quantity</th>--}}
{{--                                <th scope="col">Total</th>--}}
{{--                            </tr>--}}
{{--                            </thead>--}}
{{--                            <tbody>--}}

{{--                                @foreach($cartProducts as $product)--}}
{{--                                    <tr class="text-center">--}}
{{--                                        <th scope="row" class="text-start py-4">--}}
{{--                                            {{$product['product_name']}}--}}
{{--                                        </th>--}}
{{--                                        <td class="py-4">{{$product['final_price']}}</td>--}}
{{--                                        <td class="py-4 text-center">{{$product['quantity']}}</td>--}}
{{--                                        <td class="py-4">{{$product['total_price']}}</td>--}}
{{--                                    </tr>--}}
{{--                                @endforeach--}}












{{--                            <tr>--}}
{{--                                <th scope="row">--}}
{{--                                </th>--}}
{{--                                <td class="py-4"></td>--}}
{{--                                <td class="py-4"></td>--}}
{{--                                <td class="py-4">--}}
{{--                                    <p class="mb-0 text-dark py-2">Subtotal</p>--}}
{{--                                </td>--}}
{{--                                <td class="py-4">--}}
{{--                                    <div class="py-2 text-center border-bottom border-top">--}}
{{--                                        <p class="mb-0 text-dark">{{$cartGrandTotal .' $'}}</p>--}}
{{--                                    </div>--}}
{{--                                </td>--}}
{{--                            </tr>--}}
{{--                            <tr>--}}
{{--                                <th scope="row">--}}
{{--                                </th>--}}
{{--                                <td class="py-4">--}}
{{--                                    <p class="mb-0 text-dark py-4">Shipping</p>--}}
{{--                                </td>--}}
{{--                                <td colspan="3" class="py-4">--}}
{{--                                    <div class="form-check text-start">--}}
{{--                                        <input type="checkbox" class="form-check-input bg-primary border-0"--}}
{{--                                               id="Shipping-1" name="Shipping-1" value="Shipping">--}}
{{--                                        <label class="form-check-label" for="Shipping-1">Free Shipping</label>--}}
{{--                                    </div>--}}
{{--                                    <div class="form-check text-start">--}}
{{--                                        <input type="checkbox" class="form-check-input bg-primary border-0"--}}
{{--                                               id="Shipping-2" name="Shipping-1" value="Shipping">--}}
{{--                                        <label class="form-check-label" for="Shipping-2">Flat rate:--}}
{{--                                            $15.00</label>--}}
{{--                                    </div>--}}
{{--                                    <div class="form-check text-start">--}}
{{--                                        <input type="checkbox" class="form-check-input bg-primary border-0"--}}
{{--                                               id="Shipping-3" name="Shipping-1" value="Shipping">--}}
{{--                                        <label class="form-check-label" for="Shipping-3">Local Pickup:--}}
{{--                                            $8.00</label>--}}
{{--                                    </div>--}}
{{--                                </td>--}}
{{--                            </tr>--}}
{{--                            <tr>--}}
{{--                                <th scope="row">--}}
{{--                                </th>--}}
{{--                                <td class="py-4">--}}
{{--                                    <p class="mb-0 text-dark text-uppercase py-2">TOTAL</p>--}}
{{--                                </td>--}}
{{--                                <td class="py-4"></td>--}}
{{--                                <td class="py-4"></td>--}}
{{--                                <td class="py-4">--}}
{{--                                    <div class="py-2 text-center border-bottom border-top">--}}
{{--                                        <p class="mb-0 text-dark">$135.00</p>--}}
{{--                                    </div>--}}
{{--                                </td>--}}
{{--                            </tr>--}}
{{--                            </tbody>--}}
{{--                        </table>--}}
{{--                    </div>--}}
{{--                    <div class="row g-0 text-center align-items-center justify-content-center border-bottom py-2">--}}
{{--                        <div class="col-12">--}}
{{--                            <div class="form-check text-start my-2">--}}
{{--                                <input type="checkbox" class="form-check-input bg-primary border-0" id="Transfer-1"--}}
{{--                                       name="Transfer" value="Transfer">--}}
{{--                                <label class="form-check-label" for="Transfer-1">Direct Bank Transfer</label>--}}
{{--                            </div>--}}
{{--                            <p class="text-start text-dark">Make your payment directly into our bank account. Please--}}
{{--                                use your Order ID as the payment reference. Your order will not be shipped until the--}}
{{--                                funds have cleared in our account.</p>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="row g-4 text-center align-items-center justify-content-center border-bottom py-2">--}}
{{--                        <div class="col-12">--}}
{{--                            <div class="form-check text-start my-2">--}}
{{--                                <input type="checkbox" class="form-check-input bg-primary border-0" id="Payments-1"--}}
{{--                                       name="Payments" value="Payments">--}}
{{--                                <label class="form-check-label" for="Payments-1">Check Payments</label>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="row g-4 text-center align-items-center justify-content-center border-bottom py-2">--}}
{{--                        <div class="col-12">--}}
{{--                            <div class="form-check text-start my-2">--}}
{{--                                <input type="checkbox" class="form-check-input bg-primary border-0" id="Delivery-1"--}}
{{--                                       name="Delivery" value="Delivery">--}}
{{--                                <label class="form-check-label" for="Delivery-1">Cash On Delivery</label>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="row g-4 text-center align-items-center justify-content-center border-bottom py-2">--}}
{{--                        <div class="col-12">--}}
{{--                            <div class="form-check text-start my-2">--}}
{{--                                <input type="checkbox" class="form-check-input bg-primary border-0" id="Paypal-1"--}}
{{--                                       name="Paypal" value="Paypal">--}}
{{--                                <label class="form-check-label" for="Paypal-1">Paypal</label>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}

{{--                </div>--}}
{{--            </div>--}}
{{--        </form>--}}







        <div class="row  text-center align-items-center justify-content-center ps-0 pe-0 mt-4 mb-1">

            <form action="{{ route('front.order.store') }}" method="POST" class="pe-1">
                @csrf
                {{--                            <select name="address_id">--}}
                {{--                                @foreach($addresses as $address)--}}
                {{--                                    <option value="{{ $address->id }}">{{ $address->full_address }}</option>--}}
                {{--                                @endforeach--}}
                {{--                            </select>--}}

                {{--                            <input type="radio" name="payment_method" value="cod" checked> Cash on Delivery--}}

                <button type="submit" class="btn btn-primary border-secondary py-3 p-0 text-uppercase w-100 text-primary fs-2"><strong style="word-spacing: 0.6rem;">{{__('front/labels.place_order')}}</strong>
                </button>
            </form>


        </div>
    </div>
</div>
<!-- Checkout Page End -->
@endauth
