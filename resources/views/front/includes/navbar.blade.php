<!-- Navbar & Hero Start -->

<nav class="navbar navbar-expand-lg sticky-top navbar-light shadow bg-dark" style="background-color: #B2B2B2;)">
    <div class="container-fluid">
       <div class="row m-0 p-0 w-100 justify-content-between align-items-center ">
                   <a class="navbar-brand d-none d-lg-block  col-lg-2 w-auto p-0 mx-lg-4 me-sm-1" href="#" >
                        <img src="{{asset('assets/front/img/logo2.png')}}" alt="Logo" class="w-100"  width="100" height="100">
                   </a>
               <a class="navbar-brand d-block d-lg-none col-4  w-25 p-0  mx-1" href="#">
                   <img src="{{asset('assets/front/img/logo2.png')}}" alt="Logo" class="w-100"  width="100" height="75">
               </a>

            <ul class="col-6 list-unstyled m-0  p-0 d-lg-none d-flex justify-content-between ">

                <li class="nav-item d-flex align-items-center " >
                    @auth('customers')
                        <a href="{{route('front.customers.index')}}" class=" p-0 nav-link">
                            <small class="shadow border bg-light rounded fw-bold p-2 ">
                                <i class="fas fa-user-tie fa-lg ms-1"></i>
                                <span>{{__('front/labels.hi') .' '. auth('customers')->user()->first_name}}</span>
                            </small>
                        </a>
                    @endauth

                    @guest('customers')
                        <a href="{{route('front.login.create')}}" class="ms-3 nav-link rounded shadow bg-light border fw-bold">
                            <small><span>{{__('front/labels.sign_in')}}</span></small>
                        </a>
                    @endguest
                </li>


                <li class="nav-item position-relative " >
                    <a href="{{ route('front.cart') }}" class="nav-link text-dark btn btn-md-square rounded shadow border bg-light rounded-circle fw-bold px-2 pb-0 pt-2">
                        <span class=" ">
                            <i class="fas fa-shopping-cart fa-lg position-absolute" style="top: 50%; left: 20%;"></i>
                            <span class="position-absolute" id="cart-count" style="color: #F28B00; font-weight: bold; bottom: 45%; right: 38%;">{{$cartCount}}</span>
                        </span>
                    </a>
                </li>
            </ul>

            <button class="navbar-toggler col-1 px-1  py-1 {{$lang==='ar'? 'ms-1': 'me-1'}}" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation" style="background-color: rgba(0,0,0,0.2); width: 3.7rem; height: 4rem;">
                <span class="navbar-toggler-icon w-75 "></span>
            </button>

            <div class="col-lg-9 row mt-4 mb-3 m-lg-0 p-0 collapse navbar-collapse mt-sm-4 mt-lg-0 px-0 justify-content-between" id="navbarScroll">

                <form method="GET" action="{{ route('front.products.search') }}" class="d-flex col-11 col-lg-5 my-2 {{$lang==='ar'? ' me-3 me-lg-5': 'ms-3 ms-lg-5'}}   px-0 my-lg-0 position-relative" style="min-width: 40%;">
                    @csrf
                    <input class="form-control shadow-sm py-lg-3 fw-bold rounded-pill  " type="search" placeholder="{{__('front/labels.search')}}" aria-label="Search" name="searchTerm">

                    <button class="btn rounded-pill shadow-sm px-5 py-lg-3 lh-lg-lg text-light fw-bold  position-absolute top-0 {{$lang==='ar'? 'start-0': 'end-0'}}" type="submit" style="background-color: darkorange;">{{__('front/labels.search')}}</button>

                </form>

                <ul class=" list-unstyled {{$lang==='ar'? 'me-3': 'ms-3'}}  d-flex col-11 col-lg-6 justify-content-lg-evenly justify-content-between align-items-center mx-lg-0 p-0 my-2 my-lg-0 " style="--bs-scroll-height: 100px;">

                    <li class="nav-item rounded shadow bg-light border py-lg-1 my-sm-3 my-lg-auto {{$lang==='ar'? 'ms-lg-5': 'me-lg-4 px-lg-4'}}">
                            <a href="{{route('front.home')}}" class="nav-link  fw-bold py-1 px-2 " aria-current="page">
                                <i class="fas fa-user-tie fa-lg ms-1"></i>
                                <span>{{__('front/labels.home')}}</span>
                            </a>
                    </li>

                    <li class="nav-item dropdown my-lg-auto bg-light border fw-bold rounded py-1 shadow my-sm-3 " style="min-width: auto ; width: max-content;">
                        <a class="nav-link dropdown-toggle text-muted mx-2 p-1" href="#" id="navbarScrollingDropdownLang" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <small>{{ strtoupper(App::getLocale()) }}</small>
                        </a>
                        <ul class="dropdown-menu rounded fw-bold pb-0 shadow dropdown-menu-center" aria-labelledby="navbarScrollingDropdownLang" style="min-width: auto ; width: max-content;">
                            @foreach($languages as $langs)
                                <a href="{{route('language.switch', $langs->abbr)}}" class="dropdown-item  mb-2 {{App::getLocale()  === $langs->abbr? 'active' : ''}}">{{__('front/labels.'. $langs->name)}}</a>
                            @endforeach
                        </ul>
                    </li>

                    <li class="nav-item d-lg-flex d-none bg-light border fw-bold rounded my-lg-auto shadow align-items-center" style="min-width: auto ; width: max-content;">
                        @auth('customers')
                            <a href="{{route('front.customers.index')}}" class="mx-2 px-0 nav-link">
                                <i class="fas fa-user-tie fa-lg"></i>
    {{--                            <i class="fa fa-home fa-lg "></i>--}}
                                <span>{{__('front/labels.hi')}} {{auth('customers')->user()->first_name .' '. auth('customers')->user()->last_name}}</span>
                            </a>

                            <a  class="nav-link p-lg-0 {{$lang==='ar'? 'me-2':'ms-2'}} align-items-center justify-content-center">
                                <form id="logout-form" action="{{ route('front.logout') }}" method="POST" >
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm-square shadow border bg-light rounded-circle px-2 mx-1">
                                        <span>
                                            <i class="fas fa-sign-out-alt fa-lg  text-danger" ></i>
                                        </span>
                                    </button>
                                </form>
                            </a>
                        @endauth

                        @guest('customers')
                            <a href="{{route('front.login.create')}}" class="nav-link">
                                <span>{{__('front/labels.sign_in')}}</span>
                            </a>
                        @endguest
                    </li>

                    <li class="nav-item " style="min-width: auto ; width: max-content;">
                        <a href="#" class="nav-link text-danger btn-md-square shadow border bg-light rounded-circle fw-bold px-2  pt-1" >
                            <span class="">
                                <i class="fas fa-heart fa-lg"></i>
                            </span>
                        </a>
                    </li>

                    <li class="nav-item  d-none d-lg-block position-relative " style="min-width: auto ; width: max-content;">
                        <a href="{{ route('front.cart') }}" class="nav-link text-dark btn btn-md-square rounded shadow border bg-light rounded-circle fw-bold px-2 pb-0 pt-2">
                        <span class=" ">
                            <i class="fas fa-shopping-cart fa-lg position-absolute" style="top: 50%; left: 20%;"></i>
                            <span class="position-absolute" id="cart-count2" style="color: #F28B00; font-weight: bold; bottom: 45%; right: 38%;">{{$cartCount}}</span>
                        </span>
                        </a>
                    </li>

    {{--                <li class="nav-item dropdown">--}}
    {{--                    <a class="nav-link dropdown-toggle" href="#" id="navbarScrollingDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">--}}
    {{--                        Link--}}
    {{--                    </a>--}}
    {{--                    <ul class="dropdown-menu" aria-labelledby="navbarScrollingDropdown">--}}
    {{--                        <li><a class="dropdown-item" href="#">Action</a></li>--}}
    {{--                        <li><a class="dropdown-item" href="#">Another action</a></li>--}}
    {{--                        <li><hr class="dropdown-divider"></li>--}}
    {{--                        <li><a class="dropdown-item" href="#">Something else here</a></li>--}}
    {{--                    </ul>--}}
    {{--                </li>--}}

                </ul>

            </div>

       </div>
    </div>
