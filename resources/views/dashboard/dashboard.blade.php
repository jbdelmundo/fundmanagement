
@extends('app')

@section('content')


	
<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Dashboard of {{$department->short_name}}</h1>
	</div>
</div>

@if(\Auth::user()->isLibrarian())
    @include('_active_dept_selector')

@endif
    @include('_active_sem_selector',['active_aysem'=>$aysem->aysem])

<div class="panel-body">
    
    <h4>Current Balance: {{ number_format( $current_balance ,  2 ,  "." ,  "," ) }}</h4>
</div>

<div class="row">
@include('layouts._alerts')

	<div class="col-lg-12">
		<div class="panel panel-default">
		    <div class="panel-heading">
				Transactions for  {{ $aysem->shortName()}}
		    </div>
		    <div class="panel-body">
		    <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Type</th>
                        <th></th>
                        <th style='text-align: right'>Debit</th>
                        <th style='text-align: right'>Credit</th>
                        <th style='text-align: right'>Balance</th>
                    </tr>
                </thead>
                <tbody>

				    @foreach($transactions as $key => $transaction)
                    <tr id='row_trans_{{$transaction->id}}'
                       
                    >
                        <td>{{$transaction['created_at']}} {{$transaction->id}}</td>
                        <td>{{$types[$transaction['transaction_type_id']]}}
                        </td>
                        <td>
                        @if(in_array($transaction['transaction_type_id'],['P','R'] ) )
                            <i data-toggle="modal" data-target='#item-modal-{{$purchased_items[$transaction['id']]->request_id}}' class="fa fa-search">View</i>

                        @elseif(in_array($transaction['transaction_type_id'],['C','A'] ) )
                            <i data-toggle="modal" data-target='#collection-modal' class="fa fa-search"
                            onclick="prep_collection_modal({{$transaction->collection_id}})" 
                            >View</i>
                        @endif
                        </td>
                        </td>
                        @if($transaction->amount > 0)
                            <td align="right ">{{  number_format ( $transaction->amount ,  2 ,  "." ,  "," )  }}</td>
                            <td></td>
                        @else
                            <td></td>
                            <td align="right ">{{  number_format ( -1*$transaction->amount ,  2 ,  "." ,  "," )  }}</td>
                        @endif
                        <td align="right">{{  number_format ( $transaction->balance ,  2 ,  "." ,  "," )  }}</td>
                    </tr>
                    @if(in_array($transaction['transaction_type_id'],['P','R'] ))
                        @include('dashboard._modal_item',['request' => $purchased_items[$transaction['id']] ] )
                    @endif
                    

                    @endforeach
                </tbody> 
            </table>
		    </div>
	    </div>
    </div>
</div>

<div id="collection-modal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Collection/Adjustment Information</h4>
      </div>
      <div class="modal-body">
            <div id='colection-modal-body'></div>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        $("#collection-modal").on('shown.bs.modal', function () {
                // alert('The modal is fully shown.');
            // console.log(collection_id)
            
        });

        
    })
    function prep_collection_modal(id){
            console.log(id)
            if(id == undefined){
                $('#colection-modal-body').html('')
                return
            }
            $.ajax({
            type: "GET",
            url: "{{ url('collection/view') }}" + '/'+id,
             // serializes the form's elements.
            success: function(data)
                {
                    
                    $('#colection-modal-body').html(data)

                }
            });
        }
</script>
    
@include('requests._request_per_category')
       




@endsection