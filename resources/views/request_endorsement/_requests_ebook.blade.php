<?php use \App\Requests; ?>


@if(count($items)>0)

<div class="panel panel-primary">
    <div class="panel-heading">
	  {{$heading}}  
    </div>
    
        @if(count($items)>0)
        
    	
            <table class="table table-striped table-responsive">
                <thead>
                    <tr>
                        <th >Title</th>
                        <th >Author</th>
                        <th style='width:10%' >Subject</th> 
                        <th style='width:5%'>Unit price</th>                       
                        <th >Remarks</th> 
                        <th style='width:10%'>Action</th>                     
                        
                    </tr>
                </thead>
                <tbody>
                    @foreach($items as  $item)
                   <tr>

                   {{ Form::open(['url' => 'endorsement' , 'class' => 'form-horizontal']) }} 
                    <div class='form-group'>
                        {{ Form::hidden('request_id',$item->id)}}
                        {{ Form::hidden('quantity',1) }}
                        <td> {{$item->title}}</td>
                        <td>{{$item->author}}</td>
                        <td>{{ Form::text('subject',null, 
                                ['class'=>'form-control','id'=>'subject_'.$item->id]) }}</td>
                        
                        

                        <td>{{$item->unit_quote_price}}</td>
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

@endif

<script type="text/javascript">
    


</script>