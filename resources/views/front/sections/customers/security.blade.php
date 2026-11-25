<!-- Shop Page Start -->
<div class="container-fluid shop py-5">
    <div class="container">
        <div class="row wow fadeInUp justify-content-between">
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
            <div class="col-lg-9 rounded row m-0 p-0  bg-light">

                <h2 class=" w-100 rounded-top text-center font-weight-bold bg-primary p-2 mb-5" style="letter-spacing: 1px;">{{__('front/labels.account_data')}}</h2>

                <div class=" row m-0 px-2">
                <div class="col-lg-12 border rounded pt-2 pb-2 mb-3 bg-light">
                  <h4>{{__('front/labels.change_password')}}</h4>
{{--                    <p class="d-inline-block w-75">{{$customerData->name}}</p>--}}
{{--                    <a href="#" class="">edit</a>--}}



                    <form method="POST" action="{{ route('front.customers.security.update') }}">
                        @csrf
                        @method('PATCH')
                        <div class="form-row">
                            {{-- Current Password --}}
                            <div class="col-md-8 mb-3">
                                <label>{{__('front/labels.current_password')}}</label>
                                <input type="password" class="form-control @error('current_password') is-invalid @enderror" name="current_password" required>
                                @error('current_password')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- New Password --}}
                            <div class="col-md-8 mb-3">
                                <label>{{__('front/labels.new_password')}}</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" required>
                                @error('password')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Confirm Password --}}
                            <div class="col-md-8 mb-3">
                                <label>{{__('front/labels.confirm_new_password')}}</label>
                                <input type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>

                        <button class="btn btn-primary" type="submit">{{__('front/labels.update')}}</button>
                    </form>

                </div>

            </div>
        </div>
    </div>
</div>
<!-- Shop Page End -->
