

<div class="panel panel-default">
    <div class="panel-body">
    <select id='user_selector' class="form-control">
        
        @foreach($usagestatistics as $u)
            <option value={{$u->id}}>
                {{$u->id}}
            </option>
        @endforeach
    </select>
   
    </div>
</div>