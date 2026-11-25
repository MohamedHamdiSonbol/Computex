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
                                    <form  method="POST" action="{{route('admin.products.update', $product->id)}}" enctype="multipart/form-data">
                                        @csrf
                                        @method('PATCH')
                                        <div class="form-row">

                                            <div class="col-md-8 mb-3">
                                                <label for="validationCustomPhoto">{{__('admin/labels.image')}}</label>
                                                <input type="file" class="form-control @error("product.photo") is-invalid @enderror" id="validationCustomPhoto" name="product[photo]" value="{{ old('product[photo]')}}" >
                                                @error("product.photo")
                                                <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <div class="col-md-4 mb-3" >
                                                <img src="{{$product->photo}}" alt="" style="width: 50px;" readonly>
                                            </div>
                                        </div>

                                            @if(count($product['translations']) > 0)
                                                @foreach($product['translations'] as $index => $translation)
                                                @php
                                                    $lang = $translation['language']['abbr'];
                                                @endphp
                                                <div class="form-row">

                                                    <div class="col-md-6 mb-3">
                                                        <label for="validationCustomProductName{{$index}}">{{__('admin/labels.product_name').' '. __('admin/labels.'.$lang) }}</label>
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
                                                <label for="validationCustomPrice">{{__('admin/labels.total_price')}}</label>
                                                <input type="number" class="form-control @error("product.price") is-invalid @enderror" id="validationCustomPrice" name="product[price]" value="{{ old('product.price', $product->price) }}" min="0" step="0.01" >
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
                                                <input type="checkbox" class="custom-control-input  @error("product.active") is-invalid @enderror"  id="customSwitch1" name="product[active]" value="1" @checked(old('active', $product->active) == 1)  >
                                                <label class="custom-control-label" for="customSwitch1">Yes</label>
                                                @error("product.active")
                                                <div class="invalid-feedback" style="display: block;">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>
                                            </div>


                                            <div class="form-row col-md-12 mb-4" id="attr_container">

                                                @foreach($product['attributeValues'] as $index => $attr_val)

                                                <div class=" col-md-12 row  mb-3 align-items-end row_parent ">

                                                    <div class="col-md-4" id="">
                                                        <label for="attr_names{{$index}}">اختار الخاصية  - {{ __('messages.'.get_active_lang()) }}   </label>
                                                        <select class="form-control" id="attr_names{{$index}}">
                                                            <option value='' selected disabled>اختر...</option>
                                                            @foreach($attributes as $attribute)
                                                                <option value="{{$attribute->id}}" @selected($attribute->id === $attr_val->attribute_id)> {{$attribute->translation->name}} </option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div class="col-md-4 " id="">
                                                        <label for="attr_values">اختار القيمة  - {{ __('messages.'.get_active_lang()) }}</label>
                                                        <select class="form-control" id="attr_values{{$index}}" name="attribute_values[{{$index}}]">
                                                            <option value=''  disabled>اختر...</option>
                                                            <option value="{{$attr_val->id}}"  selected>{{$attr_val->translation->value}}</option>
                                                        </select>

                                                    </div>

                                                    <div class="col-md-3">
                                                        <button type="button" class="btn btn-danger w-50" id="remove_attr{{$index}}" >Remove Row</button>
                                                    </div>

                                                </div>

                                                @endforeach


                                                <div class="col-md-12 mt-2">
                                                    <button class="btn btn-success " id="add_row" type="button"> Add Row</button>
                                                </div>

                                            </div>


                                            <button class="btn btn-primary" type="submit">Submit form</button>
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
     let addAttrBtn = document.getElementById("add_row");
     let attrContainer = document.getElementById("attr_container");
     let attrNamesSelect;
     let attrValuesSelect;
     let attrId;
     let attributes = @json($attributes);
     let index = {{count($product['attributeValues'])}};
     let i=0;
     /////////////////////////////////////////////////////////////////////////////////////////////////////
     while( i < index ){
         let selectData = (document.getElementById(`attr_names${i}`));
         let valueData = (document.getElementById(`attr_values${i}`));
         let deleteAttr = (document.getElementById(`remove_attr${i}`));

         selectData.addEventListener("change", function(event){
             console.log(event.target.value)
             getAttrValues(event.target, valueData);
         });

         deleteAttr.addEventListener("click", function(event){
             console.log(event.target)
             event.target.closest('.row_parent').remove();
         });

         i++;
     }
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
         btn.className = 'btn btn-danger w-50';
         btn.textContent = 'Remove Row';

         btn.addEventListener("click", function () {
             row.remove();
         });

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
         showData(attributes, selectElement);
     }
     /////////////////////////////////////////////////////////////////////////////////////////////////////
     function getAttrValues(attrId, targetSelect) {
         let url = "{{ route('admin.attributes.fetchValues', ':attribute') }}".replace(':attribute', attrId.value);
         targetSelect.innerHTML = `<option value='' disabled selected>Loading...</option>`;

         fetch(url)
             .then(response => response.json())
             .then(data => {
                 // console.log(data);
                 showData(data, targetSelect);
             });
     }
     /////////////////////////////////////////////////////////////////////////////////////////////////////
     function showData(data, selectInput) {
         selectInput.innerHTML = `  <option value=''  disabled>اختر...</option>`;
         data.forEach(item => {
             const option = document.createElement('option');
             option.value = item.id;
             option.textContent = item.translation.name ?? item.translation.value;
             selectInput.appendChild(option);
         });
     }
     /////////////////////////////////////////////////////////////////////////////////////////////////////
     addAttrBtn.addEventListener("click", function () {
         createAttrInputs(index);
         index++;
     });
     /////////////////////////////////////////////////////////////////////////////////////////////////////
 </script>
@endsection

