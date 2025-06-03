@if ($errors->any())
    <div class="alert alert-danger" role="alert" id="errors-alert">
        <h5><i class="icon fas fa-ban"></i> Alert!</h5>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <!--
        <ul>
            @foreach ($errors->all() as $error)
                <li> {{ $error }} </li>
            @endforeach
        
        </ul> -->

        Please fix below mentioned issues!


    </div>
@endif
