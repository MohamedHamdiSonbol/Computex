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
                                    <form  method="POST" action="{{route('admin.attributes.update', $attribute->id)}}" enctype="multipart/form-data">
                                        @csrf
                                        @method('PATCH')

                                            @if(count($attribute['translations']) > 0)
                                                @foreach($attribute['translations'] as $index => $translation)
                                                @php
                                                    $lang = $translation['language']['abbr'];
                                                @endphp
                                                <div class="form-row">

                                                    <div class="col-md-6 mb-3">
                                                        <label for="validationCustomAttrName{{$index}}">{{__('admin/labels.active').' '. __('admin/labels.'.$lang) }}</label>
                                                        <input type="text" class="form-control @error("attribute_translations.$index.name") is-invalid @enderror" id="validationCustomAttrName{{$index}}" name="attribute_translations[{{$index}}][name]" value="{{ old("attribute_translations.$index.name", $translation->name) }}" required>
                                                        <div class="valid-feedback"> Looks good! </div>
                                                        @error("attribute_translations.$index.name")
                                                        <div class="invalid-feedback" style="display: block;">
                                                            {{ $message }}
                                                        </div>
                                                        @enderror
                                                    </div>


                                                    <input type="hidden" class="form-control" name="attribute_translations[{{$index}}][language_id]" value="{{$translation->language_id}}" readonly>
                                                </div>
                                                @endforeach
                                            @endif

                                        <div class="form-row">

                                        <div class="col-md-12 mx-auto mb-3">
                                            <p class="mb-3">{{__('admin/labels.active')}}</p>
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" class="custom-control-input  @error("attribute.active") is-invalid @enderror"  id="customSwitch1" name="attribute[active]" value="1" @checked(old('active', $attribute->active) == 1)  >
                                                <label class="custom-control-label" for="customSwitch1">{{__('admin/labels.yes')}}</label>
                                                @error("attribute.active")
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














{{--                            <div class="card shadow mb-4">--}}
{{--                                <div class="card-header">--}}
{{--                                    <strong class="card-title">Default Validation</strong>--}}
{{--                                </div>--}}

{{--                                <div class="card-body">--}}
{{--                                    <form  method="POST" action="{{route('admin.attribute_values.update', $attribute->id)}}" >--}}
{{--                                        @csrf--}}
{{--                                        @method('PATCH')--}}

{{--                                            @if(count($values) > 0)--}}
{{--                                                @foreach($values as $index => $value)--}}

{{--                                                @php--}}
{{--                                                    $lang = $translation['language']['abbr'];--}}
{{--                                                @endphp--}}
{{--                                                <div class="form-row">--}}

{{--                                                    @foreach(get_active_languages() as $k => $lang)--}}

{{--                                                    <div class="col-md-6 mb-3">--}}
{{--                                                        <label for="validationCustomAttrValue{{$index}}{{$k}}">اسم القيمة - {{ __('messages.'.$lang->abbr) }}</label>--}}
{{--                                                        <input type="text" class="form-control @error("attribute_value_translations.$index.value") is-invalid @enderror" id="validationCustomAttrValue{{$index}}{{$k}}" name="attribute_value_translations[{{$index}}][{{$k}}][value]" value="{{ old("attribute_value_translations.$index.value", $value['translations'][$k]['value']) }}" required>--}}
{{--                                                        <div class="valid-feedback"> Looks good! </div>--}}
{{--                                                        @error("attribute_value_translations.$index.$k.value")--}}
{{--                                                        <div class="invalid-feedback" style="display: block;">--}}
{{--                                                            {{ $message }}--}}
{{--                                                        </div>--}}
{{--                                                        @enderror--}}
{{--                                                    </div>--}}


{{--                                                    <input type="hidden" class="form-control" name="attribute_value_translations[{{$index}}][{{$k}}][language_id]" value="{{$value['translations'][$k]['language_id']}}" readonly>--}}

{{--                                                    @endforeach--}}
{{--                                                </div>--}}
{{--                                                @endforeach--}}
{{--                                            @endif--}}

{{--                                        <div class="form-row">--}}

{{--                                            <button class="btn btn-primary" type="submit">Submit form</button>--}}
{{--                                        </div>--}}
{{--                                    </form>--}}
{{--                                </div> <!-- /.card-body -->--}}
{{--                            </div> <!-- /.card -->--}}
                        </div> <!-- /.col -->
                    </div> <!-- end section -->
                </div> <!-- /.col-12 col-lg-10 col-xl-10 -->
            </div> <!-- .row -->
        </div> <!-- .container-fluid -->
    </main>
@endsection

