@if (Session::has('message'))
    <div style="height:10px;"></div>
    <div class="alert alert-success alert-dismissible fade show" role="alert" id="success-alert">
        <h5><i class="icon fas fa-check"></i> Success!</h5>
        {{ Session::get('message') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

