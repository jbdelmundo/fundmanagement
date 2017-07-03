@extends('app')

@section('content')
<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Requests</h1>
	</div>
	<!-- /.col-lg-12 -->
</div>
<div class="row">
	<div class="col-lg-12">
		<h3 class="page-header">Requests of {{$department->short_name}} for {{ $aysem->getShortName() }}  </h3>
	</div>
	<!-- /.col-lg-12 -->
</div>

<div class="row">
	<div class="col-lg-12">

		@include('layouts.errors')

        


        @include('_active_dept_selector',['active_department_id'=>$department->id])
        @include('_active_sem_selector',['active_aysem'=>$aysem->aysem])
        
        @include('requests._request_per_category')
       
        
	</div>
</div>
<div class="row">

	<div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Create a new request for {{ $aysem->getShortName() }}
            </div>
            <!-- /.panel-heading -->
            
               
            <div class="panel-body">
                            <!-- Nav tabs -->
                <ul class="nav nav-pills">

                    @foreach($forms as $form)
                    <li {{ $active_form==$form['btn_caption'] ? 'class=active' :'' }} >
                        <a href="#{{$form['form_id']}}"  data-toggle="tab">{{$form['btn_caption']}}</a>
                    </li>
                    @endforeach
                    
                </ul>

                
                <div class="tab-content">

                    @foreach($forms as $form)
                    <div class="tab-pane fade {{ $active_form==$form['btn_caption'] ? 'in active' :'' }}" id="{{$form['form_id'] }}">
                        {!! Form::open()  !!}

                            @include('requests.'.$form['form_path'])
                            {!! Form::hidden('category_id', $form['category_id']) !!}
                            {!! Form::hidden('department_id', $department->id  ) !!}
                            {!! Form::hidden('aysem', \App\Aysem::current()->aysem ) !!}

                            <button type="submit" class="btn btn-primary">Request {{$form['btn_caption']}}</button>
                        {!! Form::close()  !!}

                    </div>
                    @endforeach

                </div>
            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
    </div>
</div>
@endsection