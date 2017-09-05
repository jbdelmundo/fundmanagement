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
	<!-- <div id="placeholder" style="width:100%;height:400px"></div> -->
	<div id="usage" style="width:100%;height:500px"></div>

</div>

<script src="{{asset('js/jquery.flot.js')}}"></script>
<script src="{{asset('js/jquery.flot.time.js')}}"></script>

<script type="text/javascript">
	// $.plot($("#placeholder"), [ [[0, 0], [1, 1]] ], { yaxis: { max: 1 } });
</script>

<script type="text/javascript">



	var testDate = new Date(2017,10,1).getTime()
	// var data = [
	// 		[ new Date(2017,10,1).getTime() , 				51 ], 
	// 		[ new Date(2017,11,1).getTime() , 677],
	// 		[ new Date(2018,2,1).getTime() , 127],
	// 		[ new Date(2018,0,1).getTime() , 357]
	// ];


	var data = [
		@foreach($stats as $year => $stat)
			@foreach($stat as $month => $usage)
				[  new Date({{$year}},{{$month}},1).getTime()  , {{$usage}}  ],
				// console.log(  new Date({{$year}},{{$month}},1).getTime() )
			@endforeach
		@endforeach
	]

	$.plot("#usage", [data], {
				points: {show:true},
				lines: {show:true},
				xaxis: {
					mode: "time",
					minTickSize: [1, "month"],
					min: (new Date({{$sdate[0]}}, {{$sdate[1]-1}}, 1)).getTime(),
					max: (new Date({{$edate[0]}}, {{$edate[1]}}, 1)).getTime(),
					timeformat: "%b %Y"
				}
			});
</script>
@endsection