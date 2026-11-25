<aside class="sidebar-left border-right bg-white shadow" id="leftSidebar" data-simplebar>
    <div class="d-lg-none w-100 p-3">
        <a href="#" class="collapseSidebar text-muted" data-toggle="toggle">
            <i class="fe fe-x fe-24"></i>
        </a>
    </div>


    <nav class="vertnav navbar navbar-light">

        <ul class="navbar-nav flex-fill w-100 mb-2 " >
            {{-- Check if we are in the languages section --}}
            @php
                $host = Request::host();
            @endphp
{{--            @dd($host.'/categories')--}}
            {{-- Check if we are in the languages section --}}
                <a href="{{route('dashboard')}}"   class=" nav-link navbar-brand d-flex mr-3 " >
                            <svg version="1.1" id="logo" class="navbar-brand-img  " xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="8 0 100 140" xml:space="preserve" style="width: 3rem!important;">
                            <g >
                                <polygon class="st0" points="78,105 15,105 24,87 87,87 	" />
                                <polygon class="st0" points="96,69 33,69 42,51 105,51 	" />
                                <polygon class="st0" points="78,33 15,33 24,15 87,15 	" />
                            </g>
                          </svg>

                    <div class="d-flex justify-content-between align-items-center w-100 ml-4">
                        <span class="item-text " style="font-size: 2rem;">{{__('admin/labels.dashboard')}}</span>
                    </div>
                    <span class="sr-only">(current)</span>
                </a>
        </ul>

