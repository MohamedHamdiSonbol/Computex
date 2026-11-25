<!-- Single Page Header start -->
<div class="container page-header p-0 pb-0"
     style="background: linear-gradient(rgba(0, 0, 0, 0.75), rgba(0, 0, 0, 0.5)), url('{{ asset('assets/front/img/default-header.jpg') }}');">
    <div class="row m-0 py-3 justify-content-between">
        <div class="col-md-3">
            <ol class="breadcrumb justify-content-center mb-0 wow fadeInUp " data-wow-delay="0.3s">
                <li class="breadcrumb-item font-weight-bold">
                    <a href="{{ route('front.home') }}"> Home </a>
                </li>
                <li class="breadcrumb-item active text-white font-weight-bold"> {{__('front/labels.track_order')}}
                </li>
            </ol>
        </div>
        <div class="col-md-8 ps-3">
            <h1 class=" ps-5 text-white display-6 font-weight-bold wow fadeInUp" data-wow-delay="0.1s"> {{__('front/labels.track_your_order')}}
            </h1>
            <p class=" my-4 text-light  wow fadeInUp" data-wow-delay="0.1s">{{__('front/labels.Stay_updated_with_your_order_status_and_delivery_details')}}
            </p>

            <p class="w-50 pe-3 font-weight-bolder fs-5 text-center text-white  wow fadeInUp">{{__('front/labels.order_id')}}:
                <span class="ps-1 text-info ">
                    #lkjhojd6514
                </span>
            </p>
        </div>

    </div>





</div>
<!-- Single Page Header End -->

<!-- Tracking Start -->
<div class="container my-5">
    <div class="row">
        <div class="col-12">
            <ul class="track-order-stepper">
                <li class="active">
                    <div class="icon"><i class="fas fa-file-alt fa-lg"></i></div>
                    <p class="step-title">{{__('front/labels.order_placed')}}</p>
                    <small>May 16, 2024</small>
                </li>
                <li class="active">
                    <div class="icon"><i class="fas fa-box fa-lg"></i></div>
                    <p class="step-title">{{__('front/labels.confirmed')}}</p>
                    <small>May 16, 2024</small>
                </li>
                <li class="{{$order->status == 'shipped'? 'active': ''}}">
                    <div class="icon"><i class="fas fa-truck fa-lg"></i></div>
                    <p class="step-title">{{__('front/labels.shipped')}}</p>
                    <small>Expected May 17</small>
                </li>
                <li class="{{$order->status == 'out for delivery'? 'active': ''}}">
                    <div class="icon"><i class="fas fa-map-marker-alt fa-lg"></i></div>
                    <p class="step-title">{{__('front/labels.out_for_delivery')}}</p>
                    <small>Expected May 18</small>
                </li>
                <li class="{{$order->status == 'delivered'? 'active': ''}}">
                    <div class="icon"><i class="fas fa-check fa-lg"></i></div>
                    <p class="step-title">{{__('front/labels.delivered')}}</p>
                    <small>Expected May 18</small>
                </li>
            </ul>
        </div>
    </div>
</div>
<!-- Tracking End -->



