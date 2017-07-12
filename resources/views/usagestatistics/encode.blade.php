@extends('app')

@section('content')

<?php use App\Aysem; ?>

<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Usage Statistics: Encode</h1>
	</div>
</div>

<div class="row">
	<div class="col-lg-12">
		<h3 class="page-header">
			List of Available E Resources for the Department of {{$department->short_name}} 
		</h3>
	</div>	
</div>

<div class="panel">
	@include('layouts.errors')
		<table class="table table-bordered">
			<tr>
				<th> Title </th>
				<th> Publisher </th>
				<th> Start Date </th>
				<th> End Date </th>
				<th> Action</th>
			</tr>
			@foreach($list as $key => $list_item)
			<tr>
				<td>{{ $list_item['title'] }}</td>
				<td>{{ $list_item['publisher'] }}	</td>
				<td>{{ $list_item['startdate'] }}	</td>
				<td>{{ $list_item['enddate'] }}	</td>
				<td> 
					{{ Form::open(['url' => 'usagestatistics/encode/'.$list_item['id'] , 'class' => 'form-horizontal', 'method' => 'POST']) }}
					
					<input type="hidden" name="_token"  value="{{ csrf_token() }}" ">
					{{ Form::submit('Go To Form',  ['class'=>'btn btn-success', 'id'=>'btn_approve_']) }}
				</td>
			</tr>	
			@endforeach
		</table>
</div>
@endsection