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

                  <h2 class=" w-100 rounded-top text-center font-weight-bold bg-primary p-2 mb-5" style="letter-spacing: 1px;">{{__('front/labels.orders_history')}}</h2>

                        <div class="table-responsive mx-2">
                            <table class="table table-bordered table-striped table-hover ">
                                <thead class="fs-5 font-weight-bolder text-white" style="background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.5))">
                                <tr>
                                    <th scope="col">{{__('front/labels.order_id')}}</th>
                                    <th scope="col">{{__('front/labels.total_amount')}}</th>
                                    <th scope="col">{{__('front/labels.order_status')}}</th>
                                    <th scope="col">{{__('front/labels.track_order')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($orders as $order)
                                    <tr>
                                        <th scope="row" class="align-middle text-dark">
                                            <p class="mb-0 ">{{$order->order_number}}</p>
                                        </th>

                                        <td  class="align-middle text-dark">
                                            <p class="mb-0 ">{{$order->total_price .' '.__('front/labels.currency')}}</p>
                                        </td>

                                        @php
                                            $statusClasses = [
                                                'pending'   => 'bg-warning',
                                                'shipped'   => 'text-info',
                                                'delivered' => 'text-success',
                                                'rejected'  => 'text-danger',
                                            ];
                                            $currentClass = $statusClasses[$order->status] ?? 'text-secondary';
                                        @endphp

                                        <td  class="align-middle text-dark">
                                            <p class="d-inline p-1 rounded {{$currentClass }}"> {{ ucfirst(__('front/labels.'.$order->status)) }}</p>
                                        </td>

                                        <td>
                                            <a href="{{route('front.order.trackOrder', $order->order_number)}}" class="btn btn-sm btn-outline-dark rounded "> {{__('front/labels.track_your_order')}} </a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
            </div>
        </div>
    </div>
</div>