</nav>
















{{--<div class="container-fluid nav-bar p-0 mt-5">--}}
{{--    <div class="row gx-0 bg-primary pe-1 ps-2 align-items-center"  style="height: 5.5rem;">--}}
{{--        <div class="row col-lg-2 m-0 p-0 ps-3 d-none d-lg-block">--}}

{{--            <div class="col-md-12 text-lg-start bg-white">--}}
{{--                <div class="d-inline-flex align-items-center">--}}
{{--                    <a href="" class="navbar-brand p-0">--}}
{{--                        <h1 class="display-4 text-primary m-0"><i--}}
{{--                                class="fas fa-shopping-bag text-secondary me-2"></i>Electro</h1>--}}
{{--                        <!-- <img src="img/logo.png" alt="Logo"> -->--}}
{{--                    </a>--}}
{{--                </div>--}}
{{--            </div>--}}

{{--            <nav class="navbar navbar-light d-none position-relative" style="width: 250px;">--}}
{{--                <div class="collapse navbar-collapse rounded-bottom" id="allCat">--}}
{{--                    <div class="navbar-nav ms-auto py-0">--}}
{{--                        <ul class="list-unstyled categories-bars">--}}
{{--                            @foreach($categories as $cat)--}}
{{--                                <li>--}}
{{--                                    <div class="categories-bars-item">--}}
{{--                                        <a href="{{ route('front.category.show', $cat['slug']) }}">{{$cat['name']}}</a>--}}
{{--                                    </div>--}}
{{--                                </li>--}}

