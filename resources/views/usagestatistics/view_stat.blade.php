@extends('app')

@section('content')

<?php use App\Aysem; ?>

<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Usage Statistics: View</h1>
	</div>
</div>

<div class="row">
	<div class="col-lg-12">
	<a href="{{url('usagestatistics')}}">Back to E-Resources</a>
		<h3 class="page-header">
			 {{$eresource['title']}} Subscription Details
		</h3>
	</div>	


<div class="col-lg-12">

	<div class="panel">

	@include('layouts._alerts')
		<table class="table table-bordered" style = "font-size:20px">
			<?php
				$months=['January','February','March','April','May','June','July','August','September','October','November','December'];
				$sdate = $eresource['startdate'];
				$sdate = explode("-",$sdate);
				$edate = $eresource['enddate'];
				$edate = explode("-",$edate);


				//counters for loop
				$ctr = $edate[0]-$sdate[0];
				$firstmonth=(int)$sdate[1]-1;
				
				$years=array();$years[0]=$sdate[0];
				for($i=1;$i<=$ctr;$i++){
					$years[$i] = $years[$i-1]+1;
				}//endfor

				$diff = (($edate[0]-$sdate[0])*12) + ($edate[1]-$sdate[1]);

				session(['year_arr'=>$years,'month_arr'=>$diff, 'f_month'=>$firstmonth,'diff'=>$diff,'y_diff'=>$ctr]);
			?>
			<tr>
				<th>       </th>
				<th> Month </th>
				<th> Year </th>
				
			</tr>
			<tr>
				<td>Start</td>
				<td>{{$months[(int)$sdate[1]-1]}}</td>
				<td>{{$sdate[0]}}</td>
			</tr>
			<tr>
				<td>End</td>
				<td>{{$months[(int)$edate[1]-1]}}</td>
				<td>{{$edate[0]}}</td>
			</tr>		
		</table>
	</div>
	</div>
</div>

<div class="panel">
	<!-- Graph here -->
	
</div>
@endsection