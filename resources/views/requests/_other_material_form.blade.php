


 <div class="form-group">
    {!! Form::label('Description' ) !!}
    {!! Form::text('description', null,['class'=>'form-control' ]) !!}
</div>



<!--  DEFAULT REQUEST FIELDS -->

<div class="form-group">
    {!! Form::label('unit_quote_price', 'Quote price' ) !!}
    {!! Form::number('unit_quote_price', null,['class'=>'form-control' ]) !!}
</div>

<div class="form-group">
    {!! Form::label('quantity', 'Quantity' ) !!}
    {!! Form::number('quantity', null,['class'=>'form-control' ]) !!}
</div>


<div class="form-group">
    {!! Form::label( 'Remarks') !!}
    {!! Form::text('remarks', null,['class'=>'form-control' ]) !!}
</div>



<!--  END OF DEFAULT REQUEST FIELDS -->