{{--                            @endforeach--}}
{{--                        </ul>--}}
{{--                    </div>--}}
{{--                </div>--}}

{{--                <button class="navbar-toggler border-0 fs-4 w-100 px-0 text-start" type="button"--}}
{{--                        data-bs-toggle="collapse" data-bs-target="#allCat">--}}
{{--                    <h4 class="m-0"><i class="fa fa-bars me-2"></i></h4>--}}
{{--                </button>--}}

{{--                <button class="navbar-toggler border-0 fs-4 w-100 px-0 text-start" type="button"--}}
{{--                        data-bs-toggle="collapse" data-bs-target="#allCat">--}}
{{--                    <h4 class="m-0"><i class="fa fa-bars me-2"></i>{{ isset($category) && Route::is('front.category.show') ? $category['name'] : 'All Categories' }}</h4>--}}
{{--                </button>--}}

{{--            </nav>--}}
{{--        </div>--}}
{{--        <div class="col-12 col-lg-10">--}}
{{--            <nav class="navbar navbar-expand-lg navbar-light bg-primary ">--}}
{{--                <a href="" class="navbar-brand d-block d-lg-none">--}}
{{--                    <h1 class="display-5 text-secondary m-0"><i--}}
{{--                            class="fas fa-shopping-bag text-white me-2"></i>Electro</h1>--}}
{{--                    <!-- <img src="img/logo.png" alt="Logo"> -->--}}
{{--                </a>--}}
{{--                <button class="navbar-toggler ms-auto" type="button" data-bs-toggle="collapse"--}}
{{--                        data-bs-target="#navbarCollapse">--}}
{{--                    <span class="fa fa-bars fa-1x"></span>--}}
{{--                </button>--}}


{{--                <div class="collapse navbar-collapse" id="navbarCollapse">--}}
{{--                    <div class="navbar-nav w-100 py-0">--}}

{{--                        <div class="row w-100 m-0 p-0 align-items-center ">--}}

{{--                            <div class="col-md-7  text-center ">--}}
{{--                                <div class="position-relative ps-4">--}}

{{--                                    <form method="GET" action="{{ route('front.products.search') }}">--}}
{{--                                        @csrf--}}
{{--                                        <div class="d-flex border rounded-pill bg-white">--}}
{{--                                            <input class="form-control border-0 rounded-pill w-100 py-3" type="text"--}}
{{--                                                   data-bs-target="#dropdownToggle123" placeholder="Search Looking For?" name="searchTerm">--}}
{{--                                            <select class="form-select text-dark border-0 border-start rounded-0 p-3" style="width: 200px;" name="categoryId">--}}

{{--                                                <option value="">All Category</option>--}}
{{--                                                @foreach($categories as $category)--}}
{{--                                                    <option value="{{$category['category_id']}}">{{$category['name']}}</option>--}}
{{--                                                @endforeach--}}
{{--                                            </select>--}}

{{--                                            <button type="submit" class="btn btn-primary rounded-pill py-3 px-5" style="border: 0;"><i--}}
{{--                                                    class="fas fa-search"></i>--}}
{{--                                            </button>--}}

{{--                                        </div>--}}
{{--                                    </form>--}}

{{--                                </div>--}}
{{--                            </div>--}}

{{--                            <div class="col-md-5  text-center text-lg-end bg-white">--}}
{{--                                <div class="d-inline-flex  align-items-center">--}}
{{--                                    <a href="{{route('front.home')}}" class="nav-item nav-link active text-primary">Home</a>--}}

{{--                                </div>--}}
{{--                                <div class="d-inline-flex align-items-center" style="height: 45px;">--}}
{{--                                                    <div class="dropdown">--}}
{{--                                                        <a href="#" class="dropdown-toggle text-muted me-2" data-bs-toggle="dropdown"><small>--}}
{{--                                                                USD</small></a>--}}
{{--                                                        <div class="dropdown-menu rounded">--}}
{{--                                                            <a href="#" class="dropdown-item"> Euro</a>--}}
{{--                                                            <a href="#" class="dropdown-item"> Dolar</a>--}}
{{--                                                        </div>--}}
{{--                                                    </div>--}}

