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
                                            <th class="h4 font-weight-bold">ID</th>
                                            <th class="h4 font-weight-bold"> {{__('admin/labels.attributes')}}</th>
                                            <th class="h4 font-weight-bold">{{__('admin/labels.state')}}</th>
                                            <th class="h4 font-weight-bold">{{__('admin/labels.actions')}}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @isset($attributes)
                                            @foreach($attributes as  $attribute)

{{--@dd ($attribute)--}}
                                        <tr>

                                            <td>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="d1">
                                                    <label class="custom-control-label" for="d1"></label>
                                                </div>
                                            </td>

                                            <td>{{$attribute->id}}</td>


                                            <td>
                                                <span class="text-uppercase small font-weight-bold">{{ $attribute->translation->name}}</span>
                                            </td>


                                            <td>
                                                <span class="badge {{ $attribute->active == 1 ? 'badge-success' : 'badge-danger' }} pt-2">{{$attribute->active_text}}</span>
                                            </td>


                                            <td>
                                                <div class="d-flex justify-content-start ">
                                                    <a href="{{ route('admin.attributes.edit', $attribute->id) }}"
                                                       class="btn btn-sm btn-warning mr-2 shadow-sm text-white font-weight-bold">
                                                        <i class="fe fe-edit fe-12"></i> {{__('admin/labels.edit')}}
                                                    </a>

                                                    <a href="{{ route('admin.attribute_values.index', $attribute->id) }}"
                                                       class="btn btn-sm btn-info mr-2 shadow-sm text-white font-weight-bold">
                                                        <i class="fe fe-edit fe-12"></i> {{__('admin/labels.value_management')}}
                                                    </a>

                                                    <form action="{{ route('admin.attributes.destroy', $attribute->id) }}"
                                                          method="POST"
                                                          onsubmit="return confirm('هل أنت متأكد من حذف هذه الخاصية؟')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm mr-2 btn-danger shadow-sm font-weight-bold ">
                                                            <i class="fe fe-trash-2 fe-12"></i> {{__('admin/labels.delete')}}
                                                        </button>
                                                    </form>

                                                    <button class="btn btn-sm  toggle-status-btn {{ $attribute->active ? 'btn-secondary' :  'btn-success' }} font-weight-bold"
                                                            data-id="{{ $attribute->id }}"
                                                            data-url="{{ route('admin.products.toggleStatus', $attribute->id) }}">
                                                        <i class="fe {{ $attribute->active ? 'fe-eye-off' :  'fe-eye' }}"></i>
                                                        <span class="status-text">{{ $attribute->active ? __('admin/labels.deactivate') :  __('admin/labels.activate')  }}</span>
                                                    </button>

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
{{--    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>--}}
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
                            .text(response.active ? 'Inactive' : 'Active' );

                        // 2️⃣ Traverse to same row and update badge
                        let row = btn.closest('tr');          // go up
                        let badge = row.find('.badge');       // find inside row

                        if (response.active) {
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
    </script>
@endsection
