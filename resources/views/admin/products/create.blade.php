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

                                    <form  method="POST" action="{{route('admin.products.store')}}" enctype="multipart/form-data">
                                        @csrf
                                        <div class="form-row">
                                            <div class="col-md-6 mb-3">
                                                <label for="validationCustomPhoto">photo</label>
                                                <input type="file" class="form-control @error("product.photo") is-invalid @enderror" id="validationCustomPhoto" name="product[photo]" >
                                                <div class="valid-feedback"> Looks good! </div>
                                                @error("product.photo")
                                                <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label for="validationCustomBrand">{{ __('admin/labels.brand') }}</label>
                                                <select class="form-control @error("product.brand_id") is-invalid @enderror " name="product[brand_id]" >
                                                    @if(count($brands) > 0)
                                                        @foreach($brands as $brand)
                                                            <option value="{{$brand->id}}" {{ old('product.brand_id') == $brand->id ? 'selected' : '' }}>{{$brand->name}}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                                @error("product.brand_id")
                                                <div class="invalid-feedback" style="display: block;">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>

                                        </div>

                                        @if(count(get_active_languages()) > 0)
                                            @foreach(get_active_languages() as $index => $lang)

                                                <div class="form-row">

                                                    <div class="col-md-6 mb-3">
                                                        <label for="validationCustomName{{$index}}">{{ __('admin/labels.product_name').' '. __('admin/labels.'.$lang->abbr) }}</label>
                                                        <input type="text" class="form-control @error("product_translations.$index.name") is-invalid @enderror" id="validationCustomName{{$index}}" name="product_translations[{{$index}}][name]" value="{{ old('product_translations.'.$index.'.name') }}">
                                                        @error("product_translations.$index.name")
                                                        <div class="invalid-feedback" style="display: block;">
                                                            {{ $message }}
                                                        </div>
                                                        @enderror
                                                    </div>


                                                    <div class="col-md-6 mb-3">
                                                        <label for="validationCustomDesc{{$index}}">{{ __('admin/labels.description').' '. __('admin/labels.'.$lang->abbr) }}</label>
                                                        <input type="text" class="form-control @error("product_translations.$index.description") is-invalid @enderror" id="validationCustomDesc{{$index}}" name="product_translations[{{$index}}][description]" value="{{ old('product_translations.'.$index.'.description') }}" >
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
                                                <label for="validationCustomQuant">{{ __('admin/labels.quantity') }}</label>
                                                <input type="number" class="form-control @error("product.quantity") is-invalid @enderror" id="validationCustomQuant" name="product[quantity]" value="{{ old('product.quantity') }}" >
                                                @error("product.quantity")
                                                <div class="invalid-feedback" style="display: block;">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>

                                            <div class="col-md-4 mb-3">
                                                <label for="price">{{ __('admin/labels.unit_price') }}</label>
                                                <input type="number" class="form-control @error("product.price") is-invalid @enderror" id="price" name="product[price]" value="{{ old('product.price') }}" min="0" step="0.01" >
                                                @error("product.price")
                                                <div class="invalid-feedback" style="display: block;">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>

                                            <div class="col-md-4 mb-3">
                                                <label for="validationCustomCategory">{{ __('admin/labels.category') }}</label>
                                                <select class="form-control @error("product.category_id") is-invalid @enderror " name="product[category_id]" >
                                                    @if(count($categories) > 0)
                                                        @foreach($categories as $category)
                                                            <option value="{{$category->id}}" {{ old('product.category_id') == $category->id ? 'selected' : '' }}>{{$category->translation->name}}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                                @error("product.category")
                                                    <div class="invalid-feedback" style="display: block;">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>

                                        </div>


                                        <div class="form-row align-items-end" id="color_container">

                                            @if($errors->any())

                                                @foreach($oldColors as $index => $item)
                                                    <div class="col-md-12 row mb-3 row_parent">
                                                        <div class="col-md-4">
                                                            <label for="validationCustomCategory{{$index}}">{{ __('admin/labels.colors') }}</label>
                                                            <select class="form-control @error("colors.$index.color_id") is-invalid @enderror " name="colors[{{$index}}][color_id]" id="color_select_{{$index}}">
                                                                <option value="" disabled="" selected>{{ __('admin/labels.choose') }}</option>
                                                                    @foreach($colors as $color)
                                                                        <option value="{{$color->id}}" {{ $item['color_id']?? null == $color->id ? 'selected' : '' }}>{{$color->name}}</option>
                                                                    @endforeach
                                                            </select>
                                                            @error("colors.$index.color_id")
                                                            <div class="invalid-feedback" style="display: block;">
                                                                {{ $message }}
                                                            </div>
                                                            @enderror
                                                        </div>

                                                        <div class="col-auto p-0" >
                                                            <div class="rounded-circle" id="color_{{$index}}"></div>
                                                        </div>

                                                        <div class="col-md-2">
                                                            <label for="color_quant{{$index}}">{{ __('admin/labels.color_quantity') }}</label>
                                                            <input type="number" class="form-control @error("colors.$index.quantity") is-invalid @enderror" id="color_quant{{$index}}" name="colors[{{$index}}][quantity]" value="{{ $item['quantity'] }}" min="0" step="0.01" >
                                                            @error("colors.$index.quantity")
                                                            <div class="invalid-feedback" style="display: block;">
                                                                {{ $message }}
                                                            </div>
                                                            @enderror
                                                        </div>

                                                        @if($index == 0)
                                                            <div class="col-md-2 mt-4">
                                                                <button class="btn btn-success form-control w-75" type="button" id="add_color">{{ __('admin/labels.add_row') }}</button>
                                                            </div>
                                                        @else
                                                            <div class="col-md-2 mt-4">
                                                                <button type="button" class="btn btn-danger w-75 remove_color">{{ __('admin/labels.remove_row') }}</button>
                                                            </div>
                                                        @endif

                                                    </div>
                                                @endforeach

                                            @else
                                            <div class="col-md-12 row mb-3 align-items-end row_parent">
                                                <div class="col-md-4">
                                                    <label for="validationCustomCategory">{{ __('admin/labels.colors') }}</label>
                                                    <select class="form-control @error("colors.0.color_id") is-invalid @enderror " name="colors[0][color_id]" id="color_select_0">
                                                          <option value="" disabled="" selected>{{ __('admin/labels.choose') }}</option>
                                                          @if(count($colors) > 0)
                                                             @foreach($colors as $color)
                                                                <option value="{{$color->id}}" {{ old('colors.0.color_id') == $color->id ? 'selected' : '' }}>{{$color->name}}</option>
                                                             @endforeach
                                                          @endif
                                                    </select>
                                                    @error("colors.0.color_id")
                                                    <div class="invalid-feedback" style="display: block;">
                                                        {{ $message }}
                                                    </div>
                                                    @enderror
                                                </div>

                                                <div class="col-auto p-0" >
                                                   <div class="rounded-circle" id="color_0"></div>
                                                </div>

                                                <div class="col-md-2">
                                                    <label for="color_quant0">{{ __('admin/labels.color_quantity') }}</label>
                                                    <input type="number" class="form-control @error("colors.0.quantity") is-invalid @enderror" id="color_quant0" name="colors[0][quantity]" value="{{ old('colors.0.quantity') }}" min="0" step="0.01" >
                                                    @error("colors.0.quantity")
                                                    <div class="invalid-feedback" style="display: block;">
                                                        {{ $message }}
                                                    </div>
                                                    @enderror
                                                </div>

                                                <div class="col-md-2">
                                                    <button class="btn btn-success form-control w-75" type="button" id="add_color">{{ __('admin/labels.add_color') }}</button>
                                                </div>
                                            </div>

                                            @endif
                                        </div>



                                        <div class="form-row">

                                            <div class="col-md-12 mx-auto mb-3">
                                                <p class="mb-3">{{ __('admin/labels.active') }}</p>
                                                <div class="custom-control custom-switch">
                                                    <input type="checkbox" class="custom-control-input" id="customSwitch" name="product[active]" value="1" {{ old('product.active') ? 'checked' : '' }}>
                                                    <label class="custom-control-label" for="customSwitch">{{ __('admin/labels.yes') }}</label>
                                                </div>

                                            </div>
                                        </div>

                                        <button class="btn btn-warning mb-4"  id="manage_attr" type="button">{{ __('admin/labels.add_attributes') }}</button>

                                        <button class="btn btn-warning mb-4 d-none"  id="remove_attr" type="button">{{ __('admin/labels.remove_attributes') }}</button>



                                        <div class="form-row mb-4 align-items-end" id="attr_container">

                                            @if($errors->any())

                                                @foreach($oldAttributes as $index => $attrId)
                                                    <div class="col-md-12 row mb-3 row_parent" data-index="{{$index}}">

                                                        <div class="col-md-3">
                                                            <label for="validationCustomAttr">{{ __('admin/labels.attributes') }}</label>
                                                            <select class="form-control @error("attributes.$index") is-invalid @enderror " name="attributes[{{$index}}]" id="attr_names_{{$index}}">
                                                                @if(count($attributes) > 0)
                                                                    @foreach($attributes as $attribute)
                                                                        <option value="{{$attribute->id}}" {{ $attrId == $attribute->id ? 'selected' : '' }}>{{$attribute->translation->name}}</option>
                                                                    @endforeach
                                                                @endif
                                                            </select>
                                                            @error("attributes.$index")
                                                            <div class="invalid-feedback" style="display: block;">
                                                                {{ $message }}
                                                            </div>
                                                            @enderror
                                                        </div>

                                                        <div class="col-md-3">
                                                            <label for="validationCustomAttrVal">{{ __('admin/labels.value') }}</label>
                                                            <select class="form-control @error("attribute_values.$index") is-invalid @enderror " name="attribute_values[{{$index}}]" id="attr_values_{{$index}}">
                                                                @if(count($filteredData) > 0)
                                                                    @foreach($filteredData[$attrId] as $k => $item)
                                                                        <option value="{{$item['id']}}" @selected(in_array($item['id'], $oldAttributeValues)) >{{$item['translation']['value']}} </option>
                                                                    @endforeach
                                                                    @else
                                                                    @foreach($attributesValues[$attrId] as $k => $item)
                                                                        <option value="{{$item['id']}}" @selected(in_array($item['id'], $oldAttributeValues)) >{{$item['translation']['value']}} </option>
                                                                    @endforeach
                                                                @endif

                                                            </select>
                                                            @error("attribute_values.$index")
                                                            <div class="invalid-feedback" style="display: block;">
                                                                {{ $message }}
                                                            </div>
                                                            @enderror
                                                        </div>

                                                        @if($index == 0)
                                                            <div class="col-md-3 mt-4">
                                                                <button class="btn btn-success form-control w-75" type="button" id="add_row">{{ __('admin/labels.add_row') }}</button>
                                                            </div>
                                                        @else
                                                            <div class="col-md-3 mt-4">
                                                                <button type="button" class="btn btn-danger w-75 remove_row">{{ __('admin/labels.remove_row') }}</button>
                                                            </div>
                                                        @endif

                                                    </div>
                                                @endforeach
                                            @endif

                                        </div>

                                        <button class="btn btn-primary col-md-12" type="submit">{{ __('admin/labels.create') }}</button>
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
    let addColorBtn = document.getElementById("add_color");
    let selectColor = document.getElementById("color_select_0");
    let manageAttrBtn = document.getElementById("manage_attr");
    let removeAttrBtn = document.getElementById("remove_attr");
    let attrContainer = document.getElementById("attr_container");
    let colorContainer = document.getElementById("color_container");
    let attrNamesSelect;
    let attrValuesSelect;
    let attrId;
    let index = 0;
    let colorIndex = {{count($oldColors)}} || 1;

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
            label.for = `${selectId}_${currentIndex}`;

            const select = document.createElement('select');
            select.className = 'form-control';
            select.id = `${selectId}_${currentIndex}`;

            const placeholder = document.createElement('option');
            placeholder.textContent = '{{ __('admin/labels.choose') }}';
            placeholder.value = '';
            placeholder.disabled = true;
            placeholder.selected = true;

            select.appendChild(placeholder);
            col.appendChild(label);
            col.appendChild(select);

            return { col, select };
        }

        const nameData = createSelectCol('{{ __('admin/labels.attributes') }}', 'attr_names');
        const valueData = createSelectCol('{{ __('admin/labels.value') }}', 'attr_values');

        nameData.select.name = `attributes[${currentIndex}]`;
        valueData.select.name = `attribute_values[${currentIndex}]`;

        const btnCol = document.createElement('div');
        btnCol.className = 'col-md-3';

        const btn = document.createElement('button');
        btn.type = 'button';

        if (currentIndex === 0) {
            btn.className = 'btn btn-success w-75';
            btn.textContent = '{{ __('admin/labels.add_row') }}';

            btn.addEventListener("click", function () {
                index++;
                createAttrInputs(index);
            });

        } else {
            btn.className = 'btn btn-danger w-75';
            btn.textContent = '{{ __('admin/labels.remove_row') }}';

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
    function createColorInputs(currentIndex) {

        const row = document.createElement('div');
        row.className = 'col-md-12 row align-items-end mb-3 row_parent';

        function createColsData(type=null, labelText, id) {

            const col = document.createElement('div');

            if(type === 'div_color'){
                col.className = 'col-auto p-0';
                const div = document.createElement('div');
                div.className = 'rounded-circle';
                div.id = `${id}_${currentIndex}`;
                col.appendChild(div);
                row.appendChild(col);
                return;
            }


            if(type === 'btn'){
                col.className = 'col-md-2';
                const btn = document.createElement('button');
                btn.type = 'button';
                btn.className = 'btn btn-danger w-75';
                btn.textContent = '{{ __('admin/labels.remove_row') }}';
                col.appendChild(btn);
                row.appendChild(col);
                btn.addEventListener("click", function () {
                    row.remove();
                });
                return;
            }

            const label = document.createElement('label');
            label.className = 'form-label';
            label.textContent = labelText;
            label.for = `${id}_${currentIndex}`;

            if(type === 'select'){
                col.className = 'col-md-4';
                const select = document.createElement('select');
                select.className = 'form-control';
                select.id = `${id}_${currentIndex}`;
                select.name = `colors[${currentIndex}][color_id]`;

                const option = document.createElement('option');
                option.textContent = '{{ __('admin/labels.choose') }}';
                option.value = '';
                option.disabled = true;
                option.selected = true;

                select.appendChild(option);
                col.appendChild(label);
                col.appendChild(select);
                row.appendChild(col);
                return select;
            }


            if(type === 'div_quantity'){
                col.className = 'col-md-2';
                const input = document.createElement('input');
                input.type = 'number';
                input.className = 'form-control';
                input.id = `${id}_${currentIndex}`;
                input.name = `colors[${currentIndex}][quantity]`;
                col.appendChild(label);
                col.appendChild(input);
                row.appendChild(col);
            }

        }

        selectInput = createColsData('select', '{{ __('admin/labels.colors') }}', 'color_select');
        createColsData('div_color', '', 'color');
        createColsData('div_quantity', '{{ __('admin/labels.color_quantity') }}', 'color_quant');
        createColsData('btn', null, null);
        colorContainer.appendChild(row);
        getColors(selectInput);

        selectInput.addEventListener("change", function (event) {
            const color = this.options[this.selectedIndex].text;
            const colorDiv = event.target.closest(`div.row_parent`).querySelector(`#color_${currentIndex}`);
            colorDiv.style.backgroundColor = color
            colorDiv.style.width = '40px';
            colorDiv.style.height = '35px';
        });
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

    function getColors(selectElement) {
        fetch("{{route('admin.colors.fetchColors')}}")
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

                targetSelect.innerHTML = '<option value="" disabled selected>{{ __('admin/labels.choose') }}</option>';
                showData(data, targetSelect);
            });
    }
    /////////////////////////////////////////////////////////////////////////////////////////////////////

    function showData(data, selectInput) {
        data.forEach(item => {
            const option = document.createElement('option');
            option.value = item.id;
            option.textContent = item.name ?? item.translation.name ?? item.translation.value ;
            selectInput.appendChild(option);
        });
    }

    /////////////////////////////////////////////////////////////////////////////////////////////////////
    selectColor.addEventListener("change", function (event) {
        const color = this.options[this.selectedIndex].text;
        const colorDiv = event.target.closest(`div.row_parent`).querySelector('#color_0');
        colorDiv.style.backgroundColor = color;
        colorDiv.style.width = '40px';
        colorDiv.style.height = '35px';
    });
    /////////////////////////////////////////////////////////////////////////////////////////////////////

    // addColorBtn.addEventListener("click", function () {
    //     createColorInputs(colorIndex);
    //     colorIndex++;
    // });

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

    document.addEventListener("click", function (event) {
        let Btn = event.target.closest("#add_row, #add_color, .remove_row, .remove_color");
        if (!Btn) return;

        if(Btn.id === 'add_row') {
            index = document.getElementsByClassName("row_parent").length
            createAttrInputs(index)
        }
        else if(Btn.id === 'add_color') {
            createColorInputs(colorIndex);
            colorIndex++;
        }
        else if(Btn.classList.contains('remove_row') || Btn.classList.contains('remove_color') ) {
            Btn.closest('.row_parent').remove();
        }
    });

    /////////////////////////////////////////////////////////////////////////////////////////////////////
</script>
@endsection

