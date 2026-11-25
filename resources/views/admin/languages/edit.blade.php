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
                                    <form  method="POST" action="{{route('admin.languages.update', $language->id)}}">
                                        @csrf
                                        @method('PATCH')
                                        <div class="form-row">

                                            <div class="col-md-6 mb-3">
                                                <label for="validationCustom01">{{__('admin/labels.abbreviation')}}</label>
                                                <input type="text" class="form-control @error('abbr') is-invalid @enderror" id="validationCustom01" name="abbr" value="{{ old('abbr', $language->abbr) }}" required>
                                                @error('abbr')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="validationCustom02">local</label>
                                                <input type="text" class="form-control @error('local') is-invalid @enderror" id="validationCustom02" name="local" value="{{ old('local', $language->local) }}" required>
                                                @error('local')
                                                <div class="invalid-feedback" style="display: block;">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="col-md-6 mb-3">
                                                <label for="validationCustom03">{{__('admin/labels.name').' باللغة الانجليزية'}}</label>
                                                <input type="text" class="form-control" id="validationCustom03" name="name" value="{{  old('name', $language->name) }}" required>
                                                @error('name')
                                                <div class="invalid-feedback" style="display: block;">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label for="validationCustom04">{{__('admin/labels.direction')}}</label>
                                            <select class="custom-select" id="validationCustom04" name="direction"  required>
                                                <option value="rtl" @selected(old('direction', $language->direction) === 'rtl')>{{__('admin/labels.rtl')}}</option>
                                                <option value="ltr" @selected(old('direction', $language->direction) === 'ltr')>{{__('admin/labels.ltr')}}</option>
                                            </select>
                                        </div>

                                        <div class="col-md-12 mx-auto mb-3">
                                            <p class="mb-3">{{__('admin/labels.active')}}</p>
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" class="custom-control-input" id="customSwitch1" name="active" value="1" @checked(old('active', $language->active) == 1)  >
                                                <label class="custom-control-label" for="customSwitch1">{{__('admin/labels.yes')}}</label>
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

