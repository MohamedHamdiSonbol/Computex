<!-- Shop Page Start -->
<div class="container-fluid shop py-5">
    <div class="container">
        <div class="row wow fadeInUp justify-content-between" >
            <div class="col-lg-2 rounded bg-light p-0" >
                <h2 class=" w-100 rounded-top text-center font-weight-bold bg-primary p-2 mb-5" style="letter-spacing: 1px;">{{__('front/labels.dashboard')}}</h2>
                <div class="product-categories px-2">
                        <ul class="list-unstyled">

                            <li class="list-unstyled mb-3">
                                <a href="{{ route('front.customers.index') }}"
                                   class="btn btn-outline-dark w-100 shadow-lg font-weight-bold text-uppercase py-3 {{ request()->routeIs('front.customers.index') ? 'btn-dark text-white' : 'btn-outline-dark' }} text-start"
                                   style="letter-spacing: 1px;">
                                    <i class="fas fa-user-circle fa-lg me-1"></i> {{__('front/labels.account_information')}}
                                </a>
                            </li>

                            <li class="list-unstyled mb-3">
                                <a href="{{ route('front.customers.security') }}"
                                   class="btn btn-outline-dark w-100 shadow-lg font-weight-bolder text-uppercase py-3 text-start"
                                   style="letter-spacing: 1px;">
                                    <i class="fas fa-shield-alt fa-lg me-1"></i>
                                    <span>{{__('front/labels.security')}}</span>
                                </a>
                            </li>

                            <li class="list-unstyled mb-3">
                                <a href="{{ route('front.customers.orders') }}"
                                   class="btn btn-outline-dark w-100 shadow-lg font-weight-bolder text-uppercase py-3 text-start"
                                   style="letter-spacing: 1px;">
                                    <i class="far fa-copy fa-lg me-1"></i>
                                    <span>{{__('front/labels.my_orders')}}</span>
                                </a>
                            </li>

                            <li class="list-unstyled mb-3">
                                <a href="#"
                                   class="btn btn-outline-dark w-100 shadow-lg font-weight-bold text-uppercase py-3 text-start"
                                   style="letter-spacing: 1px;">
                                    <i class="fas fa-heart fa-lg me-1"></i>
                                    <span>{{__('front/labels.wish_list')}}</span>
                                </a>
                            </li>

                            <li class="list-unstyled mb-3">
                                    <form id="logout-form" action="{{ route('front.logout') }}" method="POST" >
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-outline-dark w-100 shadow-lg font-weight-bold text-uppercase py-3 text-start"
                                                style="letter-spacing: 1px;">
                                            <span class="w-50">
                                                <i class="fas fa-sign-out-alt fa-lg text-danger me-1" ></i>
                                                 {{__('front/labels.sign_out')}}
                                            </span>
                                        </button>
                                    </form>
                            </li>

                        </ul>
                </div>
            </div>

            <div class="col-lg-9 rounded  m-0 p-0  bg-light">

                <h2 class=" w-100 rounded-top text-center font-weight-bold bg-primary p-2 mb-5" style="letter-spacing: 1px;">{{__('front/labels.account_data')}}</h2>

                <div class=" m-0 px-2">

                    <div class="col-lg-12 border rounded pt-2 pb-2 mb-3 " style="background-color: white;">
                      <h4>Name</h4>
                        <p class="d-inline-block w-75">{{$customerData['first_name'] .' '. $customerData['last_name']}}</p>
                        <a href="#" class="">{{__('front/labels.edit')}}</a>
                    </div>

                    <div class="col-lg-12 rounded border pt-2 pb-2 mb-3 " style="background-color: white;">
                      <h4>{{__('front/labels.email')}}</h4>
                        <p class="d-inline-block w-75">{{$customerData['email']}}</p>
                    </div>

                    <div class="col-lg-12 rounded border pt-2 pb-2 mb-3 " style="background-color: white;">
                      <h4>{{__('front/labels.mobile')}}</h4>
                        <p class="d-inline-block w-75">{{$customerData['mobile']}}</p>
                            <a href="#" class="">{{__('front/labels.edit')}}</a>
                    </div>

                    <div class="col-lg-12 rounded border pt-2 pb-2 mb-3 " style="background-color: white;">
                      <h4>{{__('front/labels.address')}}</h4>
                        <p class="d-inline-block w-75">{{$customerData['address']}}</p>
                            <a href="#" class="">{{__('front/labels.edit')}}</a>
                    </div>
               </div>
           </div>
    </div>
</div>
</div>
<!-- Shop Page End -->
