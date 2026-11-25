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

                                    @if ($errors->any())
                                        <div class="alert alert-danger">
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif

                                    <form  method="POST" action="{{route('admin.roles.update', $role->id)}}" >
                                        @csrf
                                        @method('PATCH')


                                        <div class="form-row">

                                            <div class="col-md-6 mb-3">
                                                <label for="validationCustomName">{{__('admin/labels.name').'  باللغة الانجليزية'}}</label>
                                                <input type="text" class="form-control @error("role.display_name") is-invalid @enderror" id="validationCustomName" name="role[display_name]" value="{{ old('role.display_name', $role->display_name) }}">
                                                @error("role.display_name")
                                                <div class="invalid-feedback" style="display: block;">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label for="permission-select">{{__('admin/labels.permission')}}</label>
                                                <select class="form-control f @error('permission.permission_id') is-invalid @enderror"
                                                        name="permission[permission_id][]"
                                                        id="permission-select"
                                                        multiple>

                                                    @foreach($permissions as $permission)
                                                        <option value="{{ $permission->id }}"
                                                            @selected( in_array($permission->id, (array) old('permission.permission_id', $assignedPermissionsIds)) ) >
                                                            {{ $permission->display_name }}
                                                        </option>
                                                    @endforeach

                                                </select>

                                                @error('permission.permission_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                        </div>


{{--                                        <div class="form-row">--}}
{{--                                            <div class="col-md-6 mb-3">--}}
{{--                                                <label for="validationCustomPass">الباسوورد  - {{ __('messages.'.get_active_lang()) }}</label>--}}
{{--                                                <input type="password" class="form-control @error("admin.password") is-invalid @enderror" id="validationCustomPass" name="admin[password]" value="{{ old('admin.password') }}" >--}}
{{--                                                <div class="valid-feedback"> Looks good! </div>--}}
{{--                                                @error("admin.password")--}}
{{--                                                <div class="invalid-feedback" style="display: block;">--}}
{{--                                                    {{ $message }}--}}
{{--                                                </div>--}}
{{--                                                @enderror--}}
{{--                                            </div>--}}

{{--                                            <div class="col-md-6 mb-3">--}}
{{--                                                <label for="validationCustomPass2"> اعد كتابة الباسوورد - {{ __('messages.'.get_active_lang()) }} </label>--}}
{{--                                                <input type="password" class="form-control @error("admin.password_confirmation") is-invalid @enderror" id="validationCustomPass2" name="admin[password_confirmation]" value="{{ old('admin.password_confirmation') }}" >--}}
{{--                                                <div class="valid-feedback"> Looks good! </div>--}}
{{--                                                @error("admin.password_confirmation")--}}
{{--                                                <div class="invalid-feedback" style="display: block;">--}}
{{--                                                    {{ $message }}--}}
{{--                                                </div>--}}
{{--                                                @enderror--}}
{{--                                            </div>--}}

{{--                                        </div>--}}

{{--                                        <div class="form-row">--}}

{{--                                            <div class="col-md-4 mb-3">--}}
{{--                                                <label for="gover-select">اختار المحافظة  - {{ __('messages.'.get_active_lang()) }}</label>--}}
{{--                                                <select class="form-control @error("profile.gover_id") is-invalid @enderror " name="profile[gover_id]"  id="gover-select">--}}
{{--                                                    <option selected disabled value="">Choose...</option>--}}
{{--                                                    @isset($governorates)--}}
{{--                                                        @foreach($governorates as $gover)--}}
{{--                                                            <option value="{{$gover->id}}"   @selected(old('profile.gover_id', $admin->profile->governorate_id) == $gover->id)>{{$gover->translation->name}}</option>--}}
{{--                                                        @endforeach--}}
{{--                                                    @endisset--}}
{{--                                                </select>--}}
{{--                                                <div class="valid-feedback"> Looks good! </div>--}}
{{--                                                @error("profile.gover_id")--}}
{{--                                                <div class="invalid-feedback" style="display: block;">--}}
{{--                                                    {{ $message }}--}}
{{--                                                </div>--}}
{{--                                                @enderror--}}
{{--                                            </div>--}}

{{--                                            <div class="col-md-4 mb-3">--}}
{{--                                                <label for="city-select">اختار المدينة  - {{ __('messages.'.get_active_lang()) }}</label>--}}
{{--                                                <select class="form-control @error("profile.city_id") is-invalid @enderror " name="profile[city_id]"  id="city-select">--}}
{{--                                                    <option selected disabled value="">Choose...</option>--}}
{{--                                                    @isset($cities)--}}
{{--                                                        @foreach($cities as $city)--}}
{{--                                                            <option value="{{$city->id}}"   @selected(old('profile.city_id', $admin->profile->city_id) == $city->id)>{{$city->translation->name}}</option>--}}
{{--                                                        @endforeach--}}
{{--                                                    @endisset--}}
{{--                                                </select>--}}
{{--                                                <div class="valid-feedback"> Looks good! </div>--}}
{{--                                                @error("profile.city_id")--}}
{{--                                                <div class="invalid-feedback" style="display: block;">--}}
{{--                                                    {{ $message }}--}}
{{--                                                </div>--}}
{{--                                                @enderror--}}
{{--                                            </div>--}}

{{--                                            <div class="col-md-4 mb-3">--}}
{{--                                                <label for="address">  العنوان - {{ __('messages.'.get_active_lang()) }} </label>--}}
{{--                                                <input type="text" class="form-control @error("profile.address") is-invalid @enderror" id="address" name="profile[address]" value="{{ old('profile.address', $admin->profile->address) }}" placeholder="EX:- district - street" >--}}
{{--                                                <div class="valid-feedback"> Looks good! </div>--}}
{{--                                                @error("profile.address")--}}
{{--                                                <div class="invalid-feedback" style="display: block;">--}}
{{--                                                    {{ $message }}--}}
{{--                                                </div>--}}
{{--                                                @enderror--}}
{{--                                            </div>--}}

{{--                                        </div>--}}

{{--                                        <div class="form-row">--}}

{{--                                            <div class="col-md-6 mb-3">--}}
{{--                                                <label for="mobile">  الموبايل - {{ __('messages.'.get_active_lang()) }} </label>--}}
{{--                                                <input type="tel" class="form-control @error("profile.mobile") is-invalid @enderror" id="mobile" name="profile[mobile]" value="{{ old('profile.mobile', $admin->profile->mobile) }}" placeholder="EX:- 01012345678" maxlength="11" required >--}}
{{--                                                <div class="valid-feedback"> Looks good! </div>--}}
{{--                                                @error("profile.mobile")--}}
{{--                                                <div class="invalid-feedback" style="display: block;">--}}
{{--                                                    {{ $message }}--}}
{{--                                                </div>--}}
{{--                                                @enderror--}}
{{--                                            </div>--}}

{{--                                            <div class="col-md-6 mb-3">--}}
{{--                                                <label for="role-select">اختار الدور الوظيفي  - {{ __('messages.'.get_active_lang()) }}</label>--}}
{{--                                                <select class="form-control @error("admin.role_id") is-invalid @enderror " name="admin[role_id]"  id="role-select">--}}
{{--                                                    <option selected disabled value="">Choose...</option>--}}
{{--                                                    @isset($roles)--}}
{{--                                                        @foreach($roles as $role)--}}
{{--                                                            <option value="{{$role->id}}" @selected(old('profile.role_id', $admin->role->id) == $role->id)>{{$role['display_name']}}</option>--}}
{{--                                                        @endforeach--}}
{{--                                                    @endisset--}}
{{--                                                </select>--}}
{{--                                                <div class="valid-feedback"> Looks good! </div>--}}
{{--                                                @error("admin.role_id")--}}
{{--                                                <div class="invalid-feedback" style="display: block;">--}}
{{--                                                    {{ $message }}--}}
{{--                                                </div>--}}
{{--                                                @enderror--}}
{{--                                            </div>--}}

{{--                                        </div>--}}

                                            <button class="btn btn-primary" type="submit">{{__('admin/labels.update')}}</button>
                                    </form>
                                </div> <!-- /.card-body -->
                            </div> <!-- /.card -->
                        </div> <!-- /.col -->
                    </div> <!-- end section -->
                </div> <!-- /.col-12 col-lg-10 col-xl-10 -->
            </div> <!-- .row -->
        </div> <!-- .container-fluid -->
    </main>

{{--<script>--}}

{{--        const governorateSelector = document.getElementById('gover-select');--}}
{{--        const citySelector = document.getElementById('city-select');--}}

{{--        governorateSelector.addEventListener('change', function (event) {--}}
{{--            const govId = this.value;--}}

{{--            // 1. Generate the URL with a placeholder string 'ID'--}}
{{--            let url = "{{ route('front.register.fetchCities', ':id') }}";--}}

{{--            // 2. Replace the placeholder with the actual value from the dropdown--}}
{{--            url = url.replace(':id', govId);--}}

{{--            // console.log("Fetching from:", url);--}}

{{--            if (governorateSelector) {--}}
{{--                // 2. Perform the AJAX call--}}
{{--                fetch(url, {--}}
{{--                    method: 'GET',--}}
{{--                    headers: {--}}
{{--                        'Content-Type': 'application/json',--}}
{{--                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content--}}
{{--                    },--}}
{{--                })--}}
{{--                    .then(response => response.json())--}}
{{--                    .then(data => {--}}
{{--                        console.log(data.cities)--}}
{{--                        showData(data.cities, citySelector)--}}
{{--                    })--}}
{{--                    .catch(error => console.error('Error:', error));--}}
{{--            }--}}
{{--        });--}}


{{--        function showData(data, selectInput) {--}}
{{--            selectInput.innerHTML = `<!--<option selected disabled value="">Choose...</option>-->`;--}}
{{--            data.forEach(item => {--}}
{{--                // console.log(item);--}}
{{--                selectInput.innerHTML += `<option value="${item.city_id}">${item.name}</option>`;--}}

{{--            });--}}


{{--        }--}}

{{--    </script>--}}
@endsection

