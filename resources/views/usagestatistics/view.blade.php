@extends('app')

@section('content')

<?php use App\Aysem; ?>

<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Usage Statistics: Viewing</h1>
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
	@include('layouts._alerts')
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
				<td> <a href = "{{url('usagestatistics').'/'.$list_item['id']}}" class="btn btn-info" role="button">View Statistics</a>
				</td>
			</tr>	
			@endforeach
		</table>
</div>
@endsection