{{--================================================================================================================--}}
{{--================================================================================================================--}}
      {{-- Check if we are in the Product Catalog section --}}
        @php
            $isCategoryShow  = Request::is('categories');
            $isCategoryAdd   = Request::is('categories/create');
            $isBrandShow     = Request::is('brands');
            $isBrandAdd      = Request::is('brands/create');
            $isProductShow   = Request::is('products');
            $isProductAdd    = Request::is('products/create');
            $isAttributeShow = Request::is('attributes');
            $isAttributeAdd  = Request::is('attributes/create');
            $isColorShow = Request::is('colors');
            $isColorAdd  = Request::is('colors/create');
        @endphp
      {{-- Check if we are in the Product Catalog section --}}
        <ul class="navbar-nav flex-fill w-100 mb-2" >
            <li class="nav-item dropdown">

                <a href="#productCatalog" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle nav-link d-flex align-items-center">
                    <i class="fe fe-home fe-16"></i>
                    <div class="d-flex justify-content-between align-items-center w-100 ml-3">
                        <span class="item-text">{{__('admin/labels.products_catalog')}}</span>
                        {{--                        <span class="badge badge-pill badge-primary mr-3 pt-1">--}}
                        {{--                              {{ App\Models\Role::count() }}--}}
                        {{--                        </span>--}}
                    </div>
                    <span class="sr-only">(current)</span>
                </a>

                <ul class="collapse list-unstyled pl-0 mr-4 {{ ($isCategoryShow || $isCategoryAdd || $isBrandShow || $isBrandAdd ||$isProductShow || $isProductAdd || $isAttributeShow || $isAttributeAdd || $isColorShow || $isColorAdd) ? 'show' : '' }}" id="productCatalog" style="width: 90%;" >

                    <li class="nav-item dropdown"  @style([
                            'background-color: rgba(209,209,209,0.2)' => $isCategoryShow || $isCategoryAdd,
                            'border-radius: 3%' => $isCategoryShow || $isCategoryAdd,
                    ]) >

                        <a href="#categories" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle nav-link d-flex align-items-center">
                            <i class="fe fe-home fe-16"></i>
                            <div class="d-flex justify-content-between align-items-center w-100 ml-3">
                                <span class="item-text">{{__('admin/labels.categories')}}</span>
                                <span class="badge badge-pill badge-primary mr-3 pt-1">
                              {{ App\Models\Category::count() }}
                        </span>
                            </div>
                            <span class="sr-only">(current)</span>
                        </a>

                        <ul class="collapse list-unstyled pl-4 w-100 {{ ($isCategoryShow || $isCategoryAdd) ? 'show' : '' }}" id="categories">
                            <li class="nav-item active ">
                                <a class="nav-link pl-3 {{ $isCategoryShow ? 'text-primary' : '' }}" href="{{ route('admin.categories.index') }}"><span class="ml-1 item-text">{{__('admin/labels.show_all')}}</span></a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link pl-3 {{ $isCategoryAdd ? 'text-primary' : '' }}" href="{{ route('admin.categories.create') }}"><span class="ml-1 item-text">{{__('admin/labels.add_category')}}</span></a>
                            </li>

                        </ul>
                    </li>


                    <li class="nav-item dropdown" @style([
                        'background-color: rgba(209,209,209,0.2)' => $isBrandShow || $isBrandAdd,
                        'border-radius: 3%' => $isBrandShow || $isBrandAdd,
                    ])>

                        <a href="#brands" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle nav-link d-flex align-items-center">
                            <i class="fe fe-home fe-16"></i>
                            <div class="d-flex justify-content-between align-items-center w-100 ml-3">
                                <span class="item-text">{{__('admin/labels.brands')}}</span>
                                <span class="badge badge-pill badge-primary mr-3 pt-1">
                              {{ App\Models\Brand::count() }}
                        </span>
                            </div>
                            <span class="sr-only">(current)</span>
                        </a>

                        <ul class="collapse list-unstyled pl-4 w-100 {{ ($isBrandShow || $isBrandAdd) ? 'show' : '' }}" id="brands">
                            <li class="nav-item active ">
                                <a class="nav-link pl-3 {{ $isBrandShow ? 'text-primary' : '' }}" href="{{ route('admin.brands.index') }}"><span class="ml-1 item-text">{{__('admin/labels.show_all')}}</span></a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link pl-3 {{ $isBrandAdd ? 'text-primary' : '' }}" href="{{ route('admin.brands.create') }}"><span class="ml-1 item-text">{{__('admin/labels.add_brand')}}</span></a>
                            </li>

                        </ul>
                    </li>


                    <li class="nav-item dropdown" @style([
                        'background-color: rgba(209,209,209,0.2)' => $isProductShow || $isProductAdd,
                        'border-radius: 3%' => $isProductShow || $isProductAdd,
                    ]) >

                        <a href="#products" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle nav-link d-flex align-items-center">
                            <i class="fe fe-home fe-16"></i>
                            <div class="d-flex justify-content-between align-items-center w-100 ml-3">
                                <span class="item-text">{{__('admin/labels.products')}}</span>
                                <span class="badge badge-pill badge-primary mr-3 pt-1">
                              {{ App\Models\Product::count() }}
                        </span>
                            </div>
                            <span class="sr-only">(current)</span>
                        </a>

                        <ul class="collapse list-unstyled pl-4 w-100 {{ ($isProductShow || $isProductAdd) ? 'show' : '' }}" id="products">
                            <li class="nav-item active ">
                                <a class="nav-link pl-3 {{ $isProductShow ? 'text-primary' : '' }}" href="{{ route('admin.products.index') }}"><span class="ml-1 item-text">{{__('admin/labels.show_all')}}</span></a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link pl-3 {{ $isProductAdd ? 'text-primary' : '' }}" href="{{ route('admin.products.create') }}"><span class="ml-1 item-text">{{__('admin/labels.add_product')}}</span></a>
                            </li>

                        </ul>
                    </li>


                    <li class="nav-item dropdown" @style([
                        'background-color: rgba(209,209,209,0.2)' => $isAttributeShow || $isAttributeAdd,
                        'border-radius: 3%' => $isAttributeShow || $isAttributeAdd,
                    ])>

                        <a href="#attributes" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle nav-link d-flex align-items-center">
                            <i class="fe fe-home fe-16"></i>
                            <div class="d-flex justify-content-between align-items-center w-100 ml-3">
                                <span class="item-text">{{__('admin/labels.attributes')}}</span>
                                <span class="badge badge-pill badge-primary mr-3 pt-1">
                              {{ App\Models\Attribute::count() }}
                        </span>
                            </div>
                            <span class="sr-only">(current)</span>
                        </a>

                        <ul class="collapse list-unstyled pl-4 w-100 {{ ($isAttributeShow || $isAttributeAdd) ? 'show' : '' }}" id="attributes">
                            <li class="nav-item active ">
                                <a class="nav-link pl-3 {{ $isAttributeShow ? 'text-primary' : '' }}" href="{{ route('admin.attributes.index') }}"><span class="ml-1 item-text">{{__('admin/labels.show_all')}}</span></a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link pl-3 {{ $isAttributeAdd ? 'text-primary' : '' }}" href="{{ route('admin.attributes.create') }}"><span class="ml-1 item-text">{{__('admin/labels.add_attribute')}}</span></a>
                            </li>

                        </ul>
                    </li>


                    <li class="nav-item dropdown"  @style([
                            'background-color: rgba(209,209,209,0.2)' => $isColorShow || $isColorAdd,
                            'border-radius: 3%' => $isColorShow || $isColorAdd,
                    ]) >

                        <a href="#colors" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle nav-link d-flex align-items-center">
                            <i class="fe fe-home fe-16"></i>
                            <div class="d-flex justify-content-between align-items-center w-100 ml-3">
                                <span class="item-text">{{__('admin/labels.colors')}}</span>
                                <span class="badge badge-pill badge-primary mr-3 pt-1">
                              {{ App\Models\Color::count() }}
                        </span>
                            </div>
                            <span class="sr-only">(current)</span>
                        </a>

                        <ul class="collapse list-unstyled pl-4 w-100 {{ ($isColorShow || $isColorAdd) ? 'show' : '' }}" id="colors">
                            <li class="nav-item active ">
                                <a class="nav-link pl-3 {{ $isCategoryShow ? 'text-primary' : '' }}" href="{{ route('admin.colors.index') }}"><span class="ml-1 item-text">{{__('admin/labels.show_all')}}</span></a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link pl-3 {{ $isCategoryAdd ? 'text-primary' : '' }}" href="{{ route('admin.colors.create') }}"><span class="ml-1 item-text">{{__('admin/labels.add_color')}}</span></a>
                            </li>

                        </ul>
                    </li>

                </ul>

            </li>
        </ul>
{{--================================================================================================================--}}
{{--================================================================================================================--}}


        <ul class="navbar-nav flex-fill w-100 mb-2" >
            {{-- Check if we are in the languages section --}}
            @php
                $isLanguageShow = Request::is('languages');
                $isLanguageAdd  = Request::is('languages/create');
            @endphp
            {{-- Check if we are in the languages section --}}

            <li class="nav-item dropdown">
                <a href="#languages" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle nav-link d-flex align-items-center">
                    <i class="fe fe-home fe-16 mb-1 lead"></i>
                    <div class="d-flex justify-content-between align-items-center w-100 ml-3">
                        <span class="item-text  mt-1 lead">{{__('admin/labels.languages')}}</span>
                        <span class="badge badge-pill badge-primary mr-3 pt-1">
                              {{ App\Models\Language::count() }}
                        </span>
                    </div>
                    <span class="sr-only">(current)</span>
                </a>

                <ul class="collapse list-unstyled pl-4 w-100 {{ ($isLanguageShow || $isLanguageAdd) ? 'show' : '' }}" id="languages">
                    <li class="nav-item active ">
                        <a class="nav-link pl-3 {{ $isLanguageShow ? 'text-primary' : '' }}" href="{{ route('admin.languages.index') }}"><span class="ml-1 item-text">{{__('admin/labels.show_all')}}</span></a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link pl-3 {{ $isLanguageAdd ? 'text-primary' : '' }}" href="{{ route('admin.languages.create') }}"><span class="ml-1 item-text">{{__('admin/labels.add_language')}}</span></a>
                    </li>
                </ul>
            </li>
        </ul>

