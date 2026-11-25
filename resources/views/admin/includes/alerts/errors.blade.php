@if(session('error') || $errors->any())
    <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
        <strong>{{__('admin/labels.error').' !'}}</strong>
        {{ session('error') ?: $errors->first() }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif



{{-- Why this is better:-     --}}
{{--   session('error')  :- Catches your manual try-catch message.--}}

{{--   $errors->first()  :- Catches the first validation error if the user forgets a field.--}}

{{--   ?::   :-This is a shorthand that says: "If there is a manual error, show it; otherwise, show the validation error."--}}
