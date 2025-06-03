<div class="row">
    <div class="col-md-6 text-muted">
        Showing {{ $data->firstItem() }} to {{ $data->lastItem() }} of total {{ $data->total() }}
        entries
    </div>
    <div class="col-md-6 d-flex justify-content-md-end justify-content-center">
        {{ $data->onEachSide(2)->links('pagination::bootstrap-4') }}

    </div>
</div>