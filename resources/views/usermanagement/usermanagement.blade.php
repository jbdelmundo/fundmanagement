
@extends('app')

@section('content')



<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">User Management</h1>
	</div>
	<!-- /.col-lg-12 -->
</div>


@include('_user_selector')


<div class="panel panel-primary" style="width:400px" >

	<div class="panel-heading">
		User	
	</div>
         
    {!! Form::open() !!}

	<div class="panel-body" >
    	{{Form::label('username', 'Username') }} <br>
    	{{Form::text('username', $def_user->username, ['class'=>'form-control', 'style'=>'width:300px']	)}}
    </div>			
    

    
    <div class="panel-body" >
        {{Form::label('pw', 'Password') }} <br>
    	{{Form::password('pw',['class'=>'form-control', 'style'=>'width:300px'])}}
    </div>

    <div class="panel-body" >
    	{{Form::label('email', 'E-Mail') }} <br>
    	{{Form::text('email',$def_user->email, ['class'=>'form-control', 'style'=>'width:300px'])}}
    </div>

    <div class="panel-body" >
    	{{Form::label('dept', 'Department') }}
        <select name='dept_selector' class="form-control" style="width:300px" >
        @foreach($departments as $d)
            <option value={{$d->id}} @if($def_user->department_id == $d->id) selected @endif>
            	{{$d->short_name}}
        	</option>
        @endforeach
    </select>
    </div>


     <div class="panel-body" >
    	{{Form::label('role', 'User Role') }}
    	<select name='role_selector' class="form-control" style="width:300px">
        @foreach($roles as $r)
            <option value={{$r->id}} @if($def_user->userrole_id == $r->id) selected @endif>
            	{{$r->role}}
        	</option>
        @endforeach
    </select>
    </div>

    {!! Form::hidden('selected_user', $def_user->id) !!}
    <center>
        <button type="submit" class="btn btn-primary">Save</button>
    </center>
        
       {!! Form::close()  !!}
    
</div>        
 


@endsection
