<?php use \App\Requests; ?>
<?php 
    $items = $requests_this_sem[Requests::BOOK] ;
    
 ?>

<div class="panel panel-primary">
    <div class="panel-heading">
	  Books	  
    </div>
    <div class="panel-body">
        @if(count($items)>0)
        <div class="table-responsive">
    	
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Publisher</th>
                        <th>Year</th>
                        <th>Unit price</th>
                        
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
                        <form action="/endorsements"><td> <button type="submit">Endorse </button></td></form>       
                    </tr>
                    @endforeach
                    
                </tbody>
            </table>
            
        </div>
   		@else
        	No items to show.
        @endif
    </div>
</div>


<?php 
    $items = $requests_this_sem[Requests::JOURNAL] ;
 ?>

<div class="panel panel-primary">
    <div class="panel-heading">
	Journals	  
    </div>
    <div class="panel-body">
    	@if(count($items)>0)
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Unit price</th>
                        
                    </tr>
                </thead>
                <tbody>
                    @foreach($items as  $book)
                    <tr>
                        <td>{{$book->title}}</td>
                        <td>{{$book->author}}</td>
                        <td>{{$book->unit_quote_price}}</td>
                        <td><button method="POST">Endorse</button></td>
                    </tr>
                    @endforeach
                    
                </tbody>
            </table>
           
        </div>
     	@else
        	No items to show.
        @endif
   
    </div>
</div>



<?php 
    $items = $requests_this_sem[Requests::EBOOK] ;
 ?>

<div class="panel panel-primary">
    <div class="panel-heading">
    E-Books      
    </div>
    <div class="panel-body">
        @if(count($items)>0)
        <div class="table-responsive">
        
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Publisher</th>
                        <th>Year</th>
                        <th>Unit price</th>
                                 
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
                        <form action="/endorsements"><td> <button type="submit">Endorse </button></td></form>             
                    </tr>
                    @endforeach
                    
                </tbody>
            </table>
            
        </div>
        @else
            No items to show.
        @endif
    </div>
</div>

<?php 
    $items = $requests_this_sem[Requests::MAGAZINE] ;
 ?>

<div class="panel panel-primary">
    <div class="panel-heading">
    Magazines      
    </div>
    <div class="panel-body">
        @if(count($items)>0)
        <div class="table-responsive">
        
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Publisher</th>
                        <th>Unit price</th>
                        
                     
                    </tr>
                </thead>
                <tbody>
                    @foreach($items as  $item)
                    <tr>
                        <td>{{$item->title}}</td>
                        <td>{{$item->author}}</td>
                        <td>{{$item->publisher}}</td>
                        <td>{{$item->unit_quote_price}}</td>                
                    </tr>
                    @endforeach
                    
                </tbody>
            </table>
            
        </div>
        @else
            No items to show.
        @endif
    </div>
</div>

<?php 
    $items = $requests_this_sem[Requests::ERESOURCE] ;
 ?>

<div class="panel panel-primary">
    <div class="panel-heading">
    E-Resources      
    </div>
    <div class="panel-body">
        @if(count($items)>0)
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Publisher</th>
                        <th>Unit price</th>
                        
                    </tr>
                </thead>
                <tbody>
                    @foreach($items as  $book)
                    <tr>

                        <td>{{$book->title}}</td>
                        <td>{{$book->publisher}}</td>
                        <td>{{$book->unit_quote_price}}</td>
                        
                    </tr>
                    @endforeach
                    
                </tbody>
            </table>
           
        </div>
        @else
            No items to show.
        @endif
   
    </div>
</div>

<?php 
    $items = $requests_this_sem[Requests::EQUIPMENT] ;
 ?>

<div class="panel panel-primary">
    <div class="panel-heading">
    Equipment     
    </div>
    <div class="panel-body">
        @if(count($items)>0)
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Description</th>
                        <th>Remarks</th>
                        <th>Unit price</th>
                        
                    </tr>
                </thead>
                <tbody>
                    @foreach($items as  $book)
                    <tr>
                        <td>{{$book->description}}</td>
                        <td>{{$book->remarks}}</td>
                        <td>{{$book->unit_quote_price}}</td>
                       <form action="/endorsements"><td> <button type="submit">Endorse </button></td></form>
                    </tr>
                    @endforeach
                    
                </tbody>
            </table>
           
        </div>
        @else
            No items to show.
        @endif
   
    </div>
</div>

<?php 
    $items = $requests_this_sem[Requests::SUPPLIES] ;
 ?>

<div class="panel panel-primary">
    <div class="panel-heading">
    Supplies      
    </div>
    <div class="panel-body">
        @if(count($items)>0)
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Description</th>
                        <th>Remarks</th>
                        <th>Unit price</th>
                        
                    </tr>
                </thead>
                <tbody>
                    @foreach($items as  $book)
                    <tr>
                        <td>{{$book->description}}</td>
                        <td>{{$book->remarks}}</td>
                        <td>{{$book->unit_quote_price}}</td>
                        
                    </tr>
                    @endforeach
                    
                </tbody>
            </table>
           
        </div>
        @else
            No items to show.
        @endif
   
    </div>
</div>


<?php 
    $items = $requests_this_sem[Requests::OTHER] ;
 ?>

<div class="panel panel-primary">
    <div class="panel-heading">
    Others      
    </div>
    <div class="panel-body">
        @if(count($items)>0)
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Description</th>
                        <th>Remarks</th>
                        <th>Unit price</th>
                       
                    </tr>
                </thead>
                <tbody>
                    @foreach($items as  $book)
                    <tr>
                        <td>{{$book->description}}</td>
                        <td>{{$book->remarks}}</td>
                        <td>{{$book->unit_quote_price}}</td>
                       <form action="/endorsements"><td> <button type="submit">Endorse </button></td></form>
                    </tr>
                    @endforeach
                    
                </tbody>
            </table>
           
        </div>
        @else
            No items to show.
        @endif
   
    </div>
</div>