{{--================================================================================================================--}}
        @php
            $isCampaignShow = Request::is('campaigns');
            $isCampaignAdd  = Request::is('campaigns/create');
        @endphp
        <ul class="navbar-nav flex-fill w-100 mb-2"
            @style([
                'background-color: rgba(209,209,209,0.2)' => $isCampaignShow,
                'border-radius: 3%' => $isCampaignShow,
            ])>

            <li class="nav-item dropdown">

                <a href="#campaigns" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle nav-link d-flex align-items-center">
                    <i class="fe fe-home fe-16"></i>
                    <div class="d-flex justify-content-between align-items-center w-100 ml-3">
                        <span class="item-text">{{__('admin/labels.campaigns')}}</span>
                        <span class="badge badge-pill badge-primary mr-3 pt-1">
                              {{ App\Models\Campaign::count() }}
                        </span>
                    </div>
                    <span class="sr-only">(current)</span>
                </a>

                <ul class="collapse list-unstyled pl-4 w-100 {{ ($isCampaignShow || $isCampaignAdd) ? 'show' : '' }}" id="campaigns">
                    <li class="nav-item active ">
                        <a class="nav-link pl-3 {{ $isCampaignShow ? 'text-primary' : '' }}" href="{{ route('admin.campaigns.index') }}"><span class="ml-1 item-text">{{__('admin/labels.show_all')}}</span></a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link pl-3 {{ $isCampaignAdd ? 'text-primary' : '' }}" href="{{ route('admin.campaigns.create') }}"><span class="ml-1 item-text">{{__('admin/labels.add_campaign')}}</span></a>
                    </li>

                </ul>
            </li>
        </ul>


        <ul class="navbar-nav flex-fill w-100 mb-2" >

            {{-- Check if we are in the languages section --}}
            @php
                $isCouponShow = Request::is('coupons');
                $isCouponAdd  = Request::is('coupons/create');
            @endphp
            {{-- Check if we are in the languages section --}}

            <li class="nav-item dropdown">

                <a href="#coupons" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle nav-link d-flex align-items-center">
                    <i class="fe fe-home fe-16"></i>
                    <div class="d-flex justify-content-between align-items-center w-100 ml-3">
                        <span class="item-text">{{__('admin/labels.coupons')}}</span>
                        <span class="badge badge-pill badge-primary mr-3 pt-1">
                              {{ App\Models\Coupon::count() }}
                        </span>
                    </div>
                    <span class="sr-only">(current)</span>
                </a>

                <ul class="collapse list-unstyled pl-4 w-100 {{ ($isCouponShow || $isCouponAdd) ? 'show' : '' }}" id="coupons">
                    <li class="nav-item active ">
                        <a class="nav-link pl-3 {{ $isCouponShow ? 'text-primary' : '' }}" href="{{ route('admin.coupons.index') }}"><span class="ml-1 item-text">{{__('admin/labels.show_all')}}</span></a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link pl-3 {{ $isCouponAdd ? 'text-primary' : '' }}" href="{{ route('admin.coupons.create') }}"><span class="ml-1 item-text">{{__('admin/labels.add_coupon')}}</span></a>
                    </li>

                </ul>
            </li>
        </ul>


        <ul class="navbar-nav flex-fill w-100 mb-2" >

            {{-- Check if we are in the languages section --}}
            @php
                $isRoleShow = Request::is('roles');
                $isRoleAdd  = Request::is('roles/create');
                $isPermissionAdd  = Request::is('permissions/create');
                $isAdminShow = Request::is('admins');
                $isAdminAdd  = Request::is('admins/create');
            @endphp
            {{-- Check if we are in the languages section --}}

            <li class="nav-item dropdown">

                <a href="#adminsManagement" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle nav-link d-flex align-items-center">
                    <i class="fe fe-home fe-16"></i>
                    <div class="d-flex justify-content-between align-items-center w-100 ml-3">
                        <span class="item-text">{{__('admin/labels.admins_management')}}</span>
{{--                        <span class="badge badge-pill badge-primary mr-3 pt-1">--}}
{{--                              {{ App\Models\Role::count() }}--}}
{{--                        </span>--}}
                    </div>
                    <span class="sr-only">(current)</span>
                </a>

                <ul class="collapse list-unstyled pl-0 mr-4 {{ ($isRoleShow || $isRoleAdd || $isPermissionAdd || $isAdminShow || $isAdminAdd) ? 'show' : '' }}" id="adminsManagement" style="width: 90%;">
                    <li class="nav-item dropdown">

                        <a href="#rolesPermissions" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle nav-link d-flex align-items-center">
                            <i class="fe fe-home fe-16"></i>
                            <div class="d-flex justify-content-between align-items-center w-100 ml-3">
                                <span class="item-text">{{__('admin/labels.roles_and_permissions')}}</span>
                                <span class="badge badge-pill badge-primary mr-3 pt-1">
                              {{ App\Models\Role::count() }}
                        </span>
                            </div>
                            <span class="sr-only">(current)</span>
                        </a>

                        <ul class="collapse list-unstyled pl-4 w-100 {{ ($isRoleShow || $isPermissionAdd || $isRoleAdd) ? 'show' : '' }}" id="rolesPermissions">
                            <li class="nav-item active ">
                                <a class="nav-link pl-3 {{ $isRoleShow ? 'text-primary' : '' }}" href="{{ route('admin.roles.index') }}"><span class="ml-1 item-text">{{__('admin/labels.show_all')}}</span></a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link pl-3 {{ $isPermissionAdd ? 'text-primary' : '' }}" href="{{ route('admin.permissions.create') }}"><span class="ml-1 item-text">{{__('admin/labels.add_permission')}}</span></a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link pl-3 {{ $isRoleAdd ? 'text-primary' : '' }}" href="{{ route('admin.roles.create') }}"><span class="ml-1 item-text">{{__('admin/labels.add_role')}}</span></a>
                            </li>

                        </ul>
                    </li>


                    <li class="nav-item dropdown">

                        <a href="#admins" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle nav-link d-flex align-items-center">
                            <i class="fe fe-home fe-16"></i>
                            <div class="d-flex justify-content-between align-items-center w-100 ml-3">
                                <span class="item-text">{{__('admin/labels.admins')}}</span>
                                <span class="badge badge-pill badge-primary mr-3 pt-1">
                              {{ App\Models\Admin::count() }}
                        </span>
                            </div>
                            <span class="sr-only">(current)</span>
                        </a>

                        <ul class="collapse list-unstyled pl-4 w-100 {{ ($isAdminShow || $isAdminAdd) ? 'show' : '' }}" id="admins">
                            <li class="nav-item active ">
                                <a class="nav-link pl-3 {{ $isAdminShow ? 'text-primary' : '' }}" href="{{ route('admin.admins.index') }}"><span class="ml-1 item-text">{{__('admin/labels.show_all')}}</span></a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link pl-3 {{ $isAdminAdd ? 'text-primary' : '' }}" href="{{ route('admin.admins.create') }}"><span class="ml-1 item-text">{{__('admin/labels.add_admin')}}</span></a>
                            </li>

                        </ul>
                    </li>

                </ul>

            </li>
        </ul>


