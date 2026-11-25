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
                                    <form  method="POST" action="{{route('admin.colors.update', $color->id)}}" enctype="multipart/form-data">
                                        @csrf
                                        @method('PATCH')

                                            <div class="form-row">

                                                    <div class="col-md-4 mb-3">
                                                        <label for="validationCustomName">{{__('admin/labels.name').' باللغة الانجليزية' }}</label>
                                                        <input type="text" class="form-control @error("color.name") is-invalid @enderror" id="validationCustomName" name="color[name]" value="{{ old("color.name", $color->name) }}">
                                                        @error("color.name")
                                                        <div class="invalid-feedback" style="display: block;">
                                                            {{ $message }}
                                                        </div>
                                                        @enderror
                                                    </div>
                                                </div>

                                        <div class="form-row">

                                        <div class="col-md-12 mx-auto mb-3">
                                            <p class="mb-3">{{__('admin/labels.active')}}</p>
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" class="custom-control-input  @error("color.is_active") is-invalid @enderror"  id="customSwitch1" name="color[is_active]" value="1" @checked(old("color.is_active", $color->is_active) == 1)  >
                                                <label class="custom-control-label" for="customSwitch1">{{__('admin/labels.yes')}}</label>
                                                @error("color.is_active")
                                                <div class="invalid-feedback" style="display: block;">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>
                                            </div>


                                            <button class="btn btn-primary" type="submit">{{__('admin/labels.update')}}</button>
                                        </div>
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

