<?php use \App\Requests; ?>

@if(count($items)>0)
<div class="panel panel-primary">
    <div class="panel-heading">
	  {{$heading}}  
    </div>
        
    <div class="panel-body">    
        
    	
            <table class="table table-striped table-responsive">
                <thead>
                    <tr>
                    
                        <th style='width:15%'>Title</th>
                        <th style='width:10%'>Author</th>
                        <th style='width:10%'>Subject</th>
                        <th style='width:5%'>Qty</th>                        
                        <th style='width:10%'>Section</th> 
                        <th style='width:5%'>Unit price</th>
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
                        <td> {{$item->title}}</td>
                        <td>{{$item->author}}</td>
                        <td>{{ Form::text('subject',null, 
                                ['class'=>'form-control','id'=>'subject_'.$item->id,'required']) }}</td>
                        <td>{{ Form::number('quantity',1,
                                ['class'=>'form-control', 'min'=>'1','required']) }}</td>
                        <td>{{ Form::select('is_reserved', ['0' => 'Circulation', '1' => 'Reserved'], 0, 
                                ['class'=>'form-control'])   }}</td>

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
    
</div>
 @endif

<script type="text/javascript">
    
</script>