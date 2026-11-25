@extends('layouts.login')
@section('content')

    <div class="wrapper vh-100">
        <div class="row align-items-center h-100 mr-0 ms-0">

                <div class="mx-auto text-center my-4">
                    <a class="navbar-brand mx-auto mt-2 flex-fill text-center" href="./index.html">
                        <svg version="1.1" id="logo" class="navbar-brand-img brand-md" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 120 120" xml:space="preserve">
                            <g>
                                <polygon class="st0" points="78,105 15,105 24,87 87,87 	" />
                                <polygon class="st0" points="96,69 33,69 42,51 105,51 	" />
                                <polygon class="st0" points="78,33 15,33 24,15 87,15 	" />
                            </g>
                        </svg>
                    </a>
                    <h2 class="my-3">{{__('front/labels.register')}}</h2>
                </div>
            <form class="col-lg-6 col-md-8 col-10 mx-auto" action="{{route('front.register.store')}}" method="POST">
                @csrf
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="firstname">{{__('front/labels.first_name')}}</label>
                        <input type="text" id="firstname" name="customer[first_name]" class="form-control form-control-lg @error('customer.first_name') is-invalid @enderror">
                        @error('customer.first_name')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label for="lastname">{{__('front/labels.last_name')}}</label>
                        <input type="text" id="lastname" name="customer[last_name]" class="form-control form-control-lg @error('customer.last_name') is-invalid @enderror">
                        @error('customer.last_name')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-md-12">
                        <label for="inputEmail" >{{__('front/labels.email')}}</label>
                        <input type="email" id="inputEmail" class="form-control form-control-lg @error('customer.email') is-invalid @enderror" name="customer[email]" required>
                        @error('customer.email')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>

                </div>


                <hr class="my-4">

                <div class="form-row mb-4">
                    <div class="form-group col-md-6 mb-3">
                        <label>{{__('front/labels.password')}}</label>
                        <input type="password" class="form-control form-control-lg  @error('customer.password') is-invalid @enderror" name="customer[password]" required>
                        @error('customer.password')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Confirm Password --}}
                    <div class="form-group col-md-6 mb-3">
                        <label>{{__('front/labels.confirm_password')}}</label>
                        <input type="password" class="form-control form-control-lg @error('customer.password_confirmation') is-invalid @enderror" name="customer[password_confirmation]" required>
                        @error('customer.password_confirmation')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <hr class="my-4">

                <div class="form-row mb-4">
                    <div class="form-group col-md-6 mb-3">
                        <label>{{__('front/labels.mobile')}}</label>
                        <input type="tel" class="form-control form-control-lg  @error('profile.mobile') is-invalid @enderror" name="profile[mobile]" placeholder="EX:- 01012345678" maxlength="11" required>
                        @error('profile.mobile')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>


                <hr class="my-4">

                <div class="form-row mb-4">

                    <div class="form-group col-md-6 mb-3">
                        <label>{{__('front/labels.Governorate')}}</label>
                        <select class="custom-select form-control form-control-lg  @error('profile.gover_id') is-invalid @enderror" id="gover-select" name="profile[gover_id]" >
                             <option selected disabled value="">{{__('front/labels.choose')}}</option>
                            @isset($governorates)
                                @foreach($governorates as $gover)
                                    <option value="{{$gover['governorate_id']}}">{{$gover['name']}}</option>
                                @endforeach
                            @endisset
                        </select>
                        @error('profile.gover_id')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group col-md-6 mb-3">
                        <label>{{__('front/labels.city')}}</label>
                        <select class="custom-select form-control form-control-lg  @error('profile.city_id') is-invalid @enderror" id="city-select" name="profile[city_id]" >
                             <option selected disabled value="">{{__('front/labels.choose')}}</option>

                        </select>
                        @error('profile.city_id')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group col-md-12 mb-3">
                        <label>{{__('front/labels.address')}}</label>
                        <input type="text"  name="profile[address]" class="form-control form-control-lg @error('profile.address') is-invalid @enderror" placeholder="EX:- district - street">
                        @error('profile.[address')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="form-row mb-4">
                    <div class="form-group col-md-12">
                        <button class="btn btn-lg btn-primary btn-block" type="submit">{{__('front/labels.sign_up')}}</button>

                    </div>
                </div>

                <p class="mt-5 mb-3 text-muted text-center">© 2020</p>
            </form>
        </div>
    </div>



{{--////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////--}}
 <script>

     const governorateSelector = document.getElementById('gover-select');
     const citySelector = document.getElementById('city-select');

     governorateSelector.addEventListener('change', function (event) {
         const govId = this.value;

         // 1. Generate the URL with a placeholder string 'ID'
         let url = "{{ route('front.register.fetchCities', ':id') }}";

         // 2. Replace the placeholder with the actual value from the dropdown
         url = url.replace(':id', govId);

         // console.log("Fetching from:", url);

         if (governorateSelector) {
             // 2. Perform the AJAX call
             fetch(url, {
                 method: 'GET',
                 headers: {
                     'Content-Type': 'application/json',
                     'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                 },
             })
                 .then(response => response.json())
                 .then(data => {
                     console.log(data.cities)
                     showData(data.cities, citySelector)
                 })
                 .catch(error => console.error('Error:', error));
         }
     });


     function showData(data, selectInput) {
         selectInput.innerHTML = `<!--<option selected disabled value="">Choose...</option>-->`;
         data.forEach(item => {
             // console.log(item);
             selectInput.innerHTML += `<option value="${item.city_id}">${item.name}</option>`;

         });


     }

 </script>
@endsection
