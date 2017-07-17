

<div class="panel panel-default">
    <div class="panel-body">
    <select id='user_selector' class="form-control">
        
        @foreach($all_users as $a)
            <option value={{$a->id}}  @if($def_user->id == $a->id) selected @endif>
                {{$a->username}}
            </option>
        @endforeach
    </select>
    <script>
        $(document).ready(function(){
            $('#user_selector').change(function(){
                newid = $(this).val();
                window.location = "{{url('/switch_user/')}}"+"/"+newid
            });
        });
    </script>
    </div>
</div>