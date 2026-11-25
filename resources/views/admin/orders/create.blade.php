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
                                    <form  method="POST" action="{{route('admin.products.store')}}" enctype="multipart/form-data">
                                        @csrf
                                        <div class="form-row">
                                            <div class="col-md-12 mb-3">
                                                <label for="validationCustomPhoto">photo</label>
                                                <input type="file" class="form-control @error("product.photo") is-invalid @enderror" id="validationCustomPhoto" name="product[photo]" >
                                                <div class="valid-feedback"> Looks good! </div>
                                                @error("product.photo")
                                                <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        @if(count(get_active_languages()) > 0)
                                            @foreach(get_active_languages() as $index => $lang)

                                                <div class="form-row">

                                                    <div class="col-md-6 mb-3">
                                                        <label for="validationCustomName{{$index}}">اسم المنتج - {{ __('messages.'.$lang->abbr) }}</label>
                                                        <input type="text" class="form-control @error("product_translations.$index.name") is-invalid @enderror" id="validationCustomName{{$index}}" name="product_translations[{{$index}}][name]" value="{{ old('product_translations.'.$index.'.name') }}">
                                                        <div class="invalid-feedback"> Please provide a valid city. </div>
                                                        @error("product_translations.$index.name")
                                                        <div class="invalid-feedback" style="display: block;">
                                                            {{ $message }}
                                                        </div>
                                                        @enderror
                                                    </div>


                                                    <div class="col-md-6 mb-3">
                                                        <label for="validationCustomDesc{{$index}}">وصف المنتج  - {{ __('messages.'.$lang->abbr) }}</label>
                                                        <input type="text" class="form-control @error("product_translations.$index.description") is-invalid @enderror" id="validationCustomDesc{{$index}}" name="product_translations[{{$index}}][description]" value="{{ old('product_translations.'.$index.'.description') }}" >
                                                        <div class="valid-feedback"> Looks good! </div>
                                                        @error("product_translations.$index.description")
                                                        <div class="invalid-feedback" style="display: block;">
                                                            {{ $message }}
                                                        </div>
                                                        @enderror
                                                    </div>

                                                    <input type="hidden" class="form-control" name="product_translations[{{$index}}][language_id]" value="{{ $lang->id}}" readonly>

                                                </div>
                                            @endforeach
                                        @endif

                                        <div class="form-row">
                                            <div class="col-md-4 mb-3">
                                                <label for="validationCustomQuant">الكمية  - {{ __('messages.'.get_active_lang()) }}</label>
                                                <input type="number" class="form-control @error("product.quantity") is-invalid @enderror" id="validationCustomQuant" name="product[quantity]" value="{{ old('product.quantity') }}" >
                                                <div class="valid-feedback"> Looks good! </div>
                                                @error("product.quantity")
                                                <div class="invalid-feedback" style="display: block;">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>

                                            <div class="col-md-4 mb-3">
                                                <label for="validationCustomPrice">السعر  - {{ __('messages.'.get_active_lang()) }} </label>
                                                <input type="number" class="form-control @error("product.price") is-invalid @enderror" id="validationCustomPrice" name="product[price]" value="{{ old('product.price') }}" min="0" step="0.01" >
                                                <div class="valid-feedback"> Looks good! </div>
                                                @error("product.price")
                                                <div class="invalid-feedback" style="display: block;">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>

                                            <div class="col-md-4 mb-3">
                                                <label for="validationCustomCategory">اختار القسم  - {{ __('messages.'.get_active_lang()) }}</label>
                                                <select class="form-control @error("product.category_id") is-invalid @enderror " name="product[category_id]" >
                                                    @if(count($categories) > 0)
                                                        @foreach($categories as $category)
                                                            <option value="{{$category->id}}" {{ old('product.category_id') == $category->id ? 'selected' : '' }}>{{$category->translation->name}}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                                <div class="valid-feedback"> Looks good! </div>
                                                @error("product.category")
                                                    <div class="invalid-feedback" style="display: block;">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>

                                        </div>

                                        <div class="form-row">

                                            <div class="col-md-12 mx-auto mb-3">
                                                <p class="mb-3">Active</p>
                                                <div class="custom-control custom-switch">
                                                    <input type="checkbox" class="custom-control-input" id="customSwitch" name="product[active]" value="1" {{ old('product.active') ? 'checked' : '' }}>
                                                    <label class="custom-control-label" for="customSwitch">Yes</label>
                                                </div>

                                            </div>
                                        </div>

                                        <button class="btn btn-warning mb-4"  id="manage_attr" type="button"> Add Attributes </button>

                                        <button class="btn btn-warning mb-4 d-none"  id="remove_attr" type="button"> Remove Attributes </button>



                                        <div class="form-row mb-4 align-items-end" id="attr_container">

