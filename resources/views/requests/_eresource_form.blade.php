


 <div class="form-group">
    {!! Form::label('Title' ) !!}
    {!! Form::text('title', null,['class'=>'form-control' ]) !!}
</div>


 {!! Form::hidden('issubscription',1,['class'=>'form-control']) !!}
 

{!! Form::hidden('iselectronic', 0,['class'=>'form-control' ]) !!}


 <div class="form-group">
    {!! Form::label('Publisher' ) !!}
    {!! Form::text('publisher', null,['class'=>'form-control' ]) !!}
</div>

<div class="form-group">
 
    {!! Form::hidden('issubscription', 1,['class'=>'form-control' ]) !!}
</div>


<!--  DEFAULT REQUEST FIELDS -->

<div class="form-group">
    {!! Form::label('unit_quote_price', 'Quote price' ) !!}
    {!! Form::number('unit_quote_price', null,['class'=>'form-control' ]) !!}
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