{{--                                    <div class="dropdown">--}}
{{--                                        <a href="#" class="dropdown-toggle text-muted mx-2" data-bs-toggle="dropdown">--}}
{{--                                            <small>{{ strtoupper(App::getLocale()) }}</small>--}}
{{--                                        </a>--}}
{{--                                        <div class="dropdown-menu rounded">--}}
{{--                                            @foreach($languages as $lang)--}}
{{--                                                <a href="{{route('language.switch', $lang->abbr)}}" class="dropdown-item {{App::getLocale()  === $lang->abbr? 'active' : ''}}">{{$lang->name}}</a>--}}
{{--                                            @endforeach--}}
{{--                                        </div>--}}
{{--                                    </div>--}}

{{--                                                    <div class="dropdown">--}}
{{--                                                        <a href="#" class="dropdown-toggle text-muted ms-2" data-bs-toggle="dropdown"><small><i--}}
{{--                                                                    class="fa fa-home me-2"></i> My Dashboard</small></a>--}}
{{--                                                        <div class="dropdown-menu rounded">--}}
{{--                                                            <a href="#" class="dropdown-item"> Login</a>--}}
{{--                                                            <a href="#" class="dropdown-item"> Wishlist</a>--}}
{{--                                                            <a href="#" class="dropdown-item"> My Card</a>--}}
{{--                                                            <a href="#" class="dropdown-item"> Notifications</a>--}}
{{--                                                            <a href="#" class="dropdown-item"> Account Settings</a>--}}
{{--                                                            <a href="#" class="dropdown-item"> My Account</a>--}}
{{--                                                            <a href="#" class="dropdown-item"> Log Out</a>--}}
{{--                                                        </div>--}}
{{--                                                    </div>--}}

{{--                                </div>--}}
{{--                                <div class="d-inline-flex  align-items-center">--}}

{{--                                    @auth('customers')--}}
{{--                                        <a href="{{route('front.customers.index')}}" class="ms-3 ">--}}
{{--                                            <i class="fas fa-user-tie fs-4"></i>--}}
{{--                                                                    <i class="fa fa-home fa-lg "></i>--}}
{{--                                            <span>Hi {{auth('customers')->user()->first_name .' '. auth('customers')->user()->last_name}}</span>--}}
{{--                                        </a>--}}

{{--                                        <a  class=" d-flex align-items-center justify-content-center mx-3">--}}
{{--                                            <form id="logout-form" action="{{ route('front.logout') }}" method="POST" >--}}
{{--                                                @csrf--}}
{{--                                                @method('DELETE')--}}
{{--                                                <button class="btn btn-link text-muted">--}}
{{--                                    <span--}}
{{--                                        class="rounded-circle btn-md-square border"><i class="fas fa-sign-out-alt fa-lg" style="color: #F28B00;"></i>--}}
{{--                                    </span>--}}
{{--                                                </button>--}}
{{--                                            </form>--}}
{{--                                        </a>--}}
{{--                                    @endauth--}}

{{--                                    @guest('customers')--}}
{{--                                        <a href="{{route('front.login.create')}}" class="me-3 ">--}}
{{--                                            <span>Sign In</span>--}}
{{--                                        </a>--}}
{{--                                    @endguest--}}

{{--                                    <a href="#" class="text-muted d-flex align-items-center justify-content-center me-3"><span--}}
{{--                                            class="rounded-circle btn-md-square border"><i class="fas fa-heart"></i></a>--}}

{{--                                    <a href="{{  route('front.cart')  }}" class="text-muted d-flex align-items-center justify-content-center">--}}
{{--                    <span class=" rounded-circle btn-lg-square border">--}}
{{--                        <i class="fas fa-shopping-cart fa-lg"></i>--}}
{{--                    <span class="ms-1" id="cart-count" style="color: #F28B00; font-weight: bold">{{$cartCount}}</span>--}}

{{--                    </span>--}}

{{--                                    </a>--}}
{{--                                </div>--}}
{{--                            </div>--}}

{{--                        </div>--}}

