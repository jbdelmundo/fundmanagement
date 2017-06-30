
@extends('app')

@section('content')


	
<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Dashboard of</h1>
	</div>
	<!-- /.col-lg-12 -->
</div>
<?php
//dd($endorsements);
?>

@if(\Auth::user()->isLibrarian())
    @include('_active_dept_selector')
@else
    \Auth::user()->department->short_name()
@endif
<div class="panel-body">    
    Beginning Balance: {{$beginning_balance}}
    <hr>
    Current Balance: {{$beginning_balance}}
    <hr>
</div>



<div class="row">

@include('layouts.errors')
	<div class="col-lg-12">
		<div class="panel panel-default">
		    <div class="panel-heading">
				Books, E-books, Journals, & Magazines  
		    </div>
		    <div class="panel-body">
		    <table class="table table-striped table-responsive">
                <thead>
                    <tr>
                       <th>Title</th>
                       <th>Type</th>
                       <th>Quantity</th>
                       <th>Unit Quote Price</th>
                       <th>Total</th>
                       <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($endorsements as $key => $endorsement)
				    <tr>
                    {{ Form::open(['url' => 'approval' , 'class' => 'form-horizontal', 'method' => 'POST']) }} 
                    <div class='form-group'>
                        {{ Form::hidden('request_id',$endorsement['request_id'])}}
                        <td>{{$endorsement['title']}}</td>
                        <td>{{$key}}</td>
                        <td>{{$endorsement['qty']}}</td>
                        <td>{{$endorsement['unit_quote_price']}}</td>
                        <td>{{$endorsement['unit_quote_price']*$endorsement['qty']}}</td>
                        <td>
                            {{ Form::submit('Approve',  ['class'=>'btn btn-success', 'id'=>'btn_approve_'.$endorsement['request_id']])}}
                        </td>
                    </div>
                    </tr>
                    @endforeach
                </tbody> 
            </table>
		    </div>
	    </div>
    </div>

    <div class="col-lg-12">
	</div>


	

    
</div>




@endsection
