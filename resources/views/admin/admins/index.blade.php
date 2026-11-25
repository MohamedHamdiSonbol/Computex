@extends('layouts.admin')

@section('main')

    <main role="main" class="main-content">
        <div class="container-fluid">
            <div class="row justify-content-center">

                <div class="col-12">
                    <h2 class="page-title">Basic table</h2>
                    <p> Tables with built-in bootstrap styles </p>

                    <div class="row">
                        <!-- Striped rows -->
                        <div class="col-md-12 my-4">
                            @include('admin.includes.alerts.success')
                            @include('admin.includes.alerts.errors')
                            <div class="card shadow">
                                <div class="card-body">
                                    <h5 class="card-title">Striped rows</h5>
                                    <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                                    <table class="table table-striped table-hover">
                                        <thead>
                                        <tr>
                                            <th>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="chall">
                                                    <label class="custom-control-label" for="d1"></label>
                                                </div>
                                            </th>
                                            <th>ID</th>
                                            <th>{{__('admin/labels.name')}}</th>
                                            <th>{{__('admin/labels.email')}}</th>
                                            <th>{{__('admin/labels.role')}}</th>
                                            <th>{{__('admin/labels.actions')}}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @isset($admins)
                                            @foreach($admins as  $admin)

{{--@dd ($product)--}}
                                        <tr>

                                            <td>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="d1">
                                                    <label class="custom-control-label" for="d1"></label>
                                                </div>
                                            </td>

                                            <td>{{$admin->id}}</td>


                                            <td>
                                                <span class="text-uppercase small font-weight-bold">{{ $admin->name}}</span>
                                            </td>


                                            <td>
                                                <span class="text-uppercase small font-weight-bold">{{ $admin->email}}</span>
                                            </td>

                                            <td>
                                                <span class="text-uppercase small font-weight-bold">{{ $admin->role->display_name}}</span>
                                            </td>


                                            <td>
                                                <div class="d-flex justify-content-start ">
                                                    @can('edit-admins')
                                                        <a href="{{ route('admin.admins.edit', $admin->id) }}"
                                                           class="btn btn-sm btn-warning mr-2 shadow-sm text-white">
                                                            <i class="fe fe-edit fe-12"></i> تعديل
                                                        </a>
                                                    @endcan


                                                    @can('delete-admins')
                                                        <form action="{{ route('admin.admins.destroy', $admin->id) }}"
                                                              method="POST"
                                                              onsubmit="return confirm('هل أنت متأكد من حذف هذه اللغة؟')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm mr-2 btn-danger shadow-sm">
                                                                <i class="fe fe-trash-2 fe-12"></i> حذف
                                                            </button>
                                                        </form>
                                                    @endcan

                                                </div>
                                            </td>
                                        </tr>
                                            @endforeach
                                        @endisset
                                        <tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div> <!-- Striped rows -->
                    </div> <!-- end section -->

                </div> <!-- .col-12 -->
            </div> <!-- .row -->
        </div> <!-- .container-fluid -->

        <div class="modal fade modal-notif modal-slide" tabindex="-1" role="dialog" aria-labelledby="defaultModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="defaultModalLabel">Notifications</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="list-group list-group-flush my-n3">
                            <div class="list-group-item bg-transparent">
                                <div class="row align-items-center">
                                    <div class="col-auto">
                                        <span class="fe fe-box fe-24"></span>
                                    </div>
                                    <div class="col">
                                        <small><strong>Package has uploaded successfull</strong></small>
                                        <div class="my-0 text-muted small">Package is zipped and uploaded</div>
                                        <small class="badge badge-pill badge-light text-muted">1m ago</small>
                                    </div>
                                </div>
                            </div>
                            <div class="list-group-item bg-transparent">
                                <div class="row align-items-center">
                                    <div class="col-auto">
                                        <span class="fe fe-download fe-24"></span>
                                    </div>
                                    <div class="col">
                                        <small><strong>Widgets are updated successfull</strong></small>
                                        <div class="my-0 text-muted small">Just create new layout Index, form, table</div>
                                        <small class="badge badge-pill badge-light text-muted">2m ago</small>
                                    </div>
                                </div>
                            </div>
                            <div class="list-group-item bg-transparent">
                                <div class="row align-items-center">
                                    <div class="col-auto">
                                        <span class="fe fe-inbox fe-24"></span>
                                    </div>
                                    <div class="col">
                                        <small><strong>Notifications have been sent</strong></small>
                                        <div class="my-0 text-muted small">Fusce dapibus, tellus ac cursus commodo</div>
                                        <small class="badge badge-pill badge-light text-muted">30m ago</small>
                                    </div>
                                </div> <!-- / .row -->
                            </div>
                            <div class="list-group-item bg-transparent">
                                <div class="row align-items-center">
                                    <div class="col-auto">
                                        <span class="fe fe-link fe-24"></span>
                                    </div>
                                    <div class="col">
                                        <small><strong>Link was attached to menu</strong></small>
                                        <div class="my-0 text-muted small">New layout has been attached to the menu</div>
                                        <small class="badge badge-pill badge-light text-muted">1h ago</small>
                                    </div>
                                </div>
                            </div> <!-- / .row -->
                        </div> <!-- / .list-group -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-block" data-dismiss="modal">Clear All</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade modal-shortcut modal-slide" tabindex="-1" role="dialog" aria-labelledby="defaultModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="defaultModalLabel">Shortcuts</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body px-5">
                        <div class="row align-items-center">
                            <div class="col-6 text-center">
                                <div class="squircle bg-success justify-content-center">
                                    <i class="fe fe-cpu fe-32 align-self-center text-white"></i>
                                </div>
                                <p>Control area</p>
                            </div>
                            <div class="col-6 text-center">
                                <div class="squircle bg-primary justify-content-center">
                                    <i class="fe fe-activity fe-32 align-self-center text-white"></i>
                                </div>
                                <p>Activity</p>
                            </div>
                        </div>
                        <div class="row align-items-center">
                            <div class="col-6 text-center">
                                <div class="squircle bg-primary justify-content-center">
                                    <i class="fe fe-droplet fe-32 align-self-center text-white"></i>
                                </div>
                                <p>Droplet</p>
                            </div>
                            <div class="col-6 text-center">
                                <div class="squircle bg-primary justify-content-center">
                                    <i class="fe fe-upload-cloud fe-32 align-self-center text-white"></i>
                                </div>
                                <p>Upload</p>
                            </div>
                        </div>
                        <div class="row align-items-center">
                            <div class="col-6 text-center">
                                <div class="squircle bg-primary justify-content-center">
                                    <i class="fe fe-users fe-32 align-self-center text-white"></i>
                                </div>
                                <p>Users</p>
                            </div>
                            <div class="col-6 text-center">
                                <div class="squircle bg-primary justify-content-center">
                                    <i class="fe fe-settings fe-32 align-self-center text-white"></i>
                                </div>
                                <p>Settings</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main> <!-- main -->

