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
			 {{$eresource['title']}}
		</h3>
	</div>	
</div>

<div class="panel">
	@include('layouts.errors')
		<table class="table table-bordered">
			<tr>
				<th> Start Month </th>
				<th> Start Year </th>
				<th> End Month </th>
				<th> End Year </th>
				
			</tr>
			<tr>
				<td>{{ $eresource['startdate'] }}</td>
				<td>{{ $eresource['startdate'] }}	</td>
				<td>{{ $eresource['enddate'] }}	</td>
				<td>{{ $eresource['enddate'] }}	</td>
			</tr>	
		</table>
</div>
@endsection