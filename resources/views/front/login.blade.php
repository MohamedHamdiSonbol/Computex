@extends('layouts.login')
@section('content')
    <div class="wrapper vh-100">
        <div class="row align-items-center h-100 mr-0 ms-0">
            <form class="col-lg-3 col-md-4 col-10 mx-auto text-center" method="POST" action="{{route('front.login.store')}}">
                @csrf
                <a class="navbar-brand mx-auto mt-2 flex-fill text-center" href="./index.html">
                    <svg version="1.1" id="logo" class="navbar-brand-img brand-md" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 120 120" xml:space="preserve">
              <g>
                  <polygon class="st0" points="78,105 15,105 24,87 87,87 	" />
                  <polygon class="st0" points="96,69 33,69 42,51 105,51 	" />
                  <polygon class="st0" points="78,33 15,33 24,15 87,15 	" />
              </g>
            </svg>
                </a>
                <h1 class="h6 mb-3">{{__('front/labels.sign_in')}}</h1>
                <div class="form-group">
                    <label for="inputEmail" class="sr-only">{{__('front/labels.email')}}</label>
                    <input type="email" id="inputEmail" class="form-control form-control-lg" name="email" placeholder="{{__('front/labels.email')}}" required="" autofocus="">
                    @error('email')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="inputPassword" class="sr-only">{{__('front/labels.password')}}</label>
                    <input type="password" id="inputPassword" class="form-control form-control-lg" name="password" placeholder="{{__('front/labels.password')}}" required="">
                </div>
                <div class="checkbox mb-3">
                    <label>
                        <input type="checkbox" value="remember-me" name="remember">{{__('front/labels.remember_me')}}</label>
                </div>
                <button class="btn btn-lg btn-primary btn-block" type="submit">{{__('front/labels.sign_in')}}</button>

                <a href="{{route('front.register.create')}}" class="d-block col-lg-3 col-md-4 col-10 mx-auto text-center btn btn-success w-100 mt-5">{{__('front/labels.register')}}</a>

            </form>


        </div>
    </div>
@endsection