{{--                                            <div class="col-md-3 mx-auto" id="">--}}
{{--                                                <label for="attr_names">اختار الخاصية  - {{ __('messages.'.get_active_lang()) }}   </label>--}}
{{--                                                <select class="form-control" id="attr_names" onchange="getAttrValues(this)">--}}
{{--                                                    <option value='' selected disabled>اختر...</option>--}}
{{--                                                    <option value='5'  >shit...</option>--}}
{{--                                                </select>--}}
{{--                                            </div>--}}

{{--                                            @foreach(get_active_languages() as $index => $lang)--}}

{{--                                            <div class="col-md-3 mx-auto" id="">--}}
{{--                                                <label for="attr_values{{$index}}">اختار القيمة  - {{ __('messages.'.$lang->abbr) }}</label>--}}
{{--                                                <select class="form-control" id="attr_values_{{$lang->abbr}}">--}}
{{--                                                    <option value='' selected disabled>اختر...</option>--}}
{{--                                                </select>--}}

{{--                                                <input type="hidden" class="form-control" name="attribute_values[{{$index}}][language_id]" value="{{ $lang->id}}" readonly>--}}
{{--                                            </div>--}}


{{--                                            @endforeach--}}

{{--                                            <div class="col-md-2 mx-auto">--}}
{{--                                            <button class="btn btn-success " id="add_row" type="button"> Add Row</button>--}}
{{--                                            </div>--}}

                                        </div>


                                        <button class="btn btn-primary col-md-12" type="submit">Submit form</button>
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
    let manageAttrBtn = document.getElementById("manage_attr");
    let removeAttrBtn = document.getElementById("remove_attr");
    let attrContainer = document.getElementById("attr_container");
    let attrNamesSelect;
    let attrValuesSelect;
    let attrId;
    let index = 0;

    function createAttrInputs(currentIndex) {
        if (currentIndex === 0) {
            attrContainer.innerHTML = '';
        }

        const row = document.createElement('div');
        row.className = 'col-md-12 row align-items-end mb-3 row_parent';

        function createSelectCol(labelText, selectId) {

            const col = document.createElement('div');
            col.className = 'col-md-3';

            const label = document.createElement('label');
            label.className = 'form-label';
            label.textContent = labelText;
            label.id = `${selectId}_${currentIndex}`;

            const select = document.createElement('select');
            select.className = 'form-control';
            select.id = `${selectId}_${currentIndex}`;

            const placeholder = document.createElement('option');
            placeholder.textContent = 'اختر...';
            placeholder.value = '';
            placeholder.disabled = true;
            placeholder.selected = true;

            select.appendChild(placeholder);
            col.appendChild(label);
            col.appendChild(select);

            return { col, select };
        }

        const nameData = createSelectCol('اختار الخاصية', 'attr_names');
        const valueData = createSelectCol('اختار القيمة', 'attr_values');

        valueData.select.name = `attribute_values[${currentIndex}]`;

        const btnCol = document.createElement('div');
        btnCol.className = 'col-md-3';

        const btn = document.createElement('button');
        btn.type = 'button';

        if (currentIndex === 0) {
            btn.className = 'btn btn-success w-75';
            btn.textContent = 'Add Row';

            btn.addEventListener("click", function () {
                index++;
                createAttrInputs(index);
            });

        } else {
            btn.className = 'btn btn-danger w-75';
            btn.textContent = 'Remove Row';

            btn.addEventListener("click", function () {
                row.remove();
            });
        }

        btnCol.appendChild(btn);

        nameData.select.addEventListener("change", function (event) {
            getAttrValues(event.target, valueData.select);
        });

        row.appendChild(nameData.col);
        row.appendChild(valueData.col);
        row.appendChild(btnCol);

        attrContainer.appendChild(row);

        getAttributes(nameData.select);
    }

    /////////////////////////////////////////////////////////////////////////////////////////////////////

    function getAttributes(selectElement) {
        fetch("{{route('admin.attributes.fetchAttributes')}}")
            .then(response => response.json())
            .then(data => {
                console.log(data);
                showData(data, selectElement);
            });
    }

    /////////////////////////////////////////////////////////////////////////////////////////////////////

    function getAttrValues(attrId, targetSelect) {
        let url = "{{ route('admin.attributes.fetchValues', ':attribute') }}".replace(':attribute', attrId.value);

        fetch(url)
            .then(response => response.json())
            .then(data => {
                console.log(data);

                targetSelect.innerHTML = '<option value="" disabled selected>اختر...</option>';
                showData(data, targetSelect);
            });
    }

    /////////////////////////////////////////////////////////////////////////////////////////////////////

    function showData(data, selectInput) {
        data.forEach(item => {
            const option = document.createElement('option');
            option.value = item.id;
            option.textContent = item.translation.name ?? item.translation.value;
            selectInput.appendChild(option);
        });
    }

    /////////////////////////////////////////////////////////////////////////////////////////////////////

    manageAttrBtn.addEventListener("click", function () {
        createAttrInputs(index);
        this.classList.add('d-none');
        removeAttrBtn.classList.remove('d-none');
    });

    /////////////////////////////////////////////////////////////////////////////////////////////////////

    removeAttrBtn.addEventListener("click", function () {
        attrContainer.innerHTML = '';
        manageAttrBtn.classList.remove('d-none');
        this.classList.add('d-none');
        index = 0;
    });
    /////////////////////////////////////////////////////////////////////////////////////////////////////
    {{--const languages = @json(get_active_languages());--}}

    {{--let manageAttrBtn = document.getElementById("manage_attr");--}}
    {{--let attrContainer = document.getElementById("attr_container");--}}
    {{--let rowIndex = 0;--}}

    {{--manageAttrBtn.addEventListener("click", function () {--}}
    {{--    createRow();--}}
    {{--    this.classList.add('d-none');--}}
    {{--});--}}

    {{--function createRow() {--}}

    {{--    const row = document.createElement('div');--}}
    {{--    row.className = 'row col-md-12 mb-3 align-items-end row_parent';--}}

    {{--    // ---------------- attribute select ------------------}}
    {{--    const attrCol = document.createElement('div');--}}
    {{--    attrCol.className = 'col-md-3';--}}

    {{--    const attrLabel = document.createElement('label');--}}
    {{--    attrLabel.textContent = 'اختار الخاصية';--}}

    {{--    const attrSelect = document.createElement('select');--}}
    {{--    attrSelect.className = 'form-control';--}}

    {{--    attrSelect.innerHTML = `<option disabled selected>اختر...</option>`;--}}

    {{--    attrCol.appendChild(attrLabel);--}}
    {{--    attrCol.appendChild(attrSelect);--}}

    {{--    row.appendChild(attrCol);--}}

    {{--    // ---------------- values selects ------------------}}
    {{--    let valueSelects = {};--}}
    {{--    let index = 0;--}}
    {{--    languages.forEach((lang, i) => {--}}
    {{--        const col = document.createElement('div');--}}
    {{--        col.className = 'col-md-2';--}}

    {{--        const label = document.createElement('label');--}}
    {{--        label.textContent = `اختار القيمة - ${lang.abbr}`;--}}

    {{--        const select = document.createElement('select');--}}
    {{--        select.className = 'form-control';--}}
    {{--        select.name = `attribute_values[${rowIndex}][${index}][attribute_value_id]`;--}}
    {{--        select.innerHTML = `<option disabled selected>اختر...</option>`;--}}

    {{--        const langInput = document.createElement('input');--}}
    {{--        langInput.type = 'hidden';--}}
    {{--        langInput.name = `attribute_values[${rowIndex}][${index}][language_id]`;--}}
    {{--        langInput.value = `${lang.id}`;--}}

    {{--        valueSelects[lang.abbr] = select;--}}
    {{--        console.log(valueSelects)--}}

    {{--        col.appendChild(label);--}}
    {{--        col.appendChild(select);--}}
    {{--        col.appendChild(langInput);--}}

    {{--        row.appendChild(col);--}}
    {{--        index++;--}}
    {{--    });--}}

    {{--    // ---------------- buttons ------------------}}
    {{--    const btnCol = document.createElement('div');--}}
    {{--    btnCol.className = 'col-md-2';--}}

    {{--    if (rowIndex === 0) {--}}
    {{--        const addBtn = document.createElement('button');--}}
    {{--        addBtn.type = 'button';--}}
    {{--        addBtn.className = 'btn btn-success';--}}
    {{--        addBtn.textContent = 'Add Row';--}}

    {{--        addBtn.addEventListener('click', function () {--}}
    {{--            rowIndex++;--}}
    {{--            createRow();--}}
    {{--        });--}}

    {{--        btnCol.appendChild(addBtn);--}}

    {{--    } else {--}}
    {{--        const removeBtn = document.createElement('button');--}}
    {{--        removeBtn.type = 'button';--}}
    {{--        removeBtn.className = 'btn btn-danger';--}}
    {{--        removeBtn.textContent = 'Remove';--}}

    {{--        removeBtn.addEventListener('click', function () {--}}
    {{--            row.remove();--}}
    {{--        });--}}

    {{--        btnCol.appendChild(removeBtn);--}}
    {{--    }--}}

    {{--    row.appendChild(btnCol);--}}

    {{--    attrContainer.appendChild(row);--}}

    {{--    // ---------------- fetch attributes ------------------}}
    {{--    fetchAttributes(attrSelect);--}}

    {{--    // ---------------- attribute change ------------------}}
    {{--    attrSelect.addEventListener('change', function () {--}}
    {{--        fetchValues(this.value, valueSelects);--}}
    {{--    });--}}
    {{--}--}}

    {{--/////////////////////////////////////////////////////////////////////////////////////////////////////--}}
    {{--function fetchAttributes(selectElement) {--}}
    {{--    fetch("{{ route('admin.attributes.fetchAttributes') }}")--}}
    {{--        .then(res => res.json())--}}
    {{--        .then(data => {--}}

    {{--            data.forEach(item => {--}}
    {{--                const option = document.createElement('option');--}}
    {{--                option.value = item.id;--}}
    {{--                option.textContent = item.translation.name;--}}
    {{--                selectElement.appendChild(option);--}}
    {{--            });--}}

    {{--        });--}}
    {{--}--}}

    {{--/////////////////////////////////////////////////////////////////////////////////////////////////////--}}
    {{--function fetchValues(attributeId, selects) {--}}

    {{--    let url = "{{ route('admin.attributes.fetchValues', ':id') }}".replace(':id', attributeId);--}}

    {{--    fetch(url)--}}
    {{--        .then(res => res.json())--}}
    {{--        .then(data => {--}}

    {{--            // أول select فقط يحتوي كل القيم--}}
    {{--            const firstLang = Object.keys(selects)[0];--}}

    {{--            Object.values(selects).forEach(select => {--}}
    {{--                select.innerHTML = '<option disabled selected>اختر...</option>';--}}
    {{--            });--}}

    {{--            data.forEach(item => {--}}

    {{--                let firstTranslation = item.translations.find(--}}
    {{--                    t => t.language_id == languages[0].id--}}
    {{--                );--}}

    {{--                const option = document.createElement('option');--}}
    {{--                option.value = item.id;--}}
    {{--                option.textContent = firstTranslation.value;--}}

    {{--                selects[firstLang].appendChild(option);--}}
    {{--            });--}}

    {{--            // onchange first select--}}
    {{--            selects[firstLang].onchange = function () {--}}

    {{--                const selectedValueId = this.value;--}}

    {{--                const selectedItem = data.find(item => item.id == selectedValueId);--}}

    {{--                Object.keys(selects).forEach((lang, index) => {--}}

    {{--                    if (index === 0) return;--}}

    {{--                    selects[lang].innerHTML = '';--}}

    {{--                    let translation = selectedItem.translations.find(--}}
    {{--                        t => t.language_id == languages[index].id--}}
    {{--                    );--}}

    {{--                    const option = document.createElement('option');--}}
    {{--                    option.value = selectedItem.id;--}}
    {{--                    option.textContent = translation.value;--}}

    {{--                    selects[lang].appendChild(option);--}}
    {{--                });--}}

    {{--            };--}}

    {{--        });--}}
    {{--}--}}
    /////////////////////////////////////////////////////////////////////////////////////////////////////

    /////////////////////////////////////////////////////////////////////////////////////////////////////
</script>
@endsection