{{--                        <div class="nav-item dropdown d-block d-lg-none mb-3">--}}
{{--                            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">All Category</a>--}}
{{--                            <div class="dropdown-menu m-0">--}}
{{--                                <ul class="list-unstyled categories-bars">--}}
{{--                                    <li>--}}
{{--                                        <div class="categories-bars-item">--}}
{{--                                            <a href="#">Accessories</a>--}}
{{--                                            <span>(3)</span>--}}
{{--                                        </div>--}}
{{--                                    </li>--}}
{{--                                    <li>--}}
{{--                                        <div class="categories-bars-item">--}}
{{--                                            <a href="#">Electronics & Computer</a>--}}
{{--                                            <span>(5)</span>--}}
{{--                                        </div>--}}
{{--                                    </li>--}}
{{--                                    <li>--}}
{{--                                        <div class="categories-bars-item">--}}
{{--                                            <a href="#">Laptops & Desktops</a>--}}
{{--                                            <span>(2)</span>--}}
{{--                                        </div>--}}
{{--                                    </li>--}}
{{--                                    <li>--}}
{{--                                        <div class="categories-bars-item">--}}
{{--                                            <a href="#">Mobiles & Tablets</a>--}}
{{--                                            <span>(8)</span>--}}
{{--                                        </div>--}}
{{--                                    </li>--}}
{{--                                    <li>--}}
{{--                                        <div class="categories-bars-item">--}}
{{--                                            <a href="#">SmartPhone & Smart TV</a>--}}
{{--                                            <span>(5)</span>--}}
{{--                                        </div>--}}
{{--                                    </li>--}}
{{--                                </ul>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}




{{--                <div class="collapse navbar-collapse" id="navbarCollapse">--}}
{{--                    <div class="navbar-nav ms-auto py-0">--}}
{{--                        <a href="{{route('front.home')}}" class="nav-item nav-link active">Home</a>--}}
{{--                        <a href="{{asset('assets/front/shop.html')}}" class="nav-item nav-link">Shop</a>--}}
{{--                        <a href="{{asset('assets/front/single.html')}}" class="nav-item nav-link">Single Page</a>--}}
{{--                        <div class="nav-item dropdown">--}}
{{--                            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Pages</a>--}}
{{--                            <div class="dropdown-menu m-0">--}}
{{--                                <a href="{{asset('assets/front/bestseller.html')}}" class="dropdown-item">Bestseller</a>--}}
{{--                                <a href="{{asset('assets/front/cart.html')}}" class="dropdown-item">Cart Page</a>--}}
{{--                                <a href="{{asset('assets/front/cheackout.html')}}" class="dropdown-item">Cheackout</a>--}}
{{--                                <a href="{{asset('assets/front/404.html')}}" class="dropdown-item">404 Page</a>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <a href="{{asset('assets/front/contact.html')}}" class="nav-item nav-link me-2">Contact</a>--}}
{{--                        <div class="nav-item dropdown d-block d-lg-none mb-3">--}}
{{--                            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">All Category</a>--}}
{{--                            <div class="dropdown-menu m-0">--}}
{{--                                <ul class="list-unstyled categories-bars">--}}
{{--                                    <li>--}}
{{--                                        <div class="categories-bars-item">--}}
{{--                                            <a href="#">Accessories</a>--}}
{{--                                            <span>(3)</span>--}}
{{--                                        </div>--}}
{{--                                    </li>--}}
{{--                                    <li>--}}
{{--                                        <div class="categories-bars-item">--}}
{{--                                            <a href="#">Electronics & Computer</a>--}}
{{--                                            <span>(5)</span>--}}
{{--                                        </div>--}}
{{--                                    </li>--}}
{{--                                    <li>--}}
{{--                                        <div class="categories-bars-item">--}}
{{--                                            <a href="#">Laptops & Desktops</a>--}}
{{--                                            <span>(2)</span>--}}
{{--                                        </div>--}}
{{--                                    </li>--}}
{{--                                    <li>--}}
{{--                                        <div class="categories-bars-item">--}}
{{--                                            <a href="#">Mobiles & Tablets</a>--}}
{{--                                            <span>(8)</span>--}}
{{--                                        </div>--}}
{{--                                    </li>--}}
{{--                                    <li>--}}
{{--                                        <div class="categories-bars-item">--}}
{{--                                            <a href="#">SmartPhone & Smart TV</a>--}}
{{--                                            <span>(5)</span>--}}
{{--                                        </div>--}}
{{--                                    </li>--}}
{{--                                </ul>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <a href="" class="btn btn-secondary rounded-pill py-2 px-4 px-lg-3 mb-3 mb-md-3 mb-lg-0"><i--}}
{{--                            class="fa fa-mobile-alt me-2"></i> +0123 456 7890</a>--}}
{{--                </div>--}}

{{--            </nav>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}
<!-- Navbar & Hero End -->
