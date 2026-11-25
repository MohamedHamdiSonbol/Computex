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
                                    <form  method="POST" action="{{route('admin.discounts.update', $discount->id)}}" enctype="multipart/form-data">
                                        @csrf
                                        @method('PATCH')

                                        <div class="form-row">

                                            <div class="col-md-4 mb-3">
                                                <label for="validationCustomCampaign">اختار الحملة  - {{ __('messages.'.get_active_lang()) }}</label>
                                                <select class="form-control @error("discount.campaign_id") is-invalid @enderror " name="discount[campaign_id]"  id="validationCustomCampaign">
                                                    <option selected disabled value="">Choose...</option>
                                                    @if(count($campaigns) > 0)
                                                        @foreach($campaigns as $campaign)
                                                         <option value="{{$campaign->id}}"  @selected($campaign->id == old('discount.campaign_id', $discount->campaign_id)) >  {{$campaign->name}}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                                <div class="valid-feedback"> Looks good! </div>
                                                @error("discount.campaign_id")
                                                <div class="invalid-feedback" style="display: block;">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>


                                            <div class="col-md-4 mb-3">
                                                <label for="validationCustomType">نوع الخصم   - {{ __('messages.'.get_active_lang()) }}</label>
                                                <select type="text" class="form-control @error("discount.type") is-invalid @enderror" id="validationCustomType" name="discount[type]" >
                                                    <option value="fixed" @selected(old('discount.type', $discount->type) == 'fixed') >Fixed</option>
                                                    <option value="percentage" @selected(old('discount.type', $discount->type) == 'percentage') >Percentage</option>
                                                </select>
                                                <div class="valid-feedback"> Looks good! </div>
                                                @error("discount.type")
                                                <div class="invalid-feedback" style="display: block;">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>

                                            <div class="col-md-4 mb-3">
                                                <label for="validationCustomValue">قيمة الخصم - {{ __('messages.'.get_active_lang()) }}</label>
                                                <input type="number" class="form-control @error("discount.value") is-invalid @enderror" id="validationCustomValue" name="discount[value]" value="{{ old('discount.value', $discount->value) }}" >
                                                <div class="valid-feedback"> Looks good! </div>
                                                @error("discount.value")
                                                <div class="invalid-feedback" style="display: block;">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>

                                        </div>

                                        <div class="form-row">

                                            <div class="col-md-4 mb-3">
                                                <label for="validationCustomMin_Quant">أقل كمية مطلوبة  - {{ __('messages.'.get_active_lang()) }}</label>
                                                <input type="number" class="form-control @error("discount.min_quantity") is-invalid @enderror" id="validationCustomMin_Quant" name="discount[min_quantity]" value="{{ old('discount.min_quantity', $discount->min_quantity) }}" >
                                                <div class="valid-feedback"> Looks good! </div>
                                                @error("discount.min_quantity")
                                                <div class="invalid-feedback" style="display: block;">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>

                                            <div class="col-md-4 mb-3">
                                                <label for="validationCustomMin_value">أقل قيمة فاتورة مطلوبة  - {{ __('messages.'.get_active_lang()) }}</label>
                                                <input type="number" class="form-control @error("discount.min_order_value") is-invalid @enderror" id="validationCustomMin_value" name="discount[min_order_value]" value="{{ old('discount.min_order_value', $discount->min_order_value) }}" >
                                                <div class="valid-feedback"> Looks good! </div>
                                                @error("discount.min_order_value")
                                                <div class="invalid-feedback" style="display: block;">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>

                                            <div class="col-md-4 mb-3">
                                                <label for="validationCustomUsage_limit">عدد المرات المسموح لعميل واحد  - {{ __('messages.'.get_active_lang()) }}</label>
                                                <input type="number" class="form-control @error("discount.usage_limit_per_user") is-invalid @enderror" id="validationCustomUsage_limit" name="discount[usage_limit_per_user]" value="{{ old('discount.usage_limit_per_user', $discount->usage_limit_per_user) }}" >
                                                <div class="valid-feedback"> Looks good! </div>
                                                @error("discount.usage_limit_per_user")
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
                                                    <input type="checkbox" class="custom-control-input" id="customSwitch" name="discount[is_active]" value="1" @checked(old('discount.is_active', $discount->is_active))>
                                                    <label class="custom-control-label" for="customSwitch">Yes</label>
                                                </div>
                                            </div>

                                            <button class="btn btn-primary col-md-2" type="submit">Submit form</button>

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