{{--        <ul class="navbar-nav flex-fill w-100 mb-2" >--}}

{{--            --}}{{-- Check if we are in the languages section --}}
{{--            @php--}}
{{--                $isDiscountShow = Request::is('admin/discounts');--}}
{{--                $isDiscountAdd  = Request::is('admin/discounts/create');--}}
{{--            @endphp--}}
{{--            --}}{{-- Check if we are in the languages section --}}

{{--            <li class="nav-item dropdown">--}}

{{--                <a href="#discounts" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle nav-link d-flex align-items-center">--}}
{{--                    <i class="fe fe-home fe-16"></i>--}}
{{--                    <div class="d-flex justify-content-between align-items-center w-100 ml-3">--}}
{{--                        <span class="item-text">الخصومات</span>--}}
{{--                        <span class="badge badge-pill badge-primary mr-3 pt-1">--}}
{{--                              {{ App\Models\Discount::count() }}--}}
{{--                        </span>--}}
{{--                    </div>--}}
{{--                    <span class="sr-only">(current)</span>--}}
{{--                </a>--}}

{{--                <ul class="collapse list-unstyled pl-4 w-100 {{ ($isDiscountShow || $isDiscountAdd) ? 'show' : '' }}" id="discounts">--}}
{{--                    <li class="nav-item active ">--}}
{{--                        <a class="nav-link pl-3 {{ $isDiscountShow ? 'text-primary' : '' }}" href="{{ route('admin.discounts.index') }}"><span class="ml-1 item-text">أظهار الكل</span></a>--}}
{{--                    </li>--}}

{{--                    <li class="nav-item">--}}
{{--                        <a class="nav-link pl-3 {{ $isDiscountAdd ? 'text-primary' : '' }}" href="{{ route('admin.discounts.create') }}"><span class="ml-1 item-text">إضافة خصم</span></a>--}}
{{--                    </li>--}}

{{--                </ul>--}}
{{--            </li>--}}
{{--        </ul>--}}

        <ul class="navbar-nav flex-fill w-100 mb-2" >

            {{-- Check if we are in the languages section --}}
            @php
                $isOrderShow = Request::is('orders');
                $isOrderAdd  = Request::is('orders/create');
//                $isAttributeAddValue  = Request::is('admin/attributes/create-value');
            @endphp
            {{-- Check if we are in the languages section --}}

            <li class="nav-item dropdown">

                <a href="#orders" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle nav-link d-flex align-items-center">
                    <i class="fe fe-home fe-16"></i>
                    <div class="d-flex justify-content-between align-items-center w-100 ml-3">
                        <span class="item-text">{{__('admin/labels.orders')}}</span>
                        <span class="badge badge-pill badge-primary mr-3 pt-1">
                              {{ App\Models\Order::count() }}
                        </span>
                    </div>
                    <span class="sr-only">(current)</span>
                </a>

                <ul class="collapse list-unstyled pl-4 w-100 {{ ($isOrderShow || $isOrderAdd) ? 'show' : '' }}" id="orders">
                    <li class="nav-item active ">
                        <a class="nav-link pl-3 {{ $isOrderShow ? 'text-primary' : '' }}" href="{{ route('admin.orders.index') }}"><span class="ml-1 item-text">{{__('admin/labels.show_all')}}</span></a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link pl-3 {{ $isOrderAdd ? 'text-primary' : '' }}" href="{{ route('admin.orders.create') }}"><span class="ml-1 item-text">{{__('admin/labels.add_order')}}</span></a>
                    </li>

                </ul>
            </li>
        </ul>



{{--        <ul class="navbar-nav flex-fill w-100 mb-2">--}}
{{--            <li class="nav-item dropdown">--}}
{{--                <a href="#ui-elements" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle nav-link">--}}
{{--                    <i class="fe fe-box fe-16"></i>--}}
{{--                    <span class="ml-3 item-text">UI elements</span>--}}
{{--                </a>--}}
{{--                <ul class="collapse list-unstyled pl-4 w-100" id="ui-elements">--}}
{{--                    <li class="nav-item">--}}
{{--                        <a class="nav-link pl-3" href="./ui-color.html"><span class="ml-1 item-text">Colors</span>--}}
{{--                        </a>--}}
{{--                    </li>--}}
{{--                    <li class="nav-item">--}}
{{--                        <a class="nav-link pl-3" href="./ui-typograpy.html"><span class="ml-1 item-text">Typograpy</span></a>--}}
{{--                    </li>--}}
{{--                    <li class="nav-item">--}}
{{--                        <a class="nav-link pl-3" href="./ui-icons.html"><span class="ml-1 item-text">Icons</span></a>--}}
{{--                    </li>--}}
{{--                    <li class="nav-item">--}}
{{--                        <a class="nav-link pl-3" href="./ui-buttons.html"><span class="ml-1 item-text">Buttons</span></a>--}}
{{--                    </li>--}}
{{--                    <li class="nav-item">--}}
{{--                        <a class="nav-link pl-3" href="./ui-notification.html"><span class="ml-1 item-text">Notifications</span></a>--}}
{{--                    </li>--}}
{{--                    <li class="nav-item">--}}
{{--                        <a class="nav-link pl-3" href="./ui-modals.html"><span class="ml-1 item-text">Modals</span></a>--}}
{{--                    </li>--}}
{{--                    <li class="nav-item">--}}
{{--                        <a class="nav-link pl-3" href="./ui-tabs-accordion.html"><span class="ml-1 item-text">Tabs & Accordion</span></a>--}}
{{--                    </li>--}}
{{--                    <li class="nav-item">--}}
{{--                        <a class="nav-link pl-3" href="./ui-progress.html"><span class="ml-1 item-text">Progress</span></a>--}}
{{--                    </li>--}}
{{--                </ul>--}}
{{--            </li>--}}
{{--            <li class="nav-item w-100">--}}
{{--                <a class="nav-link" href="widgets.html">--}}
{{--                    <i class="fe fe-layers fe-16"></i>--}}
{{--                    <span class="ml-3 item-text">Widgets</span>--}}
{{--                    <span class="badge badge-pill badge-primary">New</span>--}}
{{--                </a>--}}
{{--            </li>--}}
{{--            <li class="nav-item dropdown">--}}
{{--                <a href="#forms" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle nav-link">--}}
{{--                    <i class="fe fe-credit-card fe-16"></i>--}}
{{--                    <span class="ml-3 item-text">Forms</span>--}}
{{--                </a>--}}
{{--                <ul class="collapse list-unstyled pl-4 w-100" id="forms">--}}
{{--                    <li class="nav-item">--}}
{{--                        <a class="nav-link pl-3" href="./form_elements.html"><span class="ml-1 item-text">Basic Elements</span></a>--}}
{{--                    </li>--}}
{{--                    <li class="nav-item">--}}
{{--                        <a class="nav-link pl-3" href="./form_advanced.html"><span class="ml-1 item-text">Advanced Elements</span></a>--}}
{{--                    </li>--}}
{{--                    <li class="nav-item">--}}
{{--                        <a class="nav-link pl-3" href="./form_validation.html"><span class="ml-1 item-text">Validation</span></a>--}}
{{--                    </li>--}}
{{--                    <li class="nav-item">--}}
{{--                        <a class="nav-link pl-3" href="./form_wizard.html"><span class="ml-1 item-text">Wizard</span></a>--}}
{{--                    </li>--}}
{{--                    <li class="nav-item">--}}
{{--                        <a class="nav-link pl-3" href="./form_layouts.html"><span class="ml-1 item-text">Layouts</span></a>--}}
{{--                    </li>--}}
{{--                    <li class="nav-item">--}}
{{--                        <a class="nav-link pl-3" href="./form_upload.html"><span class="ml-1 item-text">File upload</span></a>--}}
{{--                    </li>--}}
{{--                </ul>--}}
{{--            </li>--}}
{{--            <li class="nav-item dropdown">--}}
{{--                <a href="#tables" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle nav-link">--}}
{{--                    <i class="fe fe-grid fe-16"></i>--}}
{{--                    <span class="ml-3 item-text">Tables</span>--}}
{{--                </a>--}}
{{--                <ul class="collapse list-unstyled pl-4 w-100" id="tables">--}}
{{--                    <li class="nav-item">--}}
{{--                        <a class="nav-link pl-3" href="./table_basic.html"><span class="ml-1 item-text">Basic Tables</span></a>--}}
{{--                    </li>--}}
{{--                    <li class="nav-item">--}}
{{--                        <a class="nav-link pl-3" href="./table_advanced.html"><span class="ml-1 item-text">Advanced Tables</span></a>--}}
{{--                    </li>--}}
{{--                    <li class="nav-item">--}}
{{--                        <a class="nav-link pl-3" href="./table_datatables.html"><span class="ml-1 item-text">Data Tables</span></a>--}}
{{--                    </li>--}}
{{--                </ul>--}}
{{--            </li>--}}
{{--            <li class="nav-item dropdown">--}}
{{--                <a href="#charts" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle nav-link">--}}
{{--                    <i class="fe fe-pie-chart fe-16"></i>--}}
{{--                    <span class="ml-3 item-text">Charts</span>--}}
{{--                </a>--}}
{{--                <ul class="collapse list-unstyled pl-4 w-100" id="charts">--}}
{{--                    <li class="nav-item">--}}
{{--                        <a class="nav-link pl-3" href="./chart-inline.html"><span class="ml-1 item-text">Inline Chart</span></a>--}}
{{--                    </li>--}}
{{--                    <li class="nav-item">--}}
{{--                        <a class="nav-link pl-3" href="./chart-chartjs.html"><span class="ml-1 item-text">Chartjs</span></a>--}}
{{--                    </li>--}}
{{--                    <li class="nav-item">--}}
{{--                        <a class="nav-link pl-3" href="./chart-apexcharts.html"><span class="ml-1 item-text">ApexCharts</span></a>--}}
{{--                    </li>--}}
{{--                    <li class="nav-item">--}}
{{--                        <a class="nav-link pl-3" href="./datamaps.html"><span class="ml-1 item-text">Datamaps</span></a>--}}
{{--                    </li>--}}
{{--                </ul>--}}
{{--            </li>--}}
{{--        </ul>--}}
{{--        <p class="text-muted nav-heading mt-4 mb-1">--}}
{{--            <span>Apps</span>--}}
{{--        </p>--}}
{{--        <ul class="navbar-nav flex-fill w-100 mb-2">--}}
{{--            <li class="nav-item w-100">--}}
{{--                <a class="nav-link" href="calendar.html">--}}
{{--                    <i class="fe fe-calendar fe-16"></i>--}}
{{--                    <span class="ml-3 item-text">Calendar</span>--}}
{{--                </a>--}}
{{--            </li>--}}
{{--            <li class="nav-item dropdown">--}}
{{--                <a href="#contact" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle nav-link">--}}
{{--                    <i class="fe fe-book fe-16"></i>--}}
{{--                    <span class="ml-3 item-text">Contacts</span>--}}
{{--                </a>--}}
{{--                <ul class="collapse list-unstyled pl-4 w-100" id="contact">--}}
{{--                    <a class="nav-link pl-3" href="./contacts-list.html"><span class="ml-1">Contact List</span></a>--}}
{{--                    <a class="nav-link pl-3" href="./contacts-grid.html"><span class="ml-1">Contact Grid</span></a>--}}
{{--                    <a class="nav-link pl-3" href="./contacts-new.html"><span class="ml-1">New Contact</span></a>--}}
{{--                </ul>--}}
{{--            </li>--}}
{{--            <li class="nav-item dropdown">--}}
{{--                <a href="#profile" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle nav-link">--}}
{{--                    <i class="fe fe-user fe-16"></i>--}}
{{--                    <span class="ml-3 item-text">Profile</span>--}}
{{--                </a>--}}
{{--                <ul class="collapse list-unstyled pl-4 w-100" id="profile">--}}
{{--                    <a class="nav-link pl-3" href="./profile.html"><span class="ml-1">Overview</span></a>--}}
{{--                    <a class="nav-link pl-3" href="./profile-settings.html"><span class="ml-1">Settings</span></a>--}}
{{--                    <a class="nav-link pl-3" href="./profile-security.html"><span class="ml-1">Security</span></a>--}}
{{--                    <a class="nav-link pl-3" href="./profile-notification.html"><span class="ml-1">Notifications</span></a>--}}
{{--                </ul>--}}
{{--            </li>--}}
{{--            <li class="nav-item dropdown">--}}
{{--                <a href="#fileman" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle nav-link">--}}
{{--                    <i class="fe fe-folder fe-16"></i>--}}
{{--                    <span class="ml-3 item-text">File Manager</span>--}}
{{--                </a>--}}
{{--                <ul class="collapse list-unstyled pl-4 w-100" id="fileman">--}}
{{--                    <a class="nav-link pl-3" href="./files-list.html"><span class="ml-1">Files List</span></a>--}}
{{--                    <a class="nav-link pl-3" href="./files-grid.html"><span class="ml-1">Files Grid</span></a>--}}
{{--                </ul>--}}
{{--            </li>--}}
{{--            <li class="nav-item dropdown">--}}
{{--                <a href="#support" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle nav-link">--}}
{{--                    <i class="fe fe-compass fe-16"></i>--}}
{{--                    <span class="ml-3 item-text">Help Desk</span>--}}
{{--                </a>--}}
{{--                <ul class="collapse list-unstyled pl-4 w-100" id="support">--}}
{{--                    <a class="nav-link pl-3" href="./support-center.html"><span class="ml-1">Home</span></a>--}}
{{--                    <a class="nav-link pl-3" href="./support-tickets.html"><span class="ml-1">Tickets</span></a>--}}
{{--                    <a class="nav-link pl-3" href="./support-ticket-detail.html"><span class="ml-1">Ticket Detail</span></a>--}}
{{--                    <a class="nav-link pl-3" href="./support-faqs.html"><span class="ml-1">FAQs</span></a>--}}
{{--                </ul>--}}
{{--            </li>--}}
{{--        </ul>--}}
{{--        <p class="text-muted nav-heading mt-4 mb-1">--}}
{{--            <span>Extra</span>--}}
{{--        </p>--}}
{{--        <ul class="navbar-nav flex-fill w-100 mb-2">--}}
{{--            <li class="nav-item dropdown">--}}
{{--                <a href="#pages" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle nav-link">--}}
{{--                    <i class="fe fe-file fe-16"></i>--}}
{{--                    <span class="ml-3 item-text">Pages</span>--}}
{{--                </a>--}}
{{--                <ul class="collapse list-unstyled pl-4 w-100 w-100" id="pages">--}}
{{--                    <li class="nav-item">--}}
{{--                        <a class="nav-link pl-3" href="./page-orders.html">--}}
{{--                            <span class="ml-1 item-text">Orders</span>--}}
{{--                        </a>--}}
{{--                    </li>--}}
{{--                    <li class="nav-item">--}}
{{--                        <a class="nav-link pl-3" href="./page-timeline.html">--}}
{{--                            <span class="ml-1 item-text">Timeline</span>--}}
{{--                        </a>--}}
{{--                    </li>--}}
{{--                    <li class="nav-item">--}}
{{--                        <a class="nav-link pl-3" href="./page-invoice.html">--}}
{{--                            <span class="ml-1 item-text">Invoice</span>--}}
{{--                        </a>--}}
{{--                    </li>--}}
{{--                    <li class="nav-item">--}}
{{--                        <a class="nav-link pl-3" href="./page-404.html">--}}
{{--                            <span class="ml-1 item-text">Page 404</span>--}}
{{--                        </a>--}}
{{--                    </li>--}}
{{--                    <li class="nav-item">--}}
{{--                        <a class="nav-link pl-3" href="./page-500.html">--}}
{{--                            <span class="ml-1 item-text">Page 500</span>--}}
{{--                        </a>--}}
{{--                    </li>--}}
{{--                    <li class="nav-item">--}}
{{--                        <a class="nav-link pl-3" href="./page-blank.html">--}}
{{--                            <span class="ml-1 item-text">Blank</span>--}}
{{--                        </a>--}}
{{--                    </li>--}}
{{--                </ul>--}}
{{--            </li>--}}
{{--            <li class="nav-item dropdown">--}}
{{--                <a href="#auth" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle nav-link">--}}
{{--                    <i class="fe fe-shield fe-16"></i>--}}
{{--                    <span class="ml-3 item-text">Authentication</span>--}}
{{--                </a>--}}
{{--                <ul class="collapse list-unstyled pl-4 w-100" id="auth">--}}
{{--                    <a class="nav-link pl-3" href="./auth-login.html"><span class="ml-1">Login 1</span></a>--}}
{{--                    <a class="nav-link pl-3" href="./auth-login-half.html"><span class="ml-1">Login 2</span></a>--}}
{{--                    <a class="nav-link pl-3" href="./auth-register.html"><span class="ml-1">Register</span></a>--}}
{{--                    <a class="nav-link pl-3" href="./auth-resetpw.html"><span class="ml-1">Reset Password</span></a>--}}
{{--                    <a class="nav-link pl-3" href="./auth-confirm.html"><span class="ml-1">Confirm Password</span></a>--}}
{{--                </ul>--}}
{{--            </li>--}}
{{--            <li class="nav-item dropdown">--}}
{{--                <a href="#layouts" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle nav-link">--}}
{{--                    <i class="fe fe-layout fe-16"></i>--}}
{{--                    <span class="ml-3 item-text">Layout</span>--}}
{{--                </a>--}}
{{--                <ul class="collapse list-unstyled pl-4 w-100" id="layouts">--}}
{{--                    <li class="nav-item">--}}
{{--                        <a class="nav-link pl-3" href="./index.html"><span class="ml-1 item-text">Default</span></a>--}}
{{--                    </li>--}}
{{--                    <li class="nav-item">--}}
{{--                        <a class="nav-link pl-3" href="./index-horizontal.html"><span class="ml-1 item-text">Top Navigation</span></a>--}}
{{--                    </li>--}}
{{--                    <li class="nav-item">--}}
{{--                        <a class="nav-link pl-3" href="./index-boxed.html"><span class="ml-1 item-text">Boxed</span></a>--}}
{{--                    </li>--}}
{{--                </ul>--}}
{{--            </li>--}}
{{--        </ul>--}}
{{--        <p class="text-muted nav-heading mt-4 mb-1">--}}
{{--            <span>Documentation</span>--}}
{{--        </p>--}}
{{--        <ul class="navbar-nav flex-fill w-100 mb-2">--}}
{{--            <li class="nav-item w-100">--}}
{{--                <a class="nav-link" href="../docs/index.html">--}}
{{--                    <i class="fe fe-help-circle fe-16"></i>--}}
{{--                    <span class="ml-3 item-text">Getting Start</span>--}}
{{--                </a>--}}
{{--            </li>--}}
{{--        </ul>--}}
{{--        <div class="btn-box w-100 mt-4 mb-1">--}}
{{--            <a href="https://themeforest.net/item/tinydash-bootstrap-html-admin-dashboard-template/27511269" target="_blank" class="btn mb-2 btn-primary btn-lg btn-block">--}}
{{--                <i class="fe fe-shopping-cart fe-12 mr-2"></i><span class="small">Buy now</span>--}}
{{--            </a>--}}
{{--        </div>--}}
    </nav>
</aside>
