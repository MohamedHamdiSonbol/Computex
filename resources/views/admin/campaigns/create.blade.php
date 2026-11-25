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
                                    @if ($errors->any())
                                        <div class="alert alert-danger">
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif

                                    <form  method="POST" action="{{route('admin.campaigns.store')}}" enctype="multipart/form-data">
                                        @csrf
{{--                                        <div class="form-row">--}}
{{--                                            <div class="col-md-12 mb-3">--}}
{{--                                                <label for="validationCustomPhoto">photo</label>--}}
{{--                                                <input type="file" class="form-control @error("product.photo") is-invalid @enderror" id="validationCustomPhoto" name="product[photo]" >--}}
{{--                                                <div class="valid-feedback"> Looks good! </div>--}}
{{--                                                @error("product.photo")--}}
{{--                                                <span class="invalid-feedback">{{ $message }}</span>--}}
{{--                                                @enderror--}}
{{--                                            </div>--}}
{{--                                        </div>--}}

                                        @if(count(get_active_languages()) > 0)
                                            @foreach(get_active_languages() as $index => $lang)

                                                <div class="form-row">

                                                    <div class="col-md-6 mb-3">
                                                        <label for="validationCustomName{{$index}}">{{__('admin/labels.name').' '. __('admin/labels.'.$lang->abbr) }}</label>
                                                        <input type="text" class="form-control @error("campaign_translations.$index.name") is-invalid @enderror" id="validationCustomName{{$index}}" name="campaign_translations[{{$index}}][name]" value="{{ old('campaign_translations.'.$index.'.name') }}">
                                                        @error("campaign_translations.$index.name")
                                                        <div class="invalid-feedback" style="display: block;">
                                                            {{ $message }}
                                                        </div>
                                                        @enderror
                                                    </div>


                                                    <div class="col-md-6 mb-3">
                                                        <label for="validationCustomDesc{{$index}}">{{__('admin/labels.description').' '. __('admin/labels.'.$lang->abbr) }}</label>
                                                        <input type="text" class="form-control @error("campaign_translations.$index.description") is-invalid @enderror" id="validationCustomDesc{{$index}}" name="campaign_translations[{{$index}}][description]" value="{{ old('campaign_translations.'.$index.'.description') }}" >
                                                        @error("campaign_translations.$index.description")
                                                        <div class="invalid-feedback" style="display: block;">
                                                            {{ $message }}
                                                        </div>
                                                        @enderror
                                                    </div>

                                                    <input type="hidden" class="form-control" name="campaign_translations[{{$index}}][language_id]" value="{{ $lang->id}}" readonly>

                                                </div>
                                            @endforeach
                                        @endif

                                        <div class="form-row">


                                            <div class="form-group col-md-4 mb-3">
                                                <label>{{__('admin/labels.scope_type')}}</label>
                                                <select class="custom-select form-control form-control-lg  @error('campaign.campaignable_type') is-invalid @enderror" id="campaign-type" name="campaign[campaignable_type]" >
                                                    <option selected disabled value="">{{__('admin/labels.choose')}}</option>
                                                    @foreach($types as $value => $label)
                                                        <option value="{{ $value }}" @selected(old('campaign.campaignable_type') == $value) >
                                                            {{ $label }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('campaign.campaignable_type')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <div class="form-group col-md-4 mb-3">
                                                <label>{{__('admin/labels.scope_affection')}}</label>
                                                <select class="custom-select form-control form-control-lg  @error('campaign.campaignable_id') is-invalid @enderror" id="campaign-id" name="campaign[campaignable_id]" >
                                                    <option selected disabled value="">{{__('admin/labels.choose')}}</option>

                                                </select>
                                                @error('campaign.campaignable_id')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>



                                            <div class="form-group col-md-4 mb-3">
                                                <label for="validationCustomQuant">{{__('admin/labels.priority')}}</label>
                                                <input type="number" class="form-control @error("campaign.priority") is-invalid @enderror" id="validationCustomQuant" name="campaign[priority]" value="{{ old('campaign.priority') }}" >
                                                @error("campaign.priority")
                                                <div class="invalid-feedback" style="display: block;">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>

                                        </div>

                                        <div class="form-row">

                                            <div class="col-md-3 mb-3">
                                                <label for="sale_starts_at">{{__('admin/labels.starts_at')}}</label>
                                                <input type="datetime-local" class="form-control @error("campaign.starts_at") is-invalid @enderror" id="sale_starts_at" name="campaign[starts_at]" value="{{ old('campaign.starts_at') }}"  >
                                                @error("campaign.starts_at")
                                                <div class="invalid-feedback" style="display: block;">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>

                                            <div class="col-md-3 mb-3">
                                                <label for="sale_ends_at">{{__('admin/labels.ends_at')}}</label>
                                                <input type="datetime-local" class="form-control @error("campaign.ends_at") is-invalid @enderror" id="sale_ends_at" name="campaign[ends_at]" value="{{ old('campaign.ends_at') }}"  >
                                                @error("campaign.ends_at")
                                                <div class="invalid-feedback" style="display: block;">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>

                                        </div>

                                        <div class="form-row justify-items-between">

                                            <div class="col-md-5 mb-3">
                                                <p class="mb-3">{{__('admin/labels.active')}}</p>
                                                <div class="custom-control custom-switch">
                                                    <input type="checkbox" class="custom-control-input" id="activeSwitch" name="campaign[active]" value="1" {{ old('campaign.active') ? 'checked' : '' }}>
                                                    <label class="custom-control-label" for="activeSwitch">{{__('admin/labels.yes')}}</label>
                                                </div>
                                            </div>

                                            <div class="col-md-5 mx-auto mb-3">
                                                <p class="mb-3">Stackable</p>
                                                <div class="custom-control custom-switch">
                                                    <input type="checkbox" class="custom-control-input" id="stackableSwitch" name="campaign[stackable]" value="1" {{ old('campaign.stackable') ? 'checked' : '' }}>
                                                    <label class="custom-control-label" for="stackableSwitch">{{__('admin/labels.yes')}}</label>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="form-row mt-5">

                                            <div class="col-md-6 mb-3">
                                                <label for="validationCustomType">{{__('admin/labels.discount_type')}}</label>
                                                <select type="text" class="form-control @error("discount.type") is-invalid @enderror" id="validationCustomType" name="discount[type]" >
                                                    <option value="fixed" {{ old('discount.type') == 'fixed' ? 'selected' : '' }}>{{__('admin/labels.fixed')}}</option>
                                                    <option value="percentage" {{ old('discount.type') == 'percentage' ? 'selected' : '' }}>{{__('admin/labels.percentage')}}</option>
                                                </select>
                                                @error("discount.type")
                                                <div class="invalid-feedback" style="display: block;">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label for="validationCustomValue">{{__('admin/labels.discount_amount')}}</label>
                                                <input type="number" class="form-control @error("discount.value") is-invalid @enderror" id="validationCustomValue" name="discount[value]" value="{{ old('discount.value') }}" >
                                                @error("discount.value")
                                                <div class="invalid-feedback" style="display: block;">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>


                                        </div>

                                        <div class="form-row">

                                            <div class="col-md-4 mb-3">
                                                <label for="validationCustomMin_Quant">{{__('admin/labels.min_quant_required')}}</label>
                                                <input type="number" class="form-control @error("discount.min_quantity") is-invalid @enderror" id="validationCustomMin_Quant" name="discount[min_quantity]" value="{{ old('discount.min_quantity') }}" >
                                                @error("discount.min_quantity")
                                                <div class="invalid-feedback" style="display: block;">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>

                                            <div class="col-md-4 mb-3">
                                                <label for="validationCustomMin_value">{{__('admin/labels.min_order_price_required')}}</label>
                                                <input type="number" class="form-control @error("discount.min_order_value") is-invalid @enderror" id="validationCustomMin_value" name="discount[min_order_value]" value="{{ old('discount.min_order_value') }}" >
                                                @error("discount.min_order_value")
                                                <div class="invalid-feedback" style="display: block;">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>

                                            <div class="col-md-4 mb-3">
                                                <label for="validationCustomUsage_limit">{{__('admin/labels.counts_allowed_single_customer')}}</label>
                                                <input type="number" class="form-control @error("discount.usage_limit_per_user") is-invalid @enderror" id="validationCustomUsage_limit" name="discount[usage_limit_per_user]" value="{{ old('discount.usage_limit_per_user') }}" >
                                                @error("discount.usage_limit_per_user")
                                                <div class="invalid-feedback" style="display: block;">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>

                                        </div>

                                        <div class="form-row">

                                            <div class="col-md-12 mx-auto mb-3">
                                                <p class="mb-3">{{__('admin/labels.active')}}</p>
                                                <div class="custom-control custom-switch">
                                                    <input type="checkbox" class="custom-control-input" id="customSwitch" name="discount[active]" value="1" {{ old('discount.is_active') ? 'checked' : '' }}>
                                                    <label class="custom-control-label" for="customSwitch">{{__('admin/labels.yes')}}</label>
                                                </div>
                                            </div>

                                        </div>

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

    const campaignableTypeSelector = document.getElementById('campaign-type');
    const campaignableIdSelector = document.getElementById('campaign-id');

    campaignableTypeSelector.addEventListener('change', function (event) {
        const typeVal = this.value;

        // 1. Generate the URL with a placeholder string 'ID'
        let url = "{{ route('admin.campaigns.fetchCampaignableId', ':id') }}";

        // 2. Replace the placeholder with the actual value from the dropdown
        url = url.replace(':id', typeVal);
        // console.log("Fetching from:", url);
        if (campaignableTypeSelector) {
            // 2. Perform the AJAX call
            fetch(url, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
            })
                .then(response => response.json())
                .then(data => {
                    // console.log(data.campaignableIds)

                    showData(data.campaignableIds, campaignableIdSelector)
                })
                .catch(error => console.error('Error:', error));
        }
    });


    function showData(data, selectInput) {
        selectInput.innerHTML = `<option selected disabled value="">Choose...</option>`;
        data.forEach(item => {
            // console.log(item);
            selectInput.innerHTML += `<option value="${item.id}">${item.name}</option>`;

        });
    }








    {{--let manageAttrBtn = document.getElementById("manage_attr");--}}
    {{--let removeAttrBtn = document.getElementById("remove_attr");--}}
    {{--let attrContainer = document.getElementById("attr_container");--}}
    {{--let attrNamesSelect;--}}
    {{--let attrValuesSelect;--}}
    {{--let attrId;--}}
    {{--let index = 0;--}}

    {{--function createAttrInputs(currentIndex) {--}}
    {{--    if (currentIndex === 0) {--}}
    {{--        attrContainer.innerHTML = '';--}}
    {{--    }--}}

    {{--    const row = document.createElement('div');--}}
    {{--    row.className = 'col-md-12 row align-items-end mb-3 row_parent';--}}

    {{--    function createSelectCol(labelText, selectId) {--}}

    {{--        const col = document.createElement('div');--}}
    {{--        col.className = 'col-md-3';--}}

    {{--        const label = document.createElement('label');--}}
    {{--        label.className = 'form-label';--}}
    {{--        label.textContent = labelText;--}}
    {{--        label.id = `${selectId}_${currentIndex}`;--}}

    {{--        const select = document.createElement('select');--}}
    {{--        select.className = 'form-control';--}}
    {{--        select.id = `${selectId}_${currentIndex}`;--}}

    {{--        const placeholder = document.createElement('option');--}}
    {{--        placeholder.textContent = 'اختر...';--}}
    {{--        placeholder.value = '';--}}
    {{--        placeholder.disabled = true;--}}
    {{--        placeholder.selected = true;--}}

    {{--        select.appendChild(placeholder);--}}
    {{--        col.appendChild(label);--}}
    {{--        col.appendChild(select);--}}

    {{--        return { col, select };--}}
    {{--    }--}}

    {{--    const nameData = createSelectCol('اختار الخاصية', 'attr_names');--}}
    {{--    const valueData = createSelectCol('اختار القيمة', 'attr_values');--}}

    {{--    valueData.select.name = `attribute_values[${currentIndex}]`;--}}

    {{--    const btnCol = document.createElement('div');--}}
    {{--    btnCol.className = 'col-md-3';--}}

    {{--    const btn = document.createElement('button');--}}
    {{--    btn.type = 'button';--}}

    {{--    if (currentIndex === 0) {--}}
    {{--        btn.className = 'btn btn-success w-75';--}}
    {{--        btn.textContent = 'Add Row';--}}

    {{--        btn.addEventListener("click", function () {--}}
    {{--            index++;--}}
    {{--            createAttrInputs(index);--}}
    {{--        });--}}

    {{--    } else {--}}
    {{--        btn.className = 'btn btn-danger w-75';--}}
    {{--        btn.textContent = 'Remove Row';--}}

    {{--        btn.addEventListener("click", function () {--}}
    {{--            row.remove();--}}
    {{--        });--}}
    {{--    }--}}

    {{--    btnCol.appendChild(btn);--}}

    {{--    nameData.select.addEventListener("change", function (event) {--}}
    {{--        getAttrValues(event.target, valueData.select);--}}
    {{--    });--}}

    {{--    row.appendChild(nameData.col);--}}
    {{--    row.appendChild(valueData.col);--}}
    {{--    row.appendChild(btnCol);--}}

    {{--    attrContainer.appendChild(row);--}}

    {{--    getAttributes(nameData.select);--}}
    {{--}--}}

    {{--/////////////////////////////////////////////////////////////////////////////////////////////////////--}}

    {{--function getAttributes(selectElement) {--}}
    {{--    fetch("{{route('admin.attributes.fetchAttributes')}}")--}}
    {{--        .then(response => response.json())--}}
    {{--        .then(data => {--}}
    {{--            console.log(data);--}}
    {{--            showData(data, selectElement);--}}
    {{--        });--}}
    {{--}--}}

    {{--/////////////////////////////////////////////////////////////////////////////////////////////////////--}}

    {{--function getAttrValues(attrId, targetSelect) {--}}
    {{--    let url = "{{ route('admin.attributes.fetchValues', ':attribute') }}".replace(':attribute', attrId.value);--}}

    {{--    fetch(url)--}}
    {{--        .then(response => response.json())--}}
    {{--        .then(data => {--}}
    {{--            console.log(data);--}}

    {{--            targetSelect.innerHTML = '<option value="" disabled selected>اختر...</option>';--}}
    {{--            showData(data, targetSelect);--}}
    {{--        });--}}
    {{--}--}}

    {{--/////////////////////////////////////////////////////////////////////////////////////////////////////--}}

    {{--function showData(data, selectInput) {--}}
    {{--    data.forEach(item => {--}}
    {{--        const option = document.createElement('option');--}}
    {{--        option.value = item.id;--}}
    {{--        option.textContent = item.translation.name ?? item.translation.value;--}}
    {{--        selectInput.appendChild(option);--}}
    {{--    });--}}
    {{--}--}}

    {{--/////////////////////////////////////////////////////////////////////////////////////////////////////--}}

    {{--manageAttrBtn.addEventListener("click", function () {--}}
    {{--    createAttrInputs(index);--}}
    {{--    this.classList.add('d-none');--}}
    {{--    removeAttrBtn.classList.remove('d-none');--}}
    {{--});--}}

    {{--/////////////////////////////////////////////////////////////////////////////////////////////////////--}}

    {{--removeAttrBtn.addEventListener("click", function () {--}}
    {{--    attrContainer.innerHTML = '';--}}
    {{--    manageAttrBtn.classList.remove('d-none');--}}
    {{--    this.classList.add('d-none');--}}
    {{--    index = 0;--}}
    {{--});--}}
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

