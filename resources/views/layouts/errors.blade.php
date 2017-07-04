@if (count($errors) > 0)
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if(session()->has('message'))
	<div class="alert alert-success">
        <ul>
            @foreach (session()->get('message') as $success)
                <li>{{ $success }}</li>
            @endforeach
        </ul>
    </div>
@endif