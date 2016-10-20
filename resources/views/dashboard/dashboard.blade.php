
@extends('app')

@section('content')


	
<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Dashboard of {{$department->short_name}}</h1>
	</div>
	<!-- /.col-lg-12 -->
</div>
@if(\Auth::user()->isLibrarian())
    @include('layouts.department_dropdowns')
@endif

<div class="row">
@include('layouts.errors')

	<div class="col-lg-12">
		<div class="panel panel-default">
		    <div class="panel-heading">
				Account Summary  
		    </div>
		    <div class="panel-body">
		    <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Semester</th>
                        <th>Previous Balance</th>
                        <th>Collection</th>
                        <th>Adjustments</th>
                        <th>Expenses</th>
                        <th>Refunds</th>
                        <th>Balance</th>                       
                    </tr>
                </thead>
                <tbody>
                @foreach($aysem_summary as $aysem => $summary)
                	<tr>
                		<td>{{\App\Aysem::abbrev($aysem)}}</td>
                        <td>{{ number_format( $summary['PREV_BALANCE'] ,  2 ,  "." ,  "," )  }}</td>
                        <td>{{ number_format( $summary['COLLECTION'] ,  2 ,  "." ,  "," )  }}</td>
                        <td>{{ number_format( $summary['ADJUSTMENT'] ,  2 ,  "." ,  "," )  }}</td>
                        <td>{{ number_format( $summary['PURCHASE'] ,  2 ,  "." ,  "," )  }}</td>
                        <td>{{ number_format( $summary['REFUND'] ,  2 ,  "." ,  "," )  }}</td>
                        <td>{{ number_format( $summary['BALANCE'] ,  2 ,  "." ,  "," )  }}</td>
                  	</tr>	
				
				@endforeach                    
                </tbody>
            </table>
		    </div>
	    </div>
    </div>

    <div class="col-lg-12">
	@include('dashboard._balance_history_chart')   
	</div>


	<div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
              Summary of expenses 
            </div>
            <div class="panel-body">
             <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Sem</th>
                        <th>1st</th>
                        <th>2nd</th>
                        <!-- <th>Type</th> -->
                        <th>mid</th>
                       
                    </tr>
                </thead>
                <tbody>
                    @foreach($balance_history as  $history)
                    <tr>

                       
                        
                    </tr>
                    @endforeach
                    
                </tbody>
            </table>
            </div>
        </div>
    </div>


    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
              Balance history  
            </div>
            <div class="panel-body">
             <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Sem</th>
                        <th>Income</th>
                        <th>Expenses</th>
                        <!-- <th>Type</th> -->
                        <th>Balance</th>
                       
                    </tr>
                </thead>
                <tbody>
                    @foreach($balance_history as  $history)
                    <tr>

                        <td>{{\App\Aysem::abbrev($history->aysem)}}</td>
                        <td>{{$history->transaction_type_id=='C'? number_format( $history->amount ,  2 ,  "." ,  "," ) : ''}}</td>
                        <td>{{$history->transaction_type_id=='P'? number_format( $history->amount  ,  2 ,  "." ,  "," ): ''}}</td>
                        
                       <!--  <td>{{$history->transaction_type_id}}</td> -->
                        <td>{{ number_format( $history->balance ,  2 ,  "." ,  "," )}}</td>
                        
                    </tr>
                    @endforeach
                    
                </tbody>
            </table>
            </div>
        </div>
    </div>

</div>




@endsection
