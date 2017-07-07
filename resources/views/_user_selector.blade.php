

<div class="panel panel-default">
    <div class="panel-body">
    <select id='user_selector' class="form-control">
        @foreach($all_users as $a)
            <option value={{$a->id}}>
                {{$a->username}}
            </option>
        @endforeach
        <?php
        	$newvar = 1;
        ?>
    </select>
    </div>
</div>