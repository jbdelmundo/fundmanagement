<?php use \App\Requests; ?>

@if(count($items)>0)

<div class="panel panel-primary">
    <div class="panel-heading">
	  {{$heading}}  
    </div>
        
        
        
    	
            <table class="table table-striped table-responsive">
                <thead>
                    <tr>                     
                        <th style='width:15%'>Title</th>
                        <th style='width:10%'>Publisher</th>
                        <th style='width:10%'>Subject</th>
                        
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
                        <td>{{$item->publisher}}</td>
                        <td>{{ Form::text('subject',null, 
                                ['class'=>'form-control','id'=>'subject_'.$item->id]) }}
                        </td>
                        <input type="hidden" name="quantity" value='1'/>
                        

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