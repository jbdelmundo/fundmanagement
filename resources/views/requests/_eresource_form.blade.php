


 <div class="form-group">
    {!! Form::label('Title' ) !!}
    {!! Form::text('title', null,['class'=>'form-control' ]) !!}
</div>

{!! Form::hidden('issubscription',1,['class'=>'form-control']) !!}
 <div class="form-group">
    {!! Form::label('Publisher' ) !!}
    {!! Form::text('publisher', null,['class'=>'form-control' ]) !!}
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
    {!! Form::label( 'start_date', 'Start Date') !!}
    {!! Form::date('start_date', null,['class'=>'form-control' ]) !!}
</div>

<div class="form-group">
    {!! Form::label( 'end_date', 'End Date') !!}
    {!! Form::date('end_date', null,['class'=>'form-control' ]) !!}
</div>

<div class="form-group">
    {!! Form::label( 'Recommended by') !!}
    {!! Form::text('recommendedby', null,['class'=>'form-control' ]) !!}
</div>

<!--  END OF DEFAULT REQUEST FIELDS -->