{{-- <script>--}}
{{--     let addAttrBtn = document.getElementById("add_row");--}}
{{--     let attrContainer = document.getElementById("attr_container");--}}
{{--     let attrNamesSelect;--}}
{{--     let attrValuesSelect;--}}
{{--     let attrId;--}}
{{--     let attributes = @json($attributes);--}}
{{--     let index = {{count($product['attributeValues'])}};--}}
{{--     let i=0;--}}
{{--     /////////////////////////////////////////////////////////////////////////////////////////////////////--}}
{{--     while( i < index ){--}}
{{--         let selectData = (document.getElementById(`attr_names${i}`));--}}
{{--         let valueData = (document.getElementById(`attr_values${i}`));--}}
{{--         let deleteAttr = (document.getElementById(`remove_attr${i}`));--}}

{{--         selectData.addEventListener("change", function(event){--}}
{{--             console.log(event.target.value)--}}
{{--             getAttrValues(event.target, valueData);--}}
{{--         });--}}

{{--         deleteAttr.addEventListener("click", function(event){--}}
{{--             console.log(event.target)--}}
{{--             event.target.closest('.row_parent').remove();--}}
{{--         });--}}

{{--         i++;--}}
{{--     }--}}
{{--     /////////////////////////////////////////////////////////////////////////////////////////////////////--}}
{{--     function createAttrInputs(currentIndex) {--}}
{{--         if (currentIndex === 0) {--}}
{{--             attrContainer.innerHTML = '';--}}
{{--         }--}}

{{--         const row = document.createElement('div');--}}
{{--         row.className = 'col-md-12 row align-items-end mb-3 row_parent';--}}

{{--         function createSelectCol(labelText, selectId) {--}}

{{--             const col = document.createElement('div');--}}
{{--             col.className = 'col-md-4';--}}

{{--             const label = document.createElement('label');--}}
{{--             label.className = 'form-label';--}}
{{--             label.textContent = labelText;--}}
{{--             label.id = `${selectId}_${currentIndex}`;--}}

{{--             const select = document.createElement('select');--}}
{{--             select.className = 'form-control';--}}
{{--             select.id = `${selectId}_${currentIndex}`;--}}

{{--             const placeholder = document.createElement('option');--}}
{{--             placeholder.textContent = 'اختر...';--}}
{{--             placeholder.value = '';--}}
{{--             placeholder.disabled = true;--}}
{{--             placeholder.selected = true;--}}

{{--             select.appendChild(placeholder);--}}
{{--             col.appendChild(label);--}}
{{--             col.appendChild(select);--}}

{{--             return { col, select };--}}
{{--         }--}}

{{--         const nameData = createSelectCol('اختار الخاصية', 'attr_names');--}}
{{--         const valueData = createSelectCol('اختار القيمة', 'attr_values');--}}

{{--         valueData.select.name = `attribute_values[${currentIndex}]`;--}}

{{--         const btnCol = document.createElement('div');--}}
{{--         btnCol.className = 'col-md-3';--}}

{{--         const btn = document.createElement('button');--}}
{{--         btn.type = 'button';--}}
{{--         btn.className = 'btn btn-danger w-50';--}}
{{--         btn.textContent = 'Remove Row';--}}

{{--         btn.addEventListener("click", function () {--}}
{{--             row.remove();--}}
{{--         });--}}

{{--         btnCol.appendChild(btn);--}}

{{--         nameData.select.addEventListener("change", function (event) {--}}
{{--             getAttrValues(event.target, valueData.select);--}}
{{--         });--}}

{{--         row.appendChild(nameData.col);--}}
{{--         row.appendChild(valueData.col);--}}
{{--         row.appendChild(btnCol);--}}

{{--         attrContainer.appendChild(row);--}}

{{--         getAttributes(nameData.select);--}}
{{--     }--}}

{{--     /////////////////////////////////////////////////////////////////////////////////////////////////////--}}
{{--     function getAttributes(selectElement) {--}}
{{--         showData(attributes, selectElement);--}}
{{--     }--}}
{{--     /////////////////////////////////////////////////////////////////////////////////////////////////////--}}
{{--     function getAttrValues(attrId, targetSelect) {--}}
{{--         let url = "{{ route('admin.attributes.fetchValues', ':attribute') }}".replace(':attribute', attrId.value);--}}
{{--         targetSelect.innerHTML = `<option value='' disabled selected>Loading...</option>`;--}}

{{--         fetch(url)--}}
{{--             .then(response => response.json())--}}
{{--             .then(data => {--}}
{{--                 // console.log(data);--}}
{{--                 showData(data, targetSelect);--}}
{{--             });--}}
{{--     }--}}
{{--     /////////////////////////////////////////////////////////////////////////////////////////////////////--}}
{{--     function showData(data, selectInput) {--}}
{{--         selectInput.innerHTML = `  <option value=''  disabled>اختر...</option>`;--}}
{{--         data.forEach(item => {--}}
{{--             const option = document.createElement('option');--}}
{{--             option.value = item.id;--}}
{{--             option.textContent = item.translation.name ?? item.translation.value;--}}
{{--             selectInput.appendChild(option);--}}
{{--         });--}}
{{--     }--}}
{{--     /////////////////////////////////////////////////////////////////////////////////////////////////////--}}
{{--     addAttrBtn.addEventListener("click", function () {--}}
{{--         createAttrInputs(index);--}}
{{--         index++;--}}
{{--     });--}}
{{--     /////////////////////////////////////////////////////////////////////////////////////////////////////--}}
{{-- </script>--}}
@endsection

