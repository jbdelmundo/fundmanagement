
@extends('app')

@section('content')



<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">User Management</h1>
	</div>
	<!-- /.col-lg-12 -->
</div>

@include('_active_user_selector')
@include('layouts._alerts')


<div class="panel panel-primary"  >

    <div class="panel-heading">
        User    
    </div>
         
    {!! Form::open() !!}

    <div class="panel-body" >
        {{Form::label('username', 'Username') }} <br>
        {{Form::text('username', $current_user->username, ['class'=>'form-control' , 'min'=>3]    )}}
    
    
        {{Form::label('email', 'E-Mail') }} <br>
        {{Form::text('email',$current_user->email, ['class'=>'form-control'])}}
    

        {{Form::label('dept', 'Department') }}
        <select name='dept_selector' class="form-control"" >
        @foreach($departments as $d)
            <option value={{$d->id}} @if($current_user->department_id == $d->id) selected @endif>
                {{$d->short_name}}
            </option>
        @endforeach
        </select>
    
        {{Form::label('role', 'User Role') }}
        <select name='role_selector' class="form-control" ">
        @foreach($roles as $r)
            <option value={{$r->id}} @if($current_user->userrole_id == $r->id) selected @endif>
                {{$r->role}}
            </option>
        @endforeach
        </select>
    

        {!! Form::hidden('selected_user', $current_user->id) !!}
        
            <button type="submit" class="btn btn-primary">Update</button>
       
        {!! Form::close()  !!}
    </div>
    
</div>       

<div class="panel panel-primary"  >

    <div class="panel-heading">
        Change Password    
    </div>
         
    {!! Form::open(['url'=>'usermanagement/changepassword']) !!}

    <div class="panel-body" >        
    

        {{Form::label('pw', 'Password') }} <br>
        {{Form::password('password',['class'=>'form-control' , 'requried'])}}

        {{Form::label('confirm_password', 'Confirm Password') }} <br>
        {{Form::password('confirm_password',['class'=>'form-control','required'])}}
    
       
    

        {!! Form::hidden('selected_user', $current_user->id) !!}
        
            <button type="submit" class="btn btn-primary">Update</button>
       
        {!! Form::close()  !!}
    
</div>        
 


@endsection
