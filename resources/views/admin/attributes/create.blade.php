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
                                    <form  method="POST" action="{{route('admin.attributes.store')}}" enctype="multipart/form-data">
                                        @csrf
                                        <div class="form-row">

                                        @if(count(get_active_languages()) > 0)

                                            @foreach(get_active_languages() as $index => $lang)


                                                    <div class="col-md-6 mb-3">
                                                        <label for="validationCustomName{{$index}}">{{__('admin/labels.name').' '. __('admin/labels.'.$lang->abbr) }}</label>
                                                        <input type="text" class="form-control @error("attribute_translations.$index.name") is-invalid @enderror" id="validationCustomName{{$index}}" name="attribute_translations[{{$index}}][name]" value="{{ old('attribute_translations.'.$index.'.name') }}">
                                                        @error("attribute_translations.$index.name")
                                                        <div class="invalid-feedback" style="display: block;">
                                                            {{ $message }}
                                                        </div>
                                                        @enderror
                                                    </div>

                                                    <input type="hidden" class="form-control" name="attribute_translations[{{$index}}][language_id]" value="{{ $lang->id}}" readonly>


                                            @endforeach
                                        @endif
                                        </div>

                                        <div class="form-row">
                                            <div class="col-md-12 mx-auto mb-3">
                                                <p class="mb-3">{{__('admin/labels.active')}}</p>
                                                <div class="custom-control custom-switch">
                                                    <input type="checkbox" class="custom-control-input   @error("attribute.active") is-invalid @enderror" id="customSwitch" name="attribute[active]" value="1" {{ old('attribute.active') ? 'checked' : '' }}>
                                                    <label class="custom-control-label" for="customSwitch">{{__('admin/labels.yes')}}</label>
                                                </div>
                                                @error("attribute.active")
                                                <div class="invalid-feedback" style="display: block;">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>
                                        </div>

                                        <button class="btn btn-primary" type="submit">{{__('admin/labels.create')}}</button>
                                    </form>

                                </div> <!-- /.card-body -->
                            </div> <!-- /.card -->








{{--                            <div class="card shadow mt-4">--}}
{{--                                <div class="card-header">--}}
{{--                                    <strong class="card-title">Default Validation</strong>--}}
{{--                                </div>--}}
{{--                                <div class="card-body">--}}
{{--                                    <form  method="POST" action="{{route('admin.attribute_values.store')}}">--}}
{{--                                        @csrf--}}

{{--                                        <div class="form-row align-items-end justify-content-center">--}}

{{--                                            <div class="col-md-6 mb-3">--}}
{{--                                                <label for="validationCustomAttribute">اختار الخاصية  - {{ __('messages.'.get_active_lang()) }}</label>--}}
{{--                                                <select class="form-control @error("attribute.attribute_id") is-invalid @enderror " name="attribute[attribute_id]" >--}}
{{--                                                    @if(count($attributes) > 0)--}}
{{--                                                        @foreach($attributes as $attribute)--}}
{{--                                                            <option value="{{$attribute->id}}" {{ old('attribute.attribute_id') == $attribute->id ? 'selected' : '' }}>{{$attribute->translation->name}}</option>--}}
{{--                                                        @endforeach--}}
{{--                                                    @endif--}}
{{--                                                </select>--}}
{{--                                                <div class="valid-feedback"> Looks good! </div>--}}
{{--                                                @error("attribute.attribute_id")--}}
{{--                                                <div class="invalid-feedback" style="display: block;">--}}
{{--                                                    {{ $message }}--}}
{{--                                                </div>--}}
{{--                                                @enderror--}}
{{--                                            </div>--}}

{{--                                            <div class="col-md-2">--}}
{{--                                                <button class="btn btn-primary form-control mb-3" type="button" id="add_row">Add Row</button>--}}
{{--                                            </div>--}}

{{--                                        </div>--}}


{{--                                        @if(count(get_active_languages()) > 0)--}}
{{--                                            <div id="attribute-values-container">--}}
{{--                                                <div class="form-row">--}}

{{--                                                @foreach(get_active_languages() as $index => $lang)--}}
{{--                                                        <div class="col-md-6 mb-3">--}}
{{--                                                            <label>إضافة قيم جديدة - {{ __('messages.'.$lang->abbr) }}</label>--}}
{{--                                                            <input type="text" class="form-control"--}}
{{--                                                                   name="attribute_value_translations[{{ $index }}][value]"--}}
{{--                                                                   value="{{ old('attribute_value_translations.'.$index.'.value') }}">--}}
{{--                                                        <input type="hidden" name="attribute_value_translations[{{ $index }}][language_id]" value="{{ $lang->id }}">--}}
{{--                                                    </div>--}}
{{--                                                @endforeach--}}
{{--                                                </div>--}}

{{--                                            </div>--}}

{{--                                        @endif--}}

{{--                                        <button class="btn btn-primary" type="submit">Submit form</button>--}}
{{--                                    </form>--}}

{{--                                </div> <!-- /.card-body -->--}}
{{--                            </div> <!-- /.card -->--}}
                        </div> <!-- /.col -->
                    </div> <!-- end section -->
                </div> <!-- /.col-12 col-lg-10 col-xl-10 -->
            </div> <!-- .row -->
        </div> <!-- .container-fluid -->
    </main>

    <script>
        let nextIndex = {{ count(get_active_languages()) }};

        document.getElementById('add_row').addEventListener('click', function() {
            const container = document.getElementById('attribute-values-container');

            // Create one row container
            const row = document.createElement('div');
            row.classList.add('form-row');

            @foreach(get_active_languages() as $lang)
                row.innerHTML += `
        <div class="col-md-6 mb-3">
            <label>إضافة قيم جديدة - {{ __('messages.'.$lang->abbr) }}</label>
            <input type="text" class="form-control"
                   name="attribute_value_translations[${nextIndex}][value]">

            <input type="hidden" name="attribute_value_translations[${nextIndex}][language_id]" value="{{ $lang->id }}">
        </div>
    `;
            nextIndex++; // increment for next row
            container.appendChild(row);
            @endforeach
        });
    </script>
@endsection

