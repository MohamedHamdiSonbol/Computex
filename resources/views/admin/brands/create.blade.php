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
                                    <form  method="POST" action="{{route('admin.brands.store')}}" enctype="multipart/form-data">
                                        @csrf
                                        <div class="form-row">
                                            <div class="col-md-12 mb-3">
                                                <label for="validationCustomLogo">{{__('admin/labels.logo')}}</label>
                                                <input type="file" class="form-control @error('logo') is-invalid @enderror" id="validationCustomLogo" name="brand[logo]" value="{{ old('logo') }}" >
                                                @error('logo')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        @if(count(get_active_languages()) > 0)
                                            <div class="form-row">

                                            @foreach(get_active_languages() as $index => $lang)


                                                    <div class="col-md-6 mb-3">
                                                        <label for="validationCustomName{{$index}}">{{__('admin/labels.name').' '.__('admin/labels.'.$lang->abbr) }}</label>
                                                        <input type="text" class="form-control @error("brand_translations.$index.name") is-invalid @enderror" id="validationCustomName{{$index}}" name="brand_translations[{{$index}}][name]" >
                                                        @error("brand_translations.$index.name")
                                                        <div class="invalid-feedback" style="display: block;">
                                                            {{ $message }}
                                                        </div>
                                                        @enderror
                                                    </div>

                                                    <input type="hidden" class="form-control" name="brand_translations[{{$index}}][language_id]" value="{{ $lang->id}}" readonly>

                                            @endforeach
                                            </div>

                                        @endif
                                        <div class="form-row">

                                            <div class="col-md-12 mx-auto mb-3">
                                                <p class="mb-3">{{__('admin/labels.active')}}</p>
                                                <div class="custom-control custom-switch">
                                                    <input type="checkbox" class="custom-control-input" id="customSwitch" name="brand[is_active]" value="1" {{ old('brand.is_active') ? 'checked' : '' }}>
                                                    <label class="custom-control-label" for="customSwitch">{{__('admin/labels.yes')}}</label>
                                                </div>

                                            </div>

                                        </div>

                                        <button class="btn btn-primary" type="submit">{{__('admin/labels.create')}}</button>
                                    </form>
                                </div> <!-- /.card-body -->
                            </div> <!-- /.card -->
                        </div> <!-- /.col -->
                    </div> <!-- end section -->
                </div> <!-- /.col-12 col-lg-10 col-xl-10 -->
            </div> <!-- .row -->
        </div> <!-- .container-fluid -->

