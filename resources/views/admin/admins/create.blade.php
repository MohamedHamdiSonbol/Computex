@extends('layouts.admin')

@section('main')
    <main role="main" class="main-content">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-12">
                    <h2 class="page-title">Form validation</h2>
                    <p class="text-muted">Provide valuable, actionable feedback to your users with HTML5 form validation</p>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card shadow mb-4">
                                <div class="card-header">
                                    <strong class="card-title">Default Validation</strong>
                                </div>
                                <div class="card-body">


                                    <form  method="POST" action="{{route('admin.admins.store')}}">
                                        @csrf


                                                <div class="form-row">

                                                    <div class="col-md-6 mb-3">
                                                        <label for="validationCustomName">{{ __('admin/labels.customer_name') }}</label>
                                                        <input type="text" class="form-control @error("admin.name") is-invalid @enderror" id="validationCustomName" name="admin[name]" value="{{ old('admin.name') }}">
                                                        <div class="invalid-feedback"> Please provide a valid city. </div>
                                                        @error("admin.name")
                                                        <div class="invalid-feedback" style="display: block;">
                                                            {{ $message }}
                                                        </div>
                                                        @enderror
                                                    </div>


                                                    <div class="col-md-6 mb-3">
                                                        <label for="validationCustomEmail">{{ __('admin/labels.email') }}</label>
                                                        <input type="email" class="form-control @error("admin.email") is-invalid @enderror" id="validationCustomEmail" name="admin[email]" value="{{ old('admin.email') }}" >

                                                        @error("admin.email")
                                                        <div class="invalid-feedback" style="display: block;">
                                                            {{ $message }}
                                                        </div>
                                                        @enderror
                                                    </div>


                                                </div>


                                        <div class="form-row">
                                            <div class="col-md-6 mb-3">
                                                <label for="validationCustomPass">{{ __('admin/labels.password') }}</label>
                                                <input type="password" class="form-control @error("admin.password") is-invalid @enderror" id="validationCustomPass" name="admin[password]" value="{{ old('admin.password') }}" >

                                                @error("admin.password")
                                                <div class="invalid-feedback" style="display: block;">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label for="validationCustomPass2">{{ __('admin/labels.repeat_password') }}</label>
                                                <input type="password" class="form-control @error("admin.password_confirmation") is-invalid @enderror" id="validationCustomPass2" name="admin[password_confirmation]" value="{{ old('admin.password_confirmation') }}" >

                                                @error("admin.password_confirmation")
                                                <div class="invalid-feedback" style="display: block;">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>

                                        </div>

                                        <div class="form-row">

                                            <div class="col-md-4 mb-3">
                                                <label for="gover-select">{{ __('admin/labels.governorate') }}</label>
                                                <select class="form-control @error("profile.gover_id") is-invalid @enderror " name="profile[gover_id]"  id="gover-select">
                                                    <option selected disabled value="">{{__('admin/labels.choose')}}</option>
                                                    @isset($governorates)
                                                        @foreach($governorates as $gover)
                                                            <option value="{{$gover->id}}">{{$gover->translation->name}}</option>
                                                        @endforeach
                                                    @endisset
                                                </select>

                                                @error("profile.gover_id")
                                                <div class="invalid-feedback" style="display: block;">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>

                                            <div class="col-md-4 mb-3">
                                                <label for="city-select">{{ __('admin/labels.city') }}</label>
                                                <select class="form-control @error("profile.city_id") is-invalid @enderror " name="profile[city_id]"  id="city-select">
                                                    <option selected disabled value="">{{__('admin/labels.choose')}}</option>

                                                </select>

                                                @error("profile.city_id")
                                                <div class="invalid-feedback" style="display: block;">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>

                                            <div class="col-md-4 mb-3">
                                                <label for="address">{{ __('admin/labels.address') }}</label>
                                                <input type="text" class="form-control @error("profile.address") is-invalid @enderror" id="address" name="profile[address]" value="{{ old('profile.address') }}" placeholder="{{__('admin/labels.ex').' '.__('admin/labels.district_street')}}" >

                                                @error("profile.address")
                                                <div class="invalid-feedback" style="display: block;">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>

                                        </div>

                                        <div class="form-row">

                                            <div class="col-md-6 mb-3">
                                                <label for="mobile">{{ __('admin/labels.mobile') }}</label>
                                                <input type="tel" class="form-control @error("profile.mobile") is-invalid @enderror" id="mobile" name="profile[mobile]" value="{{ old('profile.mobile') }}" placeholder="{{__('admin/labels.ex')}} 01012345678" maxlength="11" required >

                                                @error("profile.mobile")
                                                <div class="invalid-feedback" style="display: block;">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label for="role-select">{{ __('admin/labels.role') }}</label>
                                                <select class="form-control @error("admin.role_id") is-invalid @enderror " name="admin[role_id]"  id="role-select">
                                                    <option selected disabled value="">{{__('admin/labels.choose')}}</option>
                                                    @isset($roles)
                                                        @foreach($roles as $role)
                                                            <option value="{{$role['id']}}">{{$role['display_name']}}</option>
                                                        @endforeach
                                                    @endisset
                                                </select>

                                                @error("admin.role_id")
                                                <div class="invalid-feedback" style="display: block;">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>

                                        </div>

                                        <button class="btn btn-primary col-md-12" type="submit">{{__('admin/labels.create')}}</button>
                                    </form>
                                </div> <!-- /.card-body -->
                            </div> <!-- /.card -->
                        </div> <!-- /.col -->
                    </div> <!-- end section -->
                </div> <!-- /.col-12 col-lg-10 col-xl-10 -->
            </div> <!-- .row -->
        </div> <!-- .container-fluid -->
    </main>

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