@endsection





{{--@section('JS_Content')--}}
{{--    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>--}}
{{--    <script>--}}
{{--        $(document).on('click', '.toggle-status-btn', function (e) {--}}
{{--            e.preventDefault();--}}

{{--            let btn = $(this);--}}
{{--            let url = btn.data('url');--}}

{{--            $.ajax({--}}
{{--                url: url,--}}
{{--                type: 'PATCH',--}}
{{--                data: { _token: '{{ csrf_token() }}' },--}}
{{--                success: function (response) {--}}

{{--                    if (response.success) {--}}

{{--                        // 1️⃣ Toggle button style--}}
{{--                        btn.toggleClass('btn-success btn-secondary');--}}
{{--                        btn.find('i').toggleClass('fe-eye fe-eye-off');--}}
{{--                        btn.find('.status-text')--}}
{{--                            .text(response.active ? 'Inactive' : 'Active' );--}}

{{--                        // 2️⃣ Traverse to same row and update badge--}}
{{--                        let row = btn.closest('tr');          // go up--}}
{{--                        let badge = row.find('.badge');       // find inside row--}}

{{--                        if (response.active) {--}}
{{--                            badge--}}
{{--                                .removeClass('badge-danger')--}}
{{--                                .addClass('badge-success')--}}
{{--                                .text('مفعل');--}}
{{--                        } else {--}}
{{--                            badge--}}
{{--                                .removeClass('badge-success')--}}
{{--                                .addClass('badge-danger')--}}
{{--                                .text('غير مفعل');--}}
{{--                        }--}}
{{--                    }--}}
{{--                }--}}
{{--            });--}}
{{--        });--}}
{{--    </script>--}}
{{--@endsection--}}
