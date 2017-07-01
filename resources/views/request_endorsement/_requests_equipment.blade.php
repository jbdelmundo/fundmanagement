<?php use \App\Requests; ?>


<div class="panel panel-primary">
    <div class="panel-heading">
	  {{$heading}}  
    </div>
        
        @if(count($items)>0)
        
    	
            <table class="table table-striped table-responsive">
                <thead>
                    <tr>
                        <th style='width:30%'>Description</th>
                        <th style='width:20%'>Price</th>
                        
                        <th style=width:10%>Qty</th>
                        <th style='width:29%'>Remarks</th>
                        <th> Action </th>
                                           
                        
                    </tr>
                </thead>
                <tbody>
                    @foreach($items as  $item)
                   <tr>

                   {{ Form::open(['url' => 'endorsement' , 'class' => 'form-horizontal']) }} 
                    <div class='form-group'>
                        {{ Form::hidden('request_id',$item->id)}}
                        <td> {{$item->description}}</td>
                        <td>{{$item->unit_quote_price}}</td>
                        <td>{{ Form::number('quantity',1,
                                ['class'=>'form-control', 'min'=>'1']) }}</td>
                        <td>{{$item->remarks}}</td>
                        <td>{{ Form::submit('Endorse',  ['class'=>'btn btn-success', 'id'=>'btn_approve_'.$item->id])}}</td>


                    </div>    
                    {{ Form::close() }}
                    </tr>
                    @endforeach
                    
                </tbody>
            </table>
            
        
   		@else
        <div class="panel-body">
        	No items to show.
        </div>
        @endif
    
</div>

<script type="text/javascript">
    


</script>