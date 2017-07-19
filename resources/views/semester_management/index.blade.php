@extends('app')

@section('content')

<?php use App\Aysem; ?>
<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Semester Management</h1>
	</div>
</div>

<div class="row">
	<div class="col-lg-12">
		<h3 class="page-header">
			Current Semester: {{ $current_aysem->getShortName() }}
		</h3>
			{{ Form::open(['url' => 'semestermanagement' , 'class' => 'form-horizontal', 'method' => 'POST','onsubmit' => 'return confirm("are you sure ?")']) }}
				<input type="hidden" name="_token"  value="{{ csrf_token() }}" ">
			{{ Form::submit('New Semester',  ['class'=>'btn btn-success', 'id'=>'btn_approve_'])}}
	</div>	
</div>

<!--
Add this:
<div class="alert alert-success">
  <strong>Success!</strong> A new semester has been added.
</div>
-->


<div class="row">
	<div class="col-lg-12">
		<h3 class="page-header">List of Semesters</h3>
	</div>	
</div>

<div class="panel">
		@include('layouts.errors')
		
		<?php
			$existing_semesters=Aysem::all();
			$existing_semesters=$existing_semesters->sortByDesc('aysem');
		?>
		
        @foreach($existing_semesters as $sem)
		    <div class = "col-sm-4" style="font-size:20px">
				{{$sem['short_name']}}
			</div>		
        @endforeach	
</div>
@endsection