<!-- Order Details Start -->
<div class="container-fluid shop py-5">
    <div class="container">
        <div class="row wow fadeInUp justify-content-between" >

            <div class="col-lg-6 rounded bg-light p-0" style="width: 53%;" >
                <h2 class=" w-100 rounded-top text-center font-weight-bold bg-primary p-2 mb-5" style="letter-spacing: 1px;">{{__('front/labels.order_details')}}</h2>
                <div class="product-categories px-2">
                    @isset($order)
                    <ul class="list-unstyled">

                        <li class="list-unstyled row shadow-lg font-weight-bold px-0 py-1 mx-0 my-3 bg-white fs-5">
                            <p class="col-md-6 m-auto">
                                    <span>
                                        <i class="far fa-file-alt fa-lg text-dark me-2"></i>
                                    </span>
                                {{__('front/labels.order_id')}}
                            </p>
                            <p class="col-md-6 m-auto">{{$order->order_number}}</p>
                        </li>

                        <li class="list-unstyled row shadow-lg font-weight-bold px-0 py-1 mx-0 my-3 bg-white fs-5">
                            <p class="col-md-6 m-auto">
                                    <span>
                                        <i class="far fa-calendar-check text-dark fa-lg me-2"></i>
                                    </span>
                                {{__('front/labels.order_date')}}
                            </p>
                            <p class="col-md-6 m-auto">{{$order->created_at}}</p>
                        </li>

                        <li class="list-unstyled row shadow-lg font-weight-bold px-0 py-1 mx-0 my-3 bg-white fs-5">
                            <p class="col-md-6 m-auto">
                                    <span>
                                        <i class="fas fa-credit-card text-dark me-2"></i>
                                    </span>
                                {{__('front/labels.payment_method')}}
                            </p>
                            <p class="col-md-6 m-auto">Null</p>
                        </li>

                        <li class="list-unstyled row shadow-lg font-weight-bold px-0 py-1 mx-0 my-3 bg-white fs-5">
                            <p class="col-md-6 m-auto">
                                    <span>
                                        <i class="fas fa-file-invoice-dollar text-dark fa-lg me-2"></i>
                                    </span>
                                {{__('front/labels.payment_status')}}
                            </p>
                            <p class="col-md-6 m-auto">Null</p>
                        </li>

                        <li class="list-unstyled row shadow-lg font-weight-bold px-0 py-1 mx-0 my-3 bg-white fs-5">
                            <p class="col-md-6 m-auto">
                                    <span>
                                        <i class="fas fa-dollar-sign text-dark fa-lg me-2"></i>
                                    </span>
                                {{__('front/labels.total_amount')}}
                            </p>
                            <p class="col-md-6 m-auto">{{$order->total_price .' '. __('front/labels.currency')}} </p>
                        </li>

                        <li class="list-unstyled row shadow-lg font-weight-bold px-0 py-1 mx-0 my-3 bg-white fs-5">
                            <p class="col-md-6 m-auto">
                                    <span>
                                        <i class="fas fa-map-marker-alt text-dark fa-lg me-2"></i>
                                    </span>
                                {{__('front/labels.ship_address')}}
                            </p>
                            <p class="col-md-6 m-auto">{{$order->address}}</p>
                        </li>

                        <li class="list-unstyled row shadow-lg font-weight-bold px-0 py-1 mx-0 my-3 bg-white fs-5">
                            <p class="col-md-6 m-auto">
                                    <span>
                                        <i class="fas fa-phone-volume text-dark fa-lg me-2"></i>
                                    </span>
                                {{__('front/labels.contact_number')}}
                            </p>
                            <p class="col-md-6 m-auto">{{$order->phone}}</p>
                        </li>

                    </ul>
                    @endisset
                </div>
            </div>

            <div class="col-lg-5 rounded  m-0 p-0 bg-light" style="width:46%; height: max-content; max-height: 36rem; overflow-y: auto;">

                <h2 class=" w-100 rounded-top text-center font-weight-bold bg-primary p-2 mb-5" style="letter-spacing: 1px;">{{__('front/labels.items_in_order')}}</h2>

                @foreach($orderItems as $item)
                    <div class="row mx-1 py-1 mb-2 bg-white justify-content-between">
                        <div class="col-md-3 p-0 ">
                            <img src="{{ $item['photo'] }}" class="rounded p-o" alt="{{$item['name']}}" width="125" height="115">
                        </div>

                        <div class="col-md-7 row p-0 d-flex flex-column justify-content-between">
                            <h5 class="p-0 m-0 pt-1 col-md-12" style="height: 55%;">{{$item['name']}}</h5>
                            <p class="p-0 m-0 text-dark col-md-12" style="font-weight: 900;">{{__('front/labels.qty')}}: {{$item['quantity']}} </p>
                            <p class="p-0 m-0 text-dark col-md-12" style="font-weight: 900;">{{__('front/labels.color')}}: {{$item['color']}} </p>
                        </div>

                        <div class="col-md-2 m-0 p-0 d-flex flex-column justify-content-end text-center">
                            <p class="text-dark " style="font-weight: 900;">{{$item['price'] .' '. __('front/labels.currency')}} </p>
                        </div>
                    </div>
                @endforeach

            </div>

        </div>
    </div>
</div>
<!-- Order Details End -->
