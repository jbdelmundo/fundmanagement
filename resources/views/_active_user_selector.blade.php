

<div class="panel panel-default">
    <div class="panel-body">

     <?php 
            //get the variables here instead in the controller
            $active_user = session('active_user',Auth::user()->id ) ;
            $all_users = DB::table('users')->get();
        ?>


    <select id='user_selector' class="form-control">
        
        @foreach($all_users as $user)
            <option value={{$user->id}}  @if($active_user == $user->id) selected @endif>
                {{$user->username}}
            </option>
        @endforeach
    </select>
    <script>
        $(document).ready(function(){
            $('#user_selector').change(function(){
                newid = $(this).val();
                window.location = "{{url('/switch_active_user/')}}"+"/"+newid
            });
        });
    </script>
    </div>
</div>