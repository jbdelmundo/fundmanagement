
@extends('app')

@section('content')


	
<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Endorsements for Approval of {{$department->short_name}}</h1>
	</div>
</div>

@if(\Auth::user()->isLibrarian())
    @include('layouts.department_dropdowns')
@else
    \Auth.user()->department->short_name();
@endif    

<div class="row">
@include('layouts.errors')

	<div class="col-lg-4">
        <div class="panel panel-default">
            <div class="panel-heading">
              CURRENT BALANCE: {{$current_balance}}
            </div>
            
        </div>
    </div>

    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Others, Equipment, Supplies  
            </div>
            <div class="panel-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Description</th>
                        <th>Qty</th>
                        <th>Type</th>
                        <th width=15%>Unit Quote Price</th>
                        <th>Total</th>
                        <th>Action</th>                       
                    </tr>
                </thead>
                <tbody>
                    
                    @foreach($endorsements as $key => $endorsement)
                    <tr>
                    @if($key=='Q' || $key=='S' || $key=='O')
                        
                        <td>{{$endorsement['description']}}</td>
                        <td>{{$endorsement['qty']}}</td>
                        <td>{{$key}}</td>
                        <td>{{$endorsement['unit_quote_price']}}</td>
                        <td>{{$endorsement['qty'] * $endorsement['unit_quote_price']}}</td>
                        <td>
                            <form method="GET" action="approval">
                            <button type="submit" name="Approve" class="btn btn-primary pull-left">Approve</button>
                            </form> 
                        </td>
                    </tr>
                    @endif
                    @endforeach     
                </tbody>
            </table>
            </div>
        </div>
    </div>
</div>










@endsection
