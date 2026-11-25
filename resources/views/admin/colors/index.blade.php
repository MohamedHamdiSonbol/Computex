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
                            <div class="alert alert-success alert-dismissible fade show shadow-sm d-none" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
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
                                            <th>{{__('admin/labels.state')}}</th>
                                            <th>{{__('admin/labels.actions')}}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @isset($colors)
                                            @foreach($colors as  $color)


                                        <tr>


                                            <td>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="d1">
                                                    <label class="custom-control-label" for="d1"></label>
                                                </div>
                                            </td>

                                            <td>{{$color->id}}</td>

                                            <td>
                                                <span class="text-uppercase small font-weight-bold">{{ $color->name }}</span>
                                            </td>


                                            <td>
                                                <span class="badge {{ $color->is_active == 1 ? 'badge-success' : 'badge-danger' }} pt-2">{{$color->active_text}}</span>
                                            </td>

                                            <td>
                                                <div class="d-flex justify-content-start ">
                                                    <a href="{{ route('admin.colors.edit', $color->id) }}"
                                                       class="btn btn-sm btn-warning mr-2 shadow-sm text-white">
                                                        <i class="fe fe-edit fe-12"></i> {{__('admin/labels.edit')}}
                                                    </a>

                                                    <form action="{{ route('admin.colors.destroy', $color->id) }}"
                                                          method="POST"
                                                          onsubmit="return confirm('هل أنت متأكد من حذف هذه اللغة؟')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger mr-2  shadow-sm">
                                                            <i class="fe fe-trash-2 fe-12"></i> {{__('admin/labels.delete')}}
                                                        </button>
                                                    </form>

                                                    <button class="btn btn-sm toggle-status-btn {{ $color->is_active ? 'btn-secondary' :  'btn-success' }}"
                                                            data-id="{{ $color->id }}"
                                                            data-url="{{ route('admin.colors.toggleStatus', $color->id) }}">
                                                        <i class="fe {{ $color->is_active ? 'fe-eye-off' :  'fe-eye' }}"></i>
                                                        <span class="status-text">{{ $color->is_active ? __('admin/labels.deactivate') : __('admin/labels.activate') }}</span>
                                                    </button>

{{--                                                    <button class="btn btn-sm truncate-btn {{ $brand->products()->count() > 0 ? 'btn-info' : 'd-none' }}"--}}
{{--                                                            data-id="{{ $brand->id }}"--}}
{{--                                                            data-url="{{ route('admin.categories.truncate', $brand->id) }}">--}}
{{--                                                        <i class="fe {{ $category->active ? 'fe-eye-off' :  'fe-eye' }}"></i>--}}
{{--                                                        <span class="status-text">{{ $brand->products()->count() > 0 ? 'تفريغ' :  'فارغ' }}</span>--}}
{{--                                                    </button>--}}

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

    </main> <!-- main -->

@endsection

@section('JS_Content')
    <script>
        $(document).on('click', '.toggle-status-btn', function (e) {
            e.preventDefault();

            let btn = $(this);
            let url = btn.data('url');

            $.ajax({
                url: url,
                type: 'PATCH',
                data: { _token: '{{ csrf_token() }}' },
                success: function (response) {

                    if (response.success) {

                        // 1️⃣ Toggle button style
                        btn.toggleClass('btn-success btn-secondary');
                        btn.find('i').toggleClass('fe-eye fe-eye-off');
                        btn.find('.status-text')
                            .text(response.is_active ? 'Inactive' : 'Active' );

                        // 2️⃣ Traverse to same row and update badge
                        let row = btn.closest('tr');          // go up
                        let badge = row.find('.badge');       // find inside row

                        if (response.is_active) {
                            badge
                                .removeClass('badge-danger')
                                .addClass('badge-success')
                                .text('مفعل');
                        } else {
                            badge
                                .removeClass('badge-success')
                                .addClass('badge-danger')
                                .text('غير مفعل');
                        }
                    }
                }
            });
        });
{{--///////////////////////////////////////////////////////////////////////////////////////////////////////--}}
{{--///////////////////////////////////////////////////////////////////////////////////////////////////////--}}
{{--        $(document).on('click', '.truncate-btn', function (e) {--}}
{{--            e.preventDefault();--}}

{{--            let btn = $(this);--}}
{{--            let url = btn.data('url');--}}
{{--            let message = $('.alert-success');--}}

{{--            $.ajax({--}}
{{--                url: url,--}}
{{--                type: 'DELETE',--}}
{{--                data: { _token: '{{ csrf_token() }}' },--}}
{{--                success: function (response) {--}}

{{--                    if (response.success) {--}}
{{--                        message.text(response.message)--}}
{{--                        message.removeClass('d-none')--}}
{{--                        btn.toggleClass('btn-info d-none');--}}
{{--                        setTimeout(function() {--}}
{{--                            message.fadeOut(function() {--}}
{{--                                $(this).addClass('d-none');--}}
{{--                                $(this).text('');--}}
{{--                            });--}}
{{--                        }, 3000);--}}
{{--                    }--}}
{{--                }--}}
{{--            });--}}
{{--        });--}}
    </script>
@endsection
