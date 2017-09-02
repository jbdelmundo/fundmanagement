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
			 {{$eresource['title']}} Subscription Details
		</h3>
	</div>	
</div>

<div class="panel">
	@include('layouts.errors')
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

<div class = "panel">
	<button type="button" class="btn btn-default" onclick="show()">	
		Show Form
	</button>
</div>		

<script type="text/javascript">
function show(){
	var form = document.getElementById('form');
    if (form.style.display === 'none') {
        form.style.display = 'block';
    } else {
        form.style.display = 'none';
    }
}
</script>

<!-- FORM -->

<div class="row" id="form" style="display:none">
	<div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Encode Usage Statistics
            </div>
            <!-- /.panel-heading -->
               
            <div class="panel-body">
                <div class="tab-content">
                {{ Form::open(array('url' => 'usagestatistics/index/'.$eresource['id'] , 'class' => 'form-horizontal', 'method' => 'POST')) }}
                <input type="hidden" name="_token"  value="{{ csrf_token() }}" ">
					<table class="table table-hover">
					<tr>
					<th> Year </th>
					<th> Month </th>
					<th> Usage </th>
					</tr>
				<?php
				$ctr2 = $firstmonth; 
				for($i=0;$i<=$ctr;$i++){
				  ?>
					<tr><td><h4 >{{$years[$i]}}</h4> </td></tr>
					<?php while($diff>=0){
						
						if($ctr2==12){
							$ctr2=0;
							break;
						}
					?>
						<tr>
							<td ></td>
							<td>{{Form::label($months[$ctr2])}}</td>
							<td>{{Form::text('stats-'.$diff,'1')}}</td>
						</tr>
					<?php  
						$diff = $diff-1;
						$ctr2=$ctr2+1;
					}?>		
				<?php  }?>
				</table>
             </div>
				{{ Form::submit('Submit',  ['class'=>'btn btn-success', 'id'=>'btn_approve_']) }}
				{{!! Form::close() !!}}
            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
    </div>
</div>
@endsection