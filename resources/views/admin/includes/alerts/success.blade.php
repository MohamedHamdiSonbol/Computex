@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
        <strong>{{__('admin/labels.success').' !'}}!</strong> {{ session('success') }}
        {{-- In Bootstrap 4, use data-dismiss (NOT data-bs-dismiss) --}}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif
