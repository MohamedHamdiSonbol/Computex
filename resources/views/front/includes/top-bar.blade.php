<!-- Topbar Start -->
{{--<div class="container-fluid px-5 d-none border-bottom d-lg-block">--}}
{{--    <div class="row gx-0 align-items-center">--}}
{{--        <div class="col-lg-4 text-center text-lg-start mb-lg-0">--}}
{{--            <div class="d-inline-flex align-items-center" style="height: 45px;">--}}
{{--                <a href="#" class="text-muted me-2"> Help</a><small> / </small>--}}
{{--                <a href="#" class="text-muted mx-2"> Support</a><small> / </small>--}}
{{--                <a href="#" class="text-muted ms-2"> Contact</a>--}}

{{--            </div>--}}
{{--        </div>--}}
{{--        <div class="col-lg-4 text-center d-flex align-items-center justify-content-center">--}}
{{--            <small class="text-dark">Call Us:</small>--}}
{{--            <a href="#" class="text-muted">(+012) 1234 567890</a>--}}
{{--        </div>--}}

{{--        <div class="col-lg-4 text-center text-lg-end">--}}
{{--            <div class="d-inline-flex align-items-center" style="height: 45px;">--}}
{{--                <div class="dropdown">--}}
{{--                    <a href="#" class="dropdown-toggle text-muted me-2" data-bs-toggle="dropdown"><small>--}}
{{--                            USD</small></a>--}}
{{--                    <div class="dropdown-menu rounded">--}}
{{--                        <a href="#" class="dropdown-item"> Euro</a>--}}
{{--                        <a href="#" class="dropdown-item"> Dolar</a>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="dropdown">--}}
{{--                    <a href="#" class="dropdown-toggle text-muted mx-2" data-bs-toggle="dropdown"><small>--}}
{{--                            English</small></a>--}}
{{--                    <div class="dropdown-menu rounded">--}}
{{--                        <a href="#" class="dropdown-item"> English</a>--}}
{{--                        <a href="#" class="dropdown-item"> Turkish</a>--}}
{{--                        <a href="#" class="dropdown-item"> Spanol</a>--}}
{{--                        <a href="#" class="dropdown-item"> Italiano</a>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="dropdown">--}}
{{--                    <a href="#" class="dropdown-toggle text-muted ms-2" data-bs-toggle="dropdown"><small><i--}}
{{--                                class="fa fa-home me-2"></i> My Dashboard</small></a>--}}
{{--                    <div class="dropdown-menu rounded">--}}
{{--                        <a href="#" class="dropdown-item"> Login</a>--}}
{{--                        <a href="#" class="dropdown-item"> Wishlist</a>--}}
{{--                        <a href="#" class="dropdown-item"> My Card</a>--}}
{{--                        <a href="#" class="dropdown-item"> Notifications</a>--}}
{{--                        <a href="#" class="dropdown-item"> Account Settings</a>--}}
{{--                        <a href="#" class="dropdown-item"> My Account</a>--}}
{{--                        <a href="#" class="dropdown-item"> Log Out</a>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}
<div class="container-fluid px-5 py-2 d-none d-lg-block">
    <div class="row gx-0 align-items-center text-center">
        <div class="col-md-4 col-lg-2 text-center text-lg-start">
            <div class="d-inline-flex align-items-center">
                <a href="" class="navbar-brand p-0">
                    <h1 class="display-5 text-primary m-0"><i
                            class="fas fa-shopping-bag text-secondary me-2"></i>Electro</h1>
                    <!-- <img src="img/logo.png" alt="Logo"> -->
                </a>
            </div>
        </div>
        <div class="col-md-4 col-lg-6 text-center">
            <div class="position-relative ps-4">
                <form method="GET" action="{{ route('front.products.search')  }}">
                    @csrf
                    <div class="d-flex border rounded-pill">
                        <input class="form-control border-0 rounded-pill w-100 py-3" type="text"
                               data-bs-target="#dropdownToggle123" placeholder="Search Looking For?" name="searchTerm">
                        <select class="form-select text-dark border-0 border-start rounded-0 p-3" style="width: 200px;" name="categoryId">

                            <option value="">All Category</option>
                            @foreach($categories as $category)
                                <option value="{{$category['category_id']}}">{{$category['name']}}</option>
                            @endforeach
                        </select>

                        <button type="submit" class="btn btn-primary rounded-pill py-3 px-5" style="border: 0;"><i
                                class="fas fa-search"></i>
                        </button>

                    </div>
                </form>
            </div>
        </div>
        <div class="col-md-4 col-lg-4 text-center text-lg-end">

            <div class="d-inline-flex align-items-center" style="height: 45px;">
{{--                <div class="dropdown">--}}
{{--                    <a href="#" class="dropdown-toggle text-muted me-2" data-bs-toggle="dropdown"><small>--}}
{{--                            USD</small></a>--}}
{{--                    <div class="dropdown-menu rounded">--}}
{{--                        <a href="#" class="dropdown-item"> Euro</a>--}}
{{--                        <a href="#" class="dropdown-item"> Dolar</a>--}}
{{--                    </div>--}}
{{--                </div>--}}

                <div class="dropdown">
                    <a href="#" class="dropdown-toggle text-muted mx-2" data-bs-toggle="dropdown">
                        <small>{{ strtoupper(App::getLocale()) }}</small>
                    </a>
                    <div class="dropdown-menu rounded">
                        @foreach($languages as $lang)
                            <a href="{{route('language.switch', $lang->abbr)}}" class="dropdown-item {{App::getLocale()  === $lang->abbr? 'active' : ''}}">{{$lang->name}}</a>
                        @endforeach
                    </div>
                </div>

{{--                <div class="dropdown">--}}
{{--                    <a href="#" class="dropdown-toggle text-muted ms-2" data-bs-toggle="dropdown"><small><i--}}
{{--                                class="fa fa-home me-2"></i> My Dashboard</small></a>--}}
{{--                    <div class="dropdown-menu rounded">--}}
{{--                        <a href="#" class="dropdown-item"> Login</a>--}}
{{--                        <a href="#" class="dropdown-item"> Wishlist</a>--}}
{{--                        <a href="#" class="dropdown-item"> My Card</a>--}}
{{--                        <a href="#" class="dropdown-item"> Notifications</a>--}}
{{--                        <a href="#" class="dropdown-item"> Account Settings</a>--}}
{{--                        <a href="#" class="dropdown-item"> My Account</a>--}}
{{--                        <a href="#" class="dropdown-item"> Log Out</a>--}}
{{--                    </div>--}}
{{--                </div>--}}

            </div>
            <div class="d-inline-flex  align-items-center">

                @auth('customers')
                    <a href="{{route('front.customers.index')}}" class="ms-3 ">
                        <i class="fas fa-user-tie fs-4"></i>
{{--                        <i class="fa fa-home fa-lg "></i>--}}
                        <span>Hi {{auth('customers')->user()->first_name .' '. auth('customers')->user()->last_name}}</span>
                    </a>

                    <a  class=" d-flex align-items-center justify-content-center mx-3">
                            <form id="logout-form" action="{{ route('front.logout') }}" method="POST" >
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-link text-muted">
                                    <span
                                        class="rounded-circle btn-md-square border"><i class="fas fa-sign-out-alt fa-lg" style="color: #F28B00;"></i>
                                    </span>
                                </button>
                             </form>
                    </a>
                @endauth

                @guest('customers')
                        <a href="{{route('front.login.create')}}" class="me-3 ">
                            <span>Sign In</span>
                        </a>
                @endguest

                <a href="#" class="text-muted d-flex align-items-center justify-content-center me-3"><span
                        class="rounded-circle btn-md-square border"><i class="fas fa-heart"></i></a>

                <a href="{{  route('front.cart')  }}" class="text-muted d-flex align-items-center justify-content-center">
                    <span class=" rounded-circle btn-lg-square border">
                        <i class="fas fa-shopping-cart fa-lg"></i>
                    <span class="ms-1" id="cart-count" style="color: #F28B00; font-weight: bold">{{$cartCount}}</span>

                    </span>

                </a>
            </div>

        </div>
    </div>
</div>
<!-- Topbar End -->
