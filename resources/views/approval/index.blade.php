@extends('app')

@section('content')
<div class="panel panel-default">
    <div class="panel-heading">
	  	Endorsements  
    </div>

    <div class="panel-body">
@if(count($endorsements)>0)

	@foreach($endorsements as $type => $request_endorsement)
            @if(count($request_endorsement) >0)
					@foreach($request_endorsement as $request)
					{{ Form::open(['url' => 'approval' , 'class' => 'form-horizontal']) }} 
                    <div class='form-group'>
					{{ Form::hidden('request_id',$request->request_id)}}
							{{$request->request_id}}
							{{ Form::submit('Endorse',  ['class'=>'btn btn-success', 'id'=>'btn_approve_'.$request->id])}}


                    </div>    
                    {{ Form::close() }}
					
					@endforeach
				   
			@else
				No {{$type}} endorsements.
           	@endif
	@endforeach
		
</div>
@else
	<div class="panel-body">
	  	No endorsements.  
    </div>

@endif
</div>
@endsection