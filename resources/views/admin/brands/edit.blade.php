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
                                    <form  method="POST" action="{{route('admin.brands.update', $brand->id)}}" enctype="multipart/form-data">
                                        @csrf
                                        @method('PATCH')
                                        <div class="form-row">

                                            <div class="form-row">
                                                <div class="col-md-12 mb-3">
                                                    <label for="validationCustomLogo">{{__('admin/labels.logo')}}</label>
                                                    <input type="file" class="form-control @error('logo') is-invalid @enderror" id="validationCustomLogo" name="brand[logo]" >
                                                    @error('logo')
                                                    <span class="invalid-feedback">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-md-4 mb-3" >
                                                <img src="{{$brand->logoUrl}}" alt="" style="width: 50px;" readonly>
                                            </div>
                                        </div>

                                            @if(count($brand['translations']) > 0)
                                            <div class="form-row">

                                                @foreach($brand['translations'] as $index => $translations)

                                                    <div class="col-md-6 mb-3">
                                                        <label for="validationCustomName{{$index}}">{{__('admin/labels.name').' '. __('admin/labels.'.$translations->language->abbr) }}</label>
                                                        <input type="text" class="form-control @error("brand_translations.$index.name") is-invalid @enderror" id="validationCustomName{{$index}}" name="brand_translations[{{$index}}][name]" value="{{  old("brand_translations.$index.name", $translations->name) }}" required>
                                                        @error("brand_translations.$index.name")
                                                        <div class="invalid-feedback" style="display: block;">
                                                            {{ $message }}
                                                        </div>
                                                        @enderror
                                                    </div>


                                                    <input type="hidden" class="form-control" name="brand_translations[{{$index}}][language_id]" value="{{$translations->language_id}}" readonly>
                                                @endforeach
                                                </div>

                                            @endif


                                        <div class="form-row">

                                        <div class="col-md-12 mx-auto mb-3">
                                            <p class="mb-3">{{__('admin/labels.active')}}</p>
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" class="custom-control-input  @error("brand.is_active") is-invalid @enderror"  id="customSwitch1" name="brand[is_active]" value="1" @checked(old("brand.is_active", $brand->is_active) == 1)  >
                                                <label class="custom-control-label" for="customSwitch1">{{__('admin/labels.yes')}}</label>
                                                @error("brand.is_active")
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

