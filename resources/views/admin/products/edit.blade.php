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

                                    <form  method="POST" action="{{route('admin.products.update', $product->id)}}" enctype="multipart/form-data">
                                        @csrf
                                        @method('PATCH')
                                        <div class="form-row">

                                            <div class="col-md-4 mb-3">
                                                <label for="validationCustomPhoto">{{__('admin/labels.image')}}</label>
                                                <input type="file" class="form-control @error("product.photo") is-invalid @enderror" id="validationCustomPhoto" name="product[photo]" value="{{ old('product[photo]')}}" >
                                                @error("product.photo")
                                                <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <div class="col-md-4 mb-3" >
                                                <img src="{{$product->photo}}" alt="" style="width: 50px;" readonly>
                                            </div>

                                            <div class="col-md-4 mb-3">
                                                <label for="validationCustomBrand">{{__('admin/labels.brand')}}</label>
                                                <select class="form-control @error("product.brand_id") is-invalid @enderror " name="product[brand_id]" >
                                                    @if(count($brands) > 0)
                                                        @foreach($brands as $brand)
                                                            <option value="{{$brand->id}}" {{ old('product.brand_id', $product->brand_id) == $brand->id ? 'selected' : '' }}>{{$brand->name}}</option>
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

                                            @if(count($product['translations']) > 0)
                                                @foreach($product['translations'] as $index => $translation)
                                                @php
                                                    $lang = $translation['language']['abbr'];
                                                @endphp
                                                <div class="form-row">

                                                    <div class="col-md-6 mb-3">
                                                        <label for="validationCustomProductName{{$index}}">{{__('admin/labels.name').' '. __('admin/labels.'.$lang) }}</label>
                                                        <input type="text" class="form-control @error("product_translations.$index.name") is-invalid @enderror" id="validationCustomProductName{{$index}}" name="product_translations[{{$index}}][name]" value="{{ old("product_translations.$index.name", $translation->name) }}" required>
                                                        @error("product_translations.$index.name")
                                                        <div class="invalid-feedback" style="display: block;">
                                                            {{ $message }}
                                                        </div>
                                                        @enderror
                                                    </div>

                                                    <div class="col-md-6 mb-3">
                                                        <label for="validationCustomDesc{{$index}}">{{__('admin/labels.description').' '. __('admin/labels.'.$lang) }}</label>
                                                        <input type="text" class="form-control @error("product_translations.$index.description") is-invalid @enderror" id="validationCustomDesc{{$index}}" name="product_translations[{{$index}}][description]" value="{{  old('product_translations.$index.description', $translation->description) }}" required>
                                                        @error("product_translations.$index.description")
                                                        <div class="invalid-feedback" style="display: block;">
                                                            {{ $message }}
                                                        </div>
                                                        @enderror
                                                    </div>

                                                    <input type="hidden" class="form-control" name="product_translations[{{$index}}][language_id]" value="{{$translation->language_id}}" readonly>
                                                </div>
                                                @endforeach
                                            @endif

                                        <div class="form-row">

                                            <div class="col-md-4 mb-3">
                                                <label for="validationCustomQuant">{{__('admin/labels.quantity')}}</label>
                                                <input type="number" class="form-control @error("product.quantity") is-invalid @enderror" id="validationCustomQuant" name="product[quantity]" value="{{ old('product.quantity', $product->quantity) }}" >
                                                @error("product.quantity")
                                                <div class="invalid-feedback" style="display: block;">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>

                                            <div class="col-md-4 mb-3">
                                                <label for="validationCustomPrice">{{__('admin/labels.unit_price')}}</label>
                                                <input type="number" class="form-control @error("product.price") is-invalid @enderror" id="validationCustomPrice" name="product[price]" value="{{ old('product.price', $product->price) }}" min="0" step="0.01" >
                                                @error("product.price")
                                                <div class="invalid-feedback" style="display: block;">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>

                                            <div class="col-md-4 mb-3">
                                                <label for="validationCustomCategory">{{__('admin/labels.category')}}</label>
                                                <select class="form-control @error("product.category_id") is-invalid @enderror " name="product[category_id]" >
                                                    @if(count($categories) > 0)
                                                        @foreach($categories as $category)
                                                            <option value="{{$category->id}}" {{ old('product.category_id', $product->category_id) == $category->id ? 'selected' : '' }}>{{$category->translation->name}}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                                @error("product.category_id")
                                                <div class="invalid-feedback" style="display: block;">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>

                                        </div>

                                        <div class="form-row align-items-end" id="color_container">

                                            @if($errors->any())

                                                @foreach($oldColors as $index => $item)
                                                    <div class="col-md-12 row align-items-end mb-3 row_parent">
                                                        <div class="col-md-4">
                                                            <label for="validationCustomCategory{{$index}}">{{__('admin/labels.colors')}}</label>
                                                            <select class="form-control @error("colors.$index.color_id") is-invalid @enderror " name="colors[{{$index}}][color_id]" id="color_select_{{$index}}">
                                                                <option value="" disabled="" selected>{{__('admin/labels.choose')}}</option>
                                                                @foreach($colors as $color)
                                                                    <option value="{{$color->id}}" {{ old("colors.$index.color_id", $item['color_id']?? null)  == $color->id ? 'selected' : '' }}>{{$color->name}}</option>
                                                                @endforeach
                                                            </select>
                                                            @error("colors.$index.color_id")
                                                            <div class="invalid-feedback" style="display: block;">
                                                                {{ $message }}
                                                            </div>
                                                            @enderror
                                                        </div>

                                                        <div class="col-auto p-0" >
                                                                @if(isset($item['color_id']) && $selectedColor = $colors->firstWhere('id', $item['color_id']))
                                                                    <div class="rounded-circle" id="color_{{$index}}" style="background-color: {{$selectedColor->name}}; width: 40px; height: 35px;"></div>
                                                                @endif
                                                        </div>

                                                        <div class="col-md-2">
                                                            <label for="color_quant{{$index}}">{{__('admin/labels.color_quantity')}}</label>
                                                            <input type="number" class="form-control @error("colors.$index.quantity") is-invalid @enderror" id="color_quant{{$index}}" name="colors[{{$index}}][quantity]" value="{{ old("colors.$index.quantity", $item['quantity']) }}" min="0" step="0.01" >
                                                            @error("colors.$index.quantity")
                                                            <div class="invalid-feedback" style="display: block;">
                                                                {{ $message }}
                                                            </div>
                                                            @enderror
                                                        </div>

                                                        @if($index == 0)
                                                            <div class="col-md-2 mt-4">
                                                                <button class="btn btn-success form-control w-75" type="button" id="add_color">{{__('admin/labels.add_row')}}</button>
                                                            </div>
                                                        @else
                                                            <div class="col-md-2 mt-4">
                                                                <button type="button" class="btn btn-danger w-75 remove_color">{{__('admin/labels.remove_row')}}</button>
                                                            </div>
                                                        @endif

                                                    </div>
                                                @endforeach

                                            @else

                                                @if(count($product['colors']) > 0)
                                                    @foreach($product['colors'] as $index => $item)
                                                        <div class="col-md-12 row mb-3 align-items-end row_parent">

                                                            <div class="col-md-4">
                                                                <label for="validationCustomCategory{{$index}}">{{__('admin/labels.colors')}}</label>
                                                                <select class="form-control color_select @error("colors.$index.color_id") is-invalid @enderror " name="colors[{{$index}}][color_id]" id="color_select_{{$index}}">
                                                                    <option value="" disabled="" selected>{{__('admin/labels.choose')}}</option>
                                                                    @if(count($colors) > 0)
                                                                        @foreach($colors as $color)
                                                                            <option value="{{$color->id}}" {{ old("colors.$index.color_id", $item->pivot->color_id) == $color->id ? 'selected' : '' }}>{{$color->name}}</option>
                                                                        @endforeach
                                                                    @endif
                                                                </select>
                                                                @error("colors.$index.color_id")
                                                                <div class="invalid-feedback" style="display: block;">
                                                                    {{ $message }}
                                                                </div>
                                                                @enderror
                                                            </div>

                                                            <div class="col-auto p-0" >
                                                                <div class="rounded-circle color_div" id="color_{{$index}}"></div>
                                                            </div>

                                                            <div class="col-md-2">
                                                                <label for="color_quant{{$index}}">{{__('admin/labels.color_quantity')}}</label>
                                                                <input type="number" class="form-control @error("colors.$index.quantity") is-invalid @enderror" id="color_quant{{$index}}" name="colors[{{$index}}][quantity]" value="{{ old("colors.$index.quantity", $item->pivot->quantity) }}" min="0" step="0.01" >
                                                                @error("colors.$index.quantity")
                                                                <div class="invalid-feedback" style="display: block;">
                                                                    {{ $message }}
                                                                </div>
                                                                @enderror
                                                            </div>

                                                            @if($index == 0)
                                                                <div class="col-md-2 mt-4">
                                                                    <button class="btn btn-success form-control w-75" type="button" id="add_color">{{__('admin/labels.add_row')}}</button>
                                                                </div>
                                                            @else
                                                                <div class="col-md-2 mt-4">
                                                                    <button type="button" class="btn btn-danger w-75 remove_color">{{__('admin/labels.remove_row')}}</button>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    @endforeach

                                                    @else
                                                    <div class="col-md-12 row mb-3 align-items-end row_parent">
                                                        <div class="col-md-4">
                                                            <label for="validationCustomCategory0">{{__('admin/labels.colors')}}</label>
                                                            <select class="form-control color_select @error("colors.0.color_id") is-invalid @enderror " name="colors[0][color_id]" id="color_select_0">
                                                                <option value="" disabled="" selected>{{__('admin/labels.choose')}}</option>
                                                                @if(count($colors) > 0)
                                                                    @foreach($colors as $color)
                                                                        <option value="{{$color->id}}" {{ old("colors.0.color_id") == $color->id ? 'selected' : '' }}>{{$color->name}}</option>
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
                                                            <div class="rounded-circle color_div" id="color_0"></div>
                                                        </div>

                                                        <div class="col-md-2">
                                                            <label for="color_quant0">{{__('admin/labels.color_quantity')}}</label>
                                                            <input type="number" class="form-control @error("colors.0.quantity") is-invalid @enderror" id="color_quant0" name="colors[0][quantity]" value="{{ old("colors.0.quantity") }}" min="0" step="0.01" >
                                                            @error("colors.0.quantity")
                                                            <div class="invalid-feedback" style="display: block;">
                                                                {{ $message }}
                                                            </div>
                                                            @enderror
                                                        </div>

                                                        <div class="col-md-2 mt-4">
                                                            <button class="btn btn-success form-control w-75" type="button" id="add_color">{{__('admin/labels.add_row')}}</button>
                                                        </div>

                                                        </div>
                                                @endif
                                            @endif
                                        </div>


                                        <div class="form-row">

                                            <div class="col-md-12 mx-auto mb-3">
                                                <p class="mb-3">{{__('admin/labels.active')}}</p>
                                                <div class="custom-control custom-switch">
                                                    <input type="checkbox" class="custom-control-input  @error("product.active") is-invalid @enderror"  id="customSwitch1" name="product[active]" value="1" @checked(old('active', $product->active) == 1)  >
                                                    <label class="custom-control-label" for="customSwitch1">{{__('admin/labels.yes')}}</label>
                                                    @error("product.active")
                                                    <div class="invalid-feedback" style="display: block;">
                                                        {{ $message }}
                                                    </div>
                                                    @enderror
                                                </div>
                                            </div>



                                            <div class="form-row col-md-12 mb-4" id="attr_container">
                                                @if($errors->any())

                                                    @foreach($oldAttributes as $index => $attrId)
                                                        <div class="col-md-12 row mb-3 row_parent" data-index="{{$index}}">

                                                            <div class="col-md-4">
                                                                <label for="validationCustomAttr">{{__('admin/labels.attributes')}}</label>
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

                                                            <div class="col-md-4">
                                                                <label for="validationCustomAttrVal">{{__('admin/labels.value')}}</label>
                                                                <select class="form-control @error("attribute_values.$index") is-invalid @enderror " name="attribute_values[{{$index}}]" id="attr_values_{{$index}}">
                                                                    @if(count($filteredData) > 0)
                                                                        @foreach($filteredData[$attrId] as $k => $item)
                                                                            <option value="{{$item['id']}}" @selected(in_array($item['id'], $oldAttributeValues)) >{{$item['translation']['value']}} </option>
                                                                        @endforeach
                                                                    @else
                                                                        @foreach($allAttributesValues[$attrId] as $k => $item)
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
                                                                    <button class="btn btn-success form-control w-75" type="button" id="add_row">{{__('admin/labels.add_row')}}</button>
                                                                </div>
                                                            @else
                                                                <div class="col-md-3 mt-4">
                                                                    <button type="button" class="btn btn-danger w-75 remove_row">{{__('admin/labels.remove_row')}}</button>
                                                                </div>
                                                            @endif

                                                        </div>
                                                    @endforeach



                                                @elseif(count($product['attributeValues']) > 0)
                                                    <button class="btn btn-warning mb-4"  id="remove_attr" type="button">{{__('admin/labels.remove_attributes')}}</button>

                                                @foreach($product['attributeValues'] as $index => $attr_val)

                                                    <div class=" col-md-12 row  mb-3 align-items-end row_parent ">

                                                        <div class="col-md-4" id="">
                                                            <label for="attr_names{{$index}}">{{__('admin/labels.attributes')}}</label>
                                                            <select class="form-control " id="attr_names{{$index}}"  name="attributes[{{$index}}]">
                                                                <option value='' selected disabled>{{__('admin/labels.choose')}}</option>
                                                                @foreach($attributes as $attribute)
                                                                    <option value="{{$attribute->id}}" @selected($attribute->id === $attr_val->attribute_id)> {{$attribute->translation->name}} </option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        <div class="col-md-4 " id="">
                                                            <label for="attr_values">{{__('admin/labels.value')}}</label>
                                                            <select class="form-control " id="attr_values{{$index}}" name="attribute_values[{{$index}}]">
                                                                <option value=''  disabled>{{__('admin/labels.choo    ')}}</option>

                                                                @foreach($attributesValues[$index] as  $values)
                                                                    <option value="{{$values->id}}" @selected(old('attribute_values'.$index, $attr_val->id) == $values->id) >{{$values->value}}</option>
                                                                @endforeach

                                                            </select>
                                                        </div>


                                                        @if($index == 0)
                                                            <div class="col-md-3 mt-4">
                                                                <button class="btn btn-success form-control w-75" type="button" id="add_row">{{__('admin/labels.add_row')}}</button>
                                                            </div>
                                                        @else
                                                            <div class="col-md-3 mt-4">
                                                                <button type="button" class="btn btn-danger w-75 remove_row"> {{__('admin/labels.remove_row')}}</button>
                                                            </div>
                                                        @endif

                                                    </div>
                                                @endforeach

                                                    @else
                                                    <button class="btn btn-warning mb-4"  id="manage_attr" type="button">{{__('admin/labels.add_attributes')}}</button>

                                                @endif

                                            </div>


                                            <button class="btn btn-primary" type="submit">{{__('admin/labels.update')}}</button>
                                        </div>
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
     // let selectColor = document.getElementById("color_select_0");
     let colorContainer = document.getElementById("color_container");
     let attrContainer = document.getElementById("attr_container");
     let attrNamesSelect;
     let attrValuesSelect;
     let attrId;
     let attributes = @json($attributes);
     let index = {{count($product['attributeValues'])}};
     let colorIndex = {{count($oldColors)}} || 1;

     /////////////////////////////////////////////////////////////////////////////////////////////////////
     function createAttrInputs(currentIndex) {
         if (currentIndex === 0) {
             attrContainer.innerHTML = '';
         }

         const row = document.createElement('div');
         row.className = 'col-md-12 row align-items-end mb-3 row_parent';

         function createSelectCol(labelText, selectId) {

             const col = document.createElement('div');
             col.className = 'col-md-4';

             const label = document.createElement('label');
             label.className = 'form-label';
             label.textContent = labelText;
             label.id = `${selectId}_${currentIndex}`;

             const select = document.createElement('select');
             select.className = 'form-control';
             select.id = `${selectId}_${currentIndex}`;

             const placeholder = document.createElement('option');
             placeholder.textContent = `{{__('admin/labels.choose')}}`;
             placeholder.value = '';
             placeholder.disabled = true;
             placeholder.selected = true;

             select.appendChild(placeholder);
             col.appendChild(label);
             col.appendChild(select);

             return { col, select };
         }

         const nameData = createSelectCol(`{{__('admin/labels.attributes')}}`, 'attr_names');
         const valueData = createSelectCol(`{{__('admin/labels.value')}}`, 'attr_values');

         nameData.select.name = `attributes[${currentIndex}]`;
         valueData.select.name = `attribute_values[${currentIndex}]`;

         const btnCol = document.createElement('div');
         btnCol.className = 'col-md-3';

         const btn = document.createElement('button');
         btn.type = 'button';

         if (currentIndex === 0) {
             btn.className = 'btn btn-success w-75';
             btn.textContent = `{{__('admin/labels.add_row')}}`;

             btn.addEventListener("click", function () {
                 index++;
                 createAttrInputs(index);
             });

         } else {
             btn.className = 'btn btn-danger w-75';
             btn.textContent = `{{__('admin/labels.remove_row')}}`;

             btn.addEventListener("click", function () {
                 row.remove();
             });
         }

         // btn.className = 'btn btn-danger w-50';
         // btn.textContent = 'Remove Row';
         //
         // btn.addEventListener("click", function () {
         //     row.remove();
         // });

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
                 btn.textContent = `{{__('admin/labels.remove_row')}}`;
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
                 option.textContent = `{{__('admin/labels.choose')}}`;
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

         selectInput = createColsData('select', `{{__('admin/labels.colors')}}`, 'color_select');
         createColsData('div_color', '', 'color');
         createColsData('div_quantity', `{{__('admin/labels.color_quantity')}}`, 'color_quant');
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
     function getColors(selectElement) {
         fetch("{{route('admin.colors.fetchColors')}}")
             .then(response => response.json())
             .then(data => {
                 console.log(data);
                 showData(data, selectElement);
             });
     }

     /////////////////////////////////////////////////////////////////////////////////////////////////////
     function getAttributes(selectElement) {
         showData(attributes, selectElement);
     }
     /////////////////////////////////////////////////////////////////////////////////////////////////////
     function getAttrValues(attrId, targetSelect) {
         let url = "{{ route('admin.attributes.fetchValues', ':attribute') }}".replace(':attribute', attrId.value);
         // targetSelect.innerHTML = `<option value=''  >اختر...</option>`;

         fetch(url)
             .then(response => response.json())
             .then(data => {
                 // console.log(data);
                 showData(data, targetSelect);
             });
     }

     /////////////////////////////////////////////////////////////////////////////////////////////////////
     function showData(data, selectInput) {
         selectInput.innerHTML = `<option value='' disabled selected>{{ __('admin/labels.choose') }}</option>`;
         data.forEach(item => {
             const option = document.createElement('option');
             option.value = item.id;
             option.textContent = item.name ?? item.translation.name ?? item.translation.value;
             selectInput.appendChild(option);
         });
     }

     /////////////////////////////////////////////////////////////////////////////////////////////////////
     document.addEventListener("change", function (event) {
         const selectColor = event.target.closest(".color_select");
         // console.log(selectColor);
         const color = selectColor.options[selectColor.selectedIndex].text;
         const colorDiv = event.target.closest(`div.row_parent`).querySelector('.color_div');
         colorDiv.style.backgroundColor = color;
         colorDiv.style.width = '40px';
         colorDiv.style.height = '35px';
     });
     /////////////////////////////////////////////////////////////////////////////////////////////////////

     // document.addEventListener("click", function (event) {
     //     let Btn = event.target.closest("#add_row, .remove_row");
     //     if (!Btn) return;
     //
     //     if(Btn.id === 'add_row') {
     //         // index = document.getElementsByClassName("row_parent").length
     //         createAttrInputs(index);
     //         index++;
     //     } else if(Btn.classList.contains('remove_row')){
     //         Btn.closest('.row_parent').remove();
     //     }
     // });

     document.addEventListener("click", function (event) {
         let Btn = event.target.closest("#add_row, #add_color, .remove_row, .remove_color");
         if (!Btn) return;

         if(Btn.id === 'add_row') {
             // index = document.getElementsByClassName("row_parent").length
             createAttrInputs(index);
             index++;
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

     document.addEventListener("click", function (event) {
         let Btn = event.target.closest("#manage_attr, #remove_attr");
         if (!Btn) return;

         if(Btn.id === 'manage_attr') {
             console.log('manage');
             const removeAttrBtn = document.createElement('button');
             removeAttrBtn.className = 'btn btn-warning mb-4';
             removeAttrBtn.id = 'remove_attr';
             removeAttrBtn.innerHTML = `{{__('admin/labels.remove_attributes')}}`;
             createAttrInputs(index);
             attrContainer.prepend(removeAttrBtn);

         } else if(Btn.id === 'remove_attr'){
             // console.log('remove')
             const manageAttrBtn = document.createElement('button');
             manageAttrBtn.className = 'btn btn-warning mb-4';
             manageAttrBtn.id = 'manage_attr';
             manageAttrBtn.innerHTML = `{{__('admin/labels.add_attributes')}}`;
             attrContainer.innerHTML = '';
             attrContainer.appendChild(manageAttrBtn);
             index = 0;
         }
     });
 </script>
@endsection

