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

{{--                                    @if ($errors->any())--}}
{{--                                        <div class="alert alert-danger">--}}
{{--                                            <ul>--}}
{{--                                                @foreach ($errors->all() as $error)--}}
{{--                                                    <li>{{ $error }}</li>--}}
{{--                                                @endforeach--}}
{{--                                            </ul>--}}
{{--                                        </div>--}}
{{--                                    @endif--}}

                                    <form  method="POST" action="{{route('admin.permissions.store')}}">
                                        @csrf




{{--                                                <div class="form-row align-items-end mb-3">--}}
{{--                                                    <div class="col-md-6">--}}
{{--                                                        <label for="validationCustomName0">اسم الصلاحية - {{ __('messages.'.$lang) }}</label>--}}
{{--                                                        <input type="text" class="form-control @error("permission.0.display_name") is-invalid @enderror" id="validationCustomName0" name="permission[0][display_name]" value="{{ old('permission.0.display_name') }}">--}}
{{--                                                        <div class="invalid-feedback"> Please provide a valid city. </div>--}}
{{--                                                        @error("permission.0.display_name")--}}
{{--                                                        <div class="invalid-feedback" style="display: block;">--}}
{{--                                                            {{ $message }}--}}
{{--                                                        </div>--}}
{{--                                                        @enderror--}}
{{--                                                    </div>--}}

{{--                                                    <div class="col-md-3">--}}
{{--                                                        <button class="btn btn-success form-control w-75" type="button" id="add_row">Add Row</button>--}}
{{--                                                    </div>--}}
{{--                                                </div>--}}

{{--                                        <div class="form-row align-items-end mb-3">--}}
                                            <div id="permissions-container" class="w-100  align-items-end mb-3">
                                                @if(old('permission'))
                                                    @foreach(old('permission') as $index => $permission)
                                                        <div class="form-row align-items-center parent_row">

                                                            <div class="col-md-6 mb-3">
                                                                <label for="validationCustomName{{ $index }}">{{__('admin/labels.name').'  باللغة الانجليزية'}}</label>
                                                                <input type="text"
                                                                       class="form-control @error("permission.$index.display_name") is-invalid @enderror"
                                                                       id="validationCustomName{{ $index }}"
                                                                       name="permission[{{ $index }}][display_name]"
                                                                       value="{{ $permission['display_name'] ?? '' }}">

                                                                @error("permission.$index.display_name")
                                                                <div class="invalid-feedback" style="display: block;">
                                                                    {{ $message }}
                                                                </div>
                                                                @enderror
                                                            </div>

                                                            @if($index == 0)
                                                                <div class="col-md-3 mb-1">
                                                                    <button class="btn btn-success form-control w-75" type="button" id="add_row">{{__('admin/labels.add_row')}}</button>
                                                                </div>
                                                            @else
                                                                <div class="col-md-3 mb-1">
                                                                    <button type="button" class="btn btn-danger w-75 remove_row">{{__('admin/labels.remove_row')}} </button>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    @endforeach


                                                @else
                                                    <div class="form-row align-items-end mb-3">
                                                        <div class="col-md-6">
                                                            <label for="validationCustomName0">{{__('admin/labels.name') .' باللغة الانجليزية ' }}</label>
                                                            <input type="text" class="form-control @error("permission.0.display_name") is-invalid @enderror" id="validationCustomName0" name="permission[0][display_name]" value="{{ old('permission.0.display_name') }}">
                                                            @error("permission.0.display_name")
                                                            <div class="invalid-feedback" style="display: block;">
                                                                {{ $message }}
                                                            </div>
                                                            @enderror
                                                        </div>

                                                        <div class="col-md-3">
                                                            <button class="btn btn-success form-control w-75" type="button" id="add_row">{{__('admin/labels.add_row')}}</button>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
{{--                                        </div>--}}

                                        <button class="btn btn-primary col-md-12" type="submit">{{__('admin/labels.create')}}</button>
                                    </form>
                                </div> <!-- /.card-body -->
                            </div> <!-- /.card -->
                        </div> <!-- /.col -->
                    </div> <!-- end section -->
                </div> <!-- /.col-12 col-lg-10 col-xl-10 -->
            </div> <!-- .row -->
        </div> <!-- .container-fluid -->
    </main>

    <script>
        let nextIndex = 1;
        const addRowBtn = document.getElementById('add_row');
        addRowBtn.addEventListener('click', function() {
            const container = document.getElementById('permissions-container');

            // console.log(container)
            const row = document.createElement('div');
            row.classList.add('form-row', 'align-items-end', 'mb-3', 'parent_row');
            row.innerHTML += `
             <div class="col-md-6 ">
                <label for="validationCustomName${nextIndex}">اسم الصلاحية - {{ __('messages.'.$lang) }}</label>
                <input type="text" class="form-control" id="validationCustomName${nextIndex}" name="permission[${nextIndex}][display_name]" value="">
            </div>

            <div class="col-md-3">
                <button type="button" class="btn btn-danger w-75 remove_row">Remove Row</button>
            </div>
            `;
            console.log(container);
            nextIndex++; // increment for next row
            container.appendChild(row);
        });

        document.addEventListener('click', function(event) {
            const removeRowBtn = event.target.closest('.remove_row');
            console.log(removeRowBtn);
            if(removeRowBtn) {
                console.log()
                removeRowBtn.closest('.parent_row').remove();
            }
        })
    </script>
@endsection

