<?php use \App\Requests; ?>

@if(count($items)>0)  

<div class="panel panel-primary">
    <div class="panel-heading">
      {{$heading}}  
    </div>
        
        
    	
            <table class="table table-striped table-responsive">
                <thead>
                    <tr>
                      

                        <th style='width:30%'>Description</th>
                        <th style='width:10%'>Qty</th>
                        
                        <th style='width:10%'>Unit price</th>
                        <th style='width:10%'>Remarks</th> 
                        <th style='width:5%'>Action</th> 
                                           
                        
                    </tr>
                </thead>
                <tbody>
                    @foreach($items as  $item)
                   <tr>

                   {{ Form::open(['url' => 'endorsement' , 'class' => 'form-horizontal']) }} 
                    <div class='form-group'>

                        {{ Form::hidden('request_id',$item->request_id)}}
                        <td> {{$item->description}}</td>
                        <td>{{ Form::number('quantity',1,
                                ['class'=>'form-control', 'min'=>'1']) }}</td>
                        <td>{{$item->unit_quote_price}}</td>
                        <td>{{$item->remarks}}</td>
                        <td>{{ Form::submit('Endorse',  ['class'=>'btn btn-success', 'id'=>'btn_approve_'.$item->id])}}</td>


                    </div>    
                    {{ Form::close() }}
                    </tr>
                    @endforeach
                    
                </tbody>
            </table>
            
    
</div>
@endif

<script type="text/javascript">
    
</script>