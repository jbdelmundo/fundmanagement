<?php use \App\Requests;
use Illuminate\Support\Facades\DB;

    $stats =DB::table('request_statuses')->get()->toArray();
    $statuses = [];
    foreach ($stats as  $value) {
        $statuses[$value->id] = $value->status;
    }
    
?>
<?php 
    $items = $requests_this_sem[Requests::BOOK] ;
 ?>
@if(count($items)>0)
<div class="panel panel-primary">
    <div class="panel-heading">
	  Books	  
    </div>
    <div class="panel-body">
        
        <div class="table-responsive">
    	
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Publisher</th>
                        <th>Year</th>
                        <th>Unit price</th>
                        <th>Status</th>
                       
                     
                    </tr>
                </thead>
                <tbody>
                    @foreach($items as  $item)
                    <tr>
                        <td>{{$item->title}}</td>
                        <td>{{$item->author}}</td>
                        <td>{{$item->publisher}}</td>
                        <td>{{$item->copyright_date}}</td>
                        <td>{{$item->unit_quote_price}}</td> 
                        <td>{{ $statuses[$item->status] }}</td>               
                    </tr>
                    @endforeach
                    
                </tbody>
            </table>
            
        </div>
   		
        
    </div>
</div>
@endif

<?php 
    $items = $requests_this_sem[Requests::EBOOK] ;
 ?>


@if(count($items)>0)
<div class="panel panel-primary">
    <div class="panel-heading">
	  E-Books	  
    </div>
    <div class="panel-body">
        
        <div class="table-responsive">
    	
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Publisher</th>
                        <th>Year</th>
                        <th>Unit price</th>
                        <th>Status</th>
                       
                     
                    </tr>
                </thead>
                <tbody>
                    @foreach($items as  $item)
                    <tr>
                        <td>{{$item->title}}</td>
                        <td>{{$item->author}}</td>
                        <td>{{$item->publisher}}</td>
                        <td>{{$item->copyright_date}}</td>
                        <td>{{$item->unit_quote_price}}</td> 
                        <td>{{ $statuses[$item->status] }}</td>                
                    </tr>
                    @endforeach
                    
                </tbody>
            </table>
            
        </div>
   		
        
    </div>
</div>
@endif

<?php 
    $items = $requests_this_sem[Requests::JOURNAL] ;
 ?>
@if(count($items)>0)
<div class="panel panel-primary">
    <div class="panel-heading">
	Journals	  
    </div>
    <div class="panel-body">
    	
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Publisher</th>
                        <th>Unit price</th>
                        <th>Status</th>
                        
                    </tr>
                </thead>
                <tbody>
                    @foreach($items as  $item)
                    <tr>
                        <td>{{$item->title}}</td>
                        <td>{{$item->author}}</td>
                        <td>{{$item->publisher}}</td>
                        <td>{{$item->unit_quote_price}}</td>
                        <td>{{ $statuses[$item->status] }}</td> 
                       
                    </tr>
                    @endforeach
                    
                </tbody>
            </table>           
        </div>
    </div>
</div>
@endif

<?php 
    $items = $requests_this_sem[Requests::MAGAZINE] ;
 ?>

@if(count($items)>0)
<div class="panel panel-primary">
    <div class="panel-heading">
	Magazines	  
    </div>
    <div class="panel-body">
    	
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Publisher</th>
                        <th>Unit price</th>
                        <th>Status</th>
                        
                    </tr>
                </thead>
                <tbody>
                    @foreach($items as $item)
                    <tr>
                        <td>{{$item->title}}</td>
                        <td>{{$item->author}}</td>
                        <td>{{$item->publisher}}</td>
                        <td>{{$item->unit_quote_price}}</td>
                       <td>{{ $statuses[$item->status] }}</td> 
                    </tr>
                    @endforeach
                    
                </tbody>
            </table>
           
        </div>
     	
        
   
    </div>
</div>
@endif

<?php 
    $items = $requests_this_sem[Requests::ERESOURCE] ;
 ?>
@if(count($items)>0)
<div class="panel panel-primary">
    <div class="panel-heading">
	E-Resources	  
    </div>
    <div class="panel-body">
    	
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Publisher</th>
                        <th>Unit price</th>
                        <th>Status</th>
                        
                    </tr>
                </thead>
                <tbody>
                    @foreach($items as $item)
                    <tr>
                        <td>{{$item->title}}</td>
                        <td>{{$item->publisher}}</td>
                        <td>{{$item->unit_quote_price}}</td>
                        <td>{{ $statuses[$item->status] }}</td> 
                       
                    </tr>
                    @endforeach
                    
                </tbody>
            </table>
           
        </div>
     	
        
   
    </div>
</div>
@endif


<?php 
    $items = $requests_this_sem[Requests::SUPPLIES] ;
 ?>
@if(count($items)>0)
<div class="panel panel-primary">
    <div class="panel-heading">
	Supplies
    </div>
    <div class="panel-body">
    	
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Description</th>
                        <th>Remarks</th>
                        <th>Unit price</th>
                        <th>Status</th>
                        
                    </tr>
                </thead>
                <tbody>
                    @foreach($items as $item)
                    <tr>
                        <td>{{$item->description}}</td>
                        <td>{{$item->remarks}}</td>
                        <td>{{$item->unit_quote_price}}</td>
                        <td>{{ $statuses[$item->status] }}</td> 
                       
                    </tr>
                    @endforeach
                    
                </tbody>
            </table>
           
        </div>

        
   
    </div>
</div>
@endif

<?php 
    $items = $requests_this_sem[Requests::EQUIPMENT] ;
 ?>

@if(count($items)>0)
<div class="panel panel-primary">
    <div class="panel-heading">
	Equipment
    </div>    <div class="panel-body">
    	
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Description</th>
                        <th>Remarks</th>
                        <th>Unit price</th>
                        <th>Status</th>
                        
                    </tr>
                </thead>
                <tbody>
                    @foreach($items as $item)
                    <tr>
                        <td>{{$item->description}}</td>
                        <td>{{$item->remarks}}</td>
                        <td>{{$item->unit_quote_price}}</td>
                        <td>{{ $statuses[$item->status] }}</td> 
                       
                    </tr>
                    @endforeach
                    
                </tbody>
            </table>
           
        </div>
     	
        
   
    </div>
</div>
@endif

<?php 
    $items = $requests_this_sem[Requests::OTHER] ;
 ?>
@if(count($items)>0)
<div class="panel panel-primary">
    <div class="panel-heading">
	Others
    </div>
    <div class="panel-body">
    	
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Description</th>
                        <th>Remarks</th>
                        <th>Unit price</th>
                        <th>Status</th>
                        
                    </tr>
                </thead>
                <tbody>
                    @foreach($items as $item)
                    <tr>
                        <td>{{$item->description}}</td>
                        <td>{{$item->remarks}}</td>
                        <td>{{$item->unit_quote_price}}</td>
                        <td>{{ $statuses[$item->status] }}</td> 
                       
                    </tr>
                    @endforeach
                    
                </tbody>
            </table>
           
        </div>
     	
        
   
    </div>
</div>
@endif

