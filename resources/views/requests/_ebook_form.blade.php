


 <div class="form-group">
    {!! Form::label('Title *' ) !!}
    {!! Form::text('title', null,['class'=>'form-control' ,'required' ]) !!}
</div>

 <div class="form-group">
    {!! Form::label('Author *' ) !!}
    {!! Form::text('author', null,['class'=>'form-control'  ,'required' ]) !!}
</div>

 <div class="form-group">
    {!! Form::label('Edition' ) !!}
    {!! Form::text('edition', null,['class'=>'form-control' ]) !!}
</div>


 <div class="form-group">
    {!! Form::label('Copyright date *' ) !!}
    {!! Form::text('copyright_date', null,['class'=>'form-control'   ,'required']) !!}
</div>


 <div class="form-group">
    {!! Form::label('Publisher' ) !!}
    {!! Form::text('publisher', null,['class'=>'form-control' ]) !!}
</div>

<div class="form-group">
    {!! Form::label('E-ISBN *' ) !!}
    {!! Form::text('isbn', null,['class'=>'form-control'  ,'required']) !!}
</div>

<div class="form-group">
 
    {!! Form::hidden('iselectronic', 1,['class'=>'form-control' ]) !!}
</div>


<!--  DEFAULT REQUEST FIELDS -->

<div class="form-group">
    {!! Form::label('unit_quote_price', 'Quote price *' ) !!}
    {!! Form::number('unit_quote_price', null,['class'=>'form-control'  ,'required' , 'min'=>0]) !!}
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