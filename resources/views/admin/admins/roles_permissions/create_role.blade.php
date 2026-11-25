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


                                    <form  method="POST" action="{{route('admin.roles.store')}}">
                                        @csrf


                                                <div class="form-row">

                                                    <div class="col-md-6 mb-3">
                                                        <label for="validationCustomName"> {{__('admin/labels.name').'  باللغة الانجليزية'}}</label>
                                                        <input type="text" class="form-control @error("role.display_name") is-invalid @enderror" id="validationCustomName" name="role[display_name]" value="{{ old('role.display_name') }}">
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
                                                                    {{ is_array(old('permission.permission_id')) && in_array($permission->id, old('permission.permission_id')) ? 'selected' : '' }}>
                                                                    {{ $permission->display_name }}
                                                                </option>
                                                            @endforeach

                                                        </select>

                                                        @error('permission.permission_id')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>

                                                </div>


                                        <button class="btn btn-primary col-md-12" type="submit">Submit form</button>
                                    </form>
                                </div> <!-- /.card-body -->
                            </div> <!-- /.card -->
                        </div> <!-- /.col -->
                    </div> <!-- end section -->
                </div> <!-- /.col-12 col-lg-10 col-xl-10 -->
            </div> <!-- .row -->
        </div> <!-- .container-fluid -->
    </main>

@endsection

