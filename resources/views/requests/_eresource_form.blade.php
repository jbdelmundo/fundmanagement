
<link rel="stylesheet" type="text/css" href="{{asset('css/bootstrap-datepicker.min.css')}}">


 <div class="form-group">
    {!! Form::label('Title *' ) !!}
    {!! Form::text('title', null,['class'=>'form-control' ]) !!}
</div>

 <div class="form-group">
    {!! Form::label('Publisher *' ) !!}
    {!! Form::text('publisher', null,['class'=>'form-control', 'required' ]) !!}
</div>


 <div class="form-group">
{!! Form::label('Purchase Type *' ) !!}
{!! Form::select('issubscription', ['1' => 'Subscription', '0' => 'Perpetual'], '1',['class'=>'form-control','id'=>'issubscription' ]) !!}
</div>

{!! Form::hidden('iselectronic', 0,['class'=>'form-control' ]) !!}


<div class="form-group">
 
    {!! Form::hidden('issubscription', 1,['class'=>'form-control' ]) !!}
</div>

<div class="form-group">
    <label for="startdate">Start Date</label>
    <div class="input-group date">
            <input type="text" name='startdate' class="form-control datepicker" required >
        <div class="input-group-addon">
            <span class="glyphicon glyphicon-th"></span>
        </div>
    </div>
</div>

<div class="form-group">
    <label for="enddate">End Date</label>
    <div class="input-group date">
            <input type="text" name='enddate' class="form-control datepicker" required >
        <div class="input-group-addon">
            <span class="glyphicon glyphicon-th"></span>
        </div>
    </div>
</div>






<!--  DEFAULT REQUEST FIELDS -->

<div class="form-group">
    {!! Form::label('unit_quote_price', 'Quote price *' ) !!}
    {!! Form::number('unit_quote_price', null,['class'=>'form-control', 'required', 'min'=>0 ]) !!}
</div>


<div class="form-group">
    {!! Form::label( 'Remarks') !!}
    {!! Form::text('remarks', null,['class'=>'form-control' ]) !!}
</div>

<div class="form-group">
    {!! Form::label( 'Recommended by') !!}
    {!! Form::text('recommendedby', null,['class'=>'form-control' ]) !!}
</div>

<!--  END OF DEFAULT REQUEST FIELDS -->
<script src={{asset('js/bootstrap-datepicker.min.js')}}> </script>
<script type="text/javascript">
$(document).ready(function(){

    $('.datepicker').datepicker({'autoclose':true,'format':'yyyy-mm-dd'})
    $('#issubscription').change(function(){
        if($(this).val){
            //subscription
            $(".datepicker").prop('disabled', true);
            $(".datepicker").prop('required', true);
        }else{
            //perpetual
            $(".datepicker").prop('disabled', false);
            $(".datepicker").prop('required', false);
        }
        

    });
});
</script>