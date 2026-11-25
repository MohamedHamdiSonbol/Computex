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
                                    <form  method="POST" action="{{route('admin.languages.store')}}">
                                        @csrf
                                        <div class="form-row">

{{--                                            <div class="col-md-8 mb-3">--}}
{{--                                                <label for="exampleInputEmail1">Email address</label>--}}
{{--                                                <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" required>--}}
{{--                                                <div class="invalid-feedback"> Please use a valid email </div>--}}
{{--                                                <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>--}}
{{--                                            </div>--}}
{{--                                            <div class="col-md-4 mb-3">--}}
{{--                                                <label for="validationCustomUsername">Username</label>--}}
{{--                                                <div class="input-group">--}}
{{--                                                    <div class="input-group-prepend">--}}
{{--                                                        <span class="input-group-text" id="inputGroupPrepend">@</span>--}}
{{--                                                    </div>--}}
{{--                                                    <input type="text" class="form-control" id="validationCustomUsername" aria-describedby="inputGroupPrepend" required>--}}
{{--                                                    <div class="invalid-feedback"> Please choose a username. </div>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
                                            <div class="col-md-6 mb-3">
                                                <label for="validationCustom01">{{__('admin/labels.abbreviation')}}</label>
                                                <input type="text" class="form-control @error('abbr') is-invalid @enderror" id="validationCustom01" name="abbr" value="{{ old('abbr') }}" required>
                                                @error('abbr')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="validationCustom02">local</label>
                                                <input type="text" class="form-control @error('local') is-invalid @enderror" id="validationCustom02" name="local" value="{{ old('local') }}" required>
                                                <div class="valid-feedback"> Looks good! </div>
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
                                                <input type="text" class="form-control" id="validationCustom03" name="name" required>
                                                @error('name')
                                                <div class="invalid-feedback" style="display: block;">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>
{{--                                            <div class="col-md-3 mb-3">--}}
{{--                                                <label for="validationCustom04">State</label>--}}
{{--                                                <select class="custom-select" id="validationCustom04" required>--}}
{{--                                                    <option selected disabled value="">Choose...</option>--}}
{{--                                                    <option>...</option>--}}
{{--                                                </select>--}}
{{--                                                <div class="invalid-feedback"> Please select a valid state. </div>--}}
{{--                                            </div>--}}
{{--                                            <div class="col-md-3 mb-3">--}}
{{--                                                <label for="validationCustom05">Zip</label>--}}
{{--                                                <input type="text" class="form-control" id="validationCustom05" required>--}}
{{--                                                <div class="invalid-feedback"> Please provide a valid zip. </div>--}}
{{--                                            </div>--}}
                                        </div>
{{--                                        <div class="form-group mb-3">--}}
{{--                                            <label for="validationTextarea">About your self</label>--}}
{{--                                            <textarea class="form-control" id="validationTextarea" placeholder="Required example textarea" required></textarea>--}}
{{--                                            <div class="invalid-feedback"> Please enter a message in the textarea. </div>--}}
{{--                                        </div>--}}
{{--                                        <div class="custom-control custom-checkbox mb-3">--}}
{{--                                            <input type="checkbox" class="custom-control-input" id="customControlValidation1" required>--}}
{{--                                            <label class="custom-control-label" for="customControlValidation1">Check this custom checkbox</label>--}}
{{--                                            <div class="invalid-feedback">Example invalid feedback text</div>--}}
{{--                                        </div>--}}

                                        <div class="col-md-3 mb-3">
                                            <label for="validationCustom04">{{__('admin/labels.direction')}}</label>
                                            <select class="custom-select" id="validationCustom04" name="direction" required>
{{--                                                <option selected disabled value="">Choose...</option>--}}
                                                <option value="rtl">{{__('admin/labels.rtl')}}</option>
                                                <option value="ltr">{{__('admin/labels.ltr')}}</option>
                                            </select>
                                        </div>
{{--                                        <p>Direction</p>--}}
{{--                                        <div class="custom-control custom-radio">--}}
{{--                                            <input type="radio" class="custom-control-input" id="customControlValidation1" name="direction" value="rtl" required>--}}
{{--                                            <label class="custom-control-label" for="customControlValidation1">rtl</label>--}}
{{--                                        </div>--}}
{{--                                        <div class="custom-control custom-radio">--}}
{{--                                            <input type="radio" class="custom-control-input" id="customControlValidation2" name="direction" value="ltr" required>--}}
{{--                                            <label class="custom-control-label" for="customControlValidation2">ltr</label>--}}
{{--                                        </div>--}}


                                        <div class="col-md-12 mx-auto mb-3">
                                            <p class="mb-3">{{__('admin/labels.active')}}</p>
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" class="custom-control-input" id="customSwitch1" name="active" value="1" >
                                                <label class="custom-control-label" for="customSwitch1">{{__('admin/labels.yes')}}</label>
                                            </div>
{{--                                        <div class="custom-control custom-radio mb-3">--}}
{{--                                            <input type="radio" class="custom-control-input" id="customControlValidation3" name="active" value="1" required>--}}
{{--                                            <label class="custom-control-label" for="customControlValidation3">active</label>--}}
{{--                                            <div class="invalid-feedback">More example invalid feedback text</div>--}}
{{--                                        </div>--}}
{{--                                        <div class="custom-control custom-radio mb-3">--}}
{{--                                            <input type="radio" class="custom-control-input" id="customControlValidation4" name="active" value="0" required>--}}
{{--                                            <label class="custom-control-label" for="customControlValidation4">not active</label>--}}
{{--                                            <div class="invalid-feedback">More example invalid feedback text</div>--}}
{{--                                        </div>--}}
{{--                                        <div class="form-group mb-4">--}}
{{--                                            <label for="example-multiselect">Select your level</label>--}}
{{--                                            <select id="example-multiselect" multiple="" class="form-control" required>--}}
{{--                                                <option>Level 1</option>--}}
{{--                                                <option>Level 2</option>--}}
{{--                                                <option>Level 3</option>--}}
{{--                                                <option>Level 4</option>--}}
{{--                                                <option>Level 5</option>--}}
{{--                                            </select>--}}
{{--                                            <div class="invalid-feedback">Please select one option</div>--}}
{{--                                        </div>--}}
{{--                                        <div class="custom-file mb-3">--}}
{{--                                            <input type="file" class="custom-file-input" id="validatedCustomFile" required>--}}
{{--                                            <label class="custom-file-label" for="validatedCustomFile">Choose file...</label>--}}
{{--                                            <div class="invalid-feedback">Example invalid custom file feedback</div>--}}
{{--                                        </div>--}}
{{--                                        <div class="form-group">--}}
{{--                                            <div class="form-check">--}}
{{--                                                <input class="form-check-input" type="checkbox" value="" id="invalidCheck" required>--}}
{{--                                                <label class="form-check-label" for="invalidCheck"> Agree to terms and conditions </label>--}}
{{--                                                <div class="invalid-feedback"> You must agree before submitting. </div>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
                                        <button class="btn btn-primary" type="submit">{{__('admin/labels.create')}}</button>
                                        </div>
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

