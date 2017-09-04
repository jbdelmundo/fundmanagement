@extends('app')

@section('content')

<?php use App\Aysem; ?>
<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Semester Management</h1>
	</div>
</div>

<div class="row">
	<div class="col-lg-3">
		<h3 class="page-header">
			Current Semester: {{ $current_aysem->getShortName() }}
		</h3>
{{ Form::open(['url' => 'semestermanagement' , 'class' => 'form-horizontal', 'method' => 'POST']) }}
				
			


			<button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Move to new semester</button>

<!-- Modal -->
		<div id="myModal" class="modal fade" role="dialog">
		  <div class="modal-dialog">

		    <!-- Modal content-->
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal">&times;</button>
		        <h4 class="modal-title">Confirm Moving to New Semester</h4>
		      </div>
		      <div class="modal-body">
		        <p>This action is irreversible. Moving to a new semester will finalize all balances of each department/institute. No further transactions <strong>(request, endorsement, approval and collection adjustment )</strong> will be made during this semester.
		        </p>
		      </div>
		      <div class="modal-footer">
		        {{ Form::submit("End ".$current_aysem->getFullName(),  ['class'=>'btn btn-success', 'id'=>'btn_approve_'])}}
		        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
		      </div>
		    </div>

		  </div>
		</div>		<!-- Modal -->
{{ Form::close() }}
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
		@include('layouts._alerts')
		
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