{{--        <div class="modal fade modal-notif modal-slide" tabindex="-1" role="dialog" aria-labelledby="defaultModalLabel" aria-hidden="true">--}}
{{--            <div class="modal-dialog modal-sm" role="document">--}}
{{--                <div class="modal-content">--}}
{{--                    <div class="modal-header">--}}
{{--                        <h5 class="modal-title" id="defaultModalLabel">Notifications</h5>--}}
{{--                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">--}}
{{--                            <span aria-hidden="true">&times;</span>--}}
{{--                        </button>--}}
{{--                    </div>--}}
{{--                    <div class="modal-body">--}}
{{--                        <div class="list-group list-group-flush my-n3">--}}
{{--                            <div class="list-group-item bg-transparent">--}}
{{--                                <div class="row align-items-center">--}}
{{--                                    <div class="col-auto">--}}
{{--                                        <span class="fe fe-box fe-24"></span>--}}
{{--                                    </div>--}}
{{--                                    <div class="col">--}}
{{--                                        <small><strong>Package has uploaded successfull</strong></small>--}}
{{--                                        <div class="my-0 text-muted small">Package is zipped and uploaded</div>--}}
{{--                                        <small class="badge badge-pill badge-light text-muted">1m ago</small>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="list-group-item bg-transparent">--}}
{{--                                <div class="row align-items-center">--}}
{{--                                    <div class="col-auto">--}}
{{--                                        <span class="fe fe-download fe-24"></span>--}}
{{--                                    </div>--}}
{{--                                    <div class="col">--}}
{{--                                        <small><strong>Widgets are updated successfull</strong></small>--}}
{{--                                        <div class="my-0 text-muted small">Just create new layout Index, form, table</div>--}}
{{--                                        <small class="badge badge-pill badge-light text-muted">2m ago</small>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="list-group-item bg-transparent">--}}
{{--                                <div class="row align-items-center">--}}
{{--                                    <div class="col-auto">--}}
{{--                                        <span class="fe fe-inbox fe-24"></span>--}}
{{--                                    </div>--}}
{{--                                    <div class="col">--}}
{{--                                        <small><strong>Notifications have been sent</strong></small>--}}
{{--                                        <div class="my-0 text-muted small">Fusce dapibus, tellus ac cursus commodo</div>--}}
{{--                                        <small class="badge badge-pill badge-light text-muted">30m ago</small>--}}
{{--                                    </div>--}}
{{--                                </div> <!-- / .row -->--}}
{{--                            </div>--}}
{{--                            <div class="list-group-item bg-transparent">--}}
{{--                                <div class="row align-items-center">--}}
{{--                                    <div class="col-auto">--}}
{{--                                        <span class="fe fe-link fe-24"></span>--}}
{{--                                    </div>--}}
{{--                                    <div class="col">--}}
{{--                                        <small><strong>Link was attached to menu</strong></small>--}}
{{--                                        <div class="my-0 text-muted small">New layout has been attached to the menu</div>--}}
{{--                                        <small class="badge badge-pill badge-light text-muted">1h ago</small>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div> <!-- / .row -->--}}
{{--                        </div> <!-- / .list-group -->--}}
{{--                    </div>--}}
{{--                    <div class="modal-footer">--}}
{{--                        <button type="button" class="btn btn-secondary btn-block" data-dismiss="modal">Clear All</button>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--        <div class="modal fade modal-shortcut modal-slide" tabindex="-1" role="dialog" aria-labelledby="defaultModalLabel" aria-hidden="true">--}}
{{--            <div class="modal-dialog" role="document">--}}
{{--                <div class="modal-content">--}}
{{--                    <div class="modal-header">--}}
{{--                        <h5 class="modal-title" id="defaultModalLabel">Shortcuts</h5>--}}
{{--                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">--}}
{{--                            <span aria-hidden="true">&times;</span>--}}
{{--                        </button>--}}
{{--                    </div>--}}
{{--                    <div class="modal-body px-5">--}}
{{--                        <div class="row align-items-center">--}}
{{--                            <div class="col-6 text-center">--}}
{{--                                <div class="squircle bg-success justify-content-center">--}}
{{--                                    <i class="fe fe-cpu fe-32 align-self-center text-white"></i>--}}
{{--                                </div>--}}
{{--                                <p>Control area</p>--}}
{{--                            </div>--}}
{{--                            <div class="col-6 text-center">--}}
{{--                                <div class="squircle bg-primary justify-content-center">--}}
{{--                                    <i class="fe fe-activity fe-32 align-self-center text-white"></i>--}}
{{--                                </div>--}}
{{--                                <p>Activity</p>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="row align-items-center">--}}
{{--                            <div class="col-6 text-center">--}}
{{--                                <div class="squircle bg-primary justify-content-center">--}}
{{--                                    <i class="fe fe-droplet fe-32 align-self-center text-white"></i>--}}
{{--                                </div>--}}
{{--                                <p>Droplet</p>--}}
{{--                            </div>--}}
{{--                            <div class="col-6 text-center">--}}
{{--                                <div class="squircle bg-primary justify-content-center">--}}
{{--                                    <i class="fe fe-upload-cloud fe-32 align-self-center text-white"></i>--}}
{{--                                </div>--}}
{{--                                <p>Upload</p>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="row align-items-center">--}}
{{--                            <div class="col-6 text-center">--}}
{{--                                <div class="squircle bg-primary justify-content-center">--}}
{{--                                    <i class="fe fe-users fe-32 align-self-center text-white"></i>--}}
{{--                                </div>--}}
{{--                                <p>Users</p>--}}
{{--                            </div>--}}
{{--                            <div class="col-6 text-center">--}}
{{--                                <div class="squircle bg-primary justify-content-center">--}}
{{--                                    <i class="fe fe-settings fe-32 align-self-center text-white"></i>--}}
{{--                                </div>--}}
{{--                                <p>Settings</p>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
    </main>
@endsection

