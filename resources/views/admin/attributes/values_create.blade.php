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
                                    <form  method="POST" action="{{route('admin.attribute_values.store', request()->route('attribute'))}}">
                                        @csrf

                                        <div class="form-row align-items-end justify-content-center">

                                            <div class="col-md-6">
                                                <button class="btn btn-primary form-control mb-3" type="button" id="add_row"> {{__('admin/labels.add_row')}}</button>
                                            </div>

                                        </div>


                                        @if(count(get_active_languages()) > 0)
                                            <div id="attribute-values-container">
                                                <div class="form-row">

                                                @foreach(get_active_languages() as $index => $lang)
                                                        <div class="col-md-6 mb-3">
                                                            <label>{{__('admin/labels.name').' '. __('admin/labels.'.$lang->abbr) }}</label>
                                                            <input type="text" class="form-control"
                                                                   name="attribute_value_translations[{{ $index }}][value]"
                                                                   value="{{ old('attribute_value_translations.'.$index.'.value') }}">
                                                        <input type="hidden" name="attribute_value_translations[{{ $index }}][language_id]" value="{{ $lang->id }}">
                                                    </div>
                                                @endforeach
                                                </div>

                                            </div>

                                        @endif

                                        <button class="btn btn-primary" type="submit">{{__('admin/labels.create')}}</button>
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
        let nextIndex = {{ count(get_active_languages()) }};

        document.getElementById('add_row').addEventListener('click', function() {
            const container = document.getElementById('attribute-values-container');

            // Create one row container
            const row = document.createElement('div');
            row.classList.add('form-row');

            @foreach(get_active_languages() as $lang)
                row.innerHTML += `
        <div class="col-md-6 mb-3">
            <label>{{__('admin/labels.name').' '. __('admin/labels.'.$lang->abbr) }}</label>
            <input type="text" class="form-control"
                   name="attribute_value_translations[${nextIndex}][value]">

            <input type="hidden" name="attribute_value_translations[${nextIndex}][language_id]" value="{{ $lang->id }}">
        </div>`;

            nextIndex++; // increment for next row
            container.appendChild(row);
            @endforeach
        });
    </script>
@endsection

