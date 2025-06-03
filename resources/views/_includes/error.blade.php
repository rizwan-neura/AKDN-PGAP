@if (Session::has('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert" id="error-alert">
        <h5><i class="icon fas fa-ban"></i> Alert!</h5> {{ Session::get('error') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif
