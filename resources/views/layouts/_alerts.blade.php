@if (count($errors) > 0)
    <div class="alert alert-danger" role="alert">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if(session()->has('alert-success'))
    <div class="alert alert-success" role="alert">
        {{session()->get('alert-success')}}
    </div>
@endif


@if(session()->has('alert-info'))
    <div class="alert alert-info" role="alert">
        <ul>
            @foreach (session()->get('alert-info') as $msg)
                <li>{{ $msg }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if(session()->has('alert-warning'))
    <div class="alert alert-warning" role="alert">
        <ul>
            @foreach (session()->get('alert-warning') as $msg)
                <li>{{ $msg }}</li>
            @endforeach
        </ul>
    </div>
@endif