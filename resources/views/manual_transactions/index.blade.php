@extends('app')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Manual Transactions</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>

<div class="row">
    <div class="col-lg-12">

        @include('layouts._alerts')

        <div class="row" id='choices'>
            <div class="col-md-4 col-md-offset-2">                
                <button type="button" class="btn btn-success lg_btn" onclick="show_add()">Add Funds</button>
            </div>
            <div class="col-md-4">
                <button type="button" class="btn btn-danger lg_btn" onclick="show_deduct()">Deduct Funds</button>
            </div>
        </div>
        
        <div class="panel panel-success" id="panel_add">
            <div class="panel-heading">
                <h3>Add Funds Manually</h3>
            </div>
        {!! Form::open(['url' => 'manual_transactions/add' , 'class' => 'form']) !!}
            <div class="panel-body">
                <div class="row">
                <div class="col-lg-6">
                    <div class="form-group">
                        {!! Form::label('aysem', 'Semester' ) !!}
                        <select name='aysem' class="form-control" id='aysem_add'>

                            <?php 
                                //get the variables here instead in the controller
                                $active_aysem = session('active_aysem',\App\Aysem::current()->aysem ) ;
                                $aysems = \App\Aysem::all();
                            ?>

                            @foreach($aysems as $aysem)
                                <option value={{$aysem->aysem}}   @if($active_aysem == $aysem->aysem) selected @endif >
                                    {{\App\Aysem::shortName($aysem->aysem)}}
                                </option>
                            @endforeach
                        </select>
                    </div>
            </div><!-- col-6 -->
            <div class="col-lg-6">
                    <div class="form-group">
                        {!! Form::label('unit_quote_price', 'Department/Institute' ) !!}
                        <select name='department' class="form-control" id='department_add'>
                            <?php 
                                //get the variables here instead in the controller
                                $active_department_id = session('active_dept_id',1 ) ;
                                $departments = \App\Department::all();
                            ?>
                            @foreach($departments as $d)
                                <option value={{$d->id}}   @if($active_department_id == $d->id) selected @endif >
                                    {{$d->short_name}}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div><!-- col-6 -->  
                </div><!-- row -->


                
                <div class="row">
                    <div class="col-md-6 col-md-offset-6">
                    <div class="form-group">
                        {!! Form::label('unit_quote_price', 'Amount *' ) !!}
                        {!! Form::number('amount', null,['class'=>'form-control','id'=>'amount_add','required', 'min'=>0 ]) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('remarks', 'Remarks *' ) !!}
                        {!! Form::textarea('remarks', null,['class'=>'form-control', 'id'=>'remarks_add','required', 'min'=>0 ]) !!}
                    </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-md-offset-6 btn-group-lg">
                        <button type="button" class="btn btn-success" data-toggle="modal" data-target='#add_modal' id="confirm_add">Add funds</button>
                    </div>
                </div>

                <div class="row">
                    <!-- modal -->
                    <div id="add_modal" class="modal fade" role="dialog">
                      <div class="modal-dialog">

                        <!-- Modal content-->
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Confirm Add Funds</h4>
                          </div>
                          <div class="modal-body" id='modal_body_add'>
                                                      
                          </div>
                          <div class="modal-footer">                        
                            {{ Form::submit('Add funds',  ['class'=>'btn btn-success', 'id'=>'add','value'=>'add'])}}
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                          </div>
                        </div>

                      </div>
                    </div><!-- modal -->
                </div>              
            </div><!-- panel-body -->
        {{Form::close()}}
        </div><!-- panel -->


        <div class="panel panel-danger" id='panel_deduct'>
            <div class="panel-heading">
                <h3>Deduct Funds Manually</h3>
            </div>
        {!! Form::open(['url' => 'manual_transactions/deduct' , 'class' => 'form']) !!}
            <div class="panel-body">
                <div class="row">
                <div class="col-lg-6">
                    <div class="form-group">
                        {!! Form::label('unit_quote_price', 'Semester' ) !!}
                        <select name='aysem' class="form-control" id='aysem_deduct'>

                            <?php 
                                //get the variables here instead in the controller
                                $active_aysem = session('active_aysem',\App\Aysem::current()->aysem ) ;
                                $aysems = \App\Aysem::all();
                            ?>

                            @foreach($aysems as $aysem)
                                <option value={{$aysem->aysem}}   @if($active_aysem == $aysem->aysem) selected @endif >
                                    {{\App\Aysem::shortName($aysem->aysem)}}
                                </option>
                            @endforeach
                        </select>
                    </div>
            </div><!-- col-6 -->
            <div class="col-lg-6">
                    <div class="form-group">
                        {!! Form::label('unit_quote_price', 'Department/Institute' ) !!}
                        <select name='department' class="form-control" id='department_deduct'>
                            <?php 
                                //get the variables here instead in the controller
                                $active_department_id = session('active_dept_id',1 ) ;
                                $departments = \App\Department::all();
                            ?>
                            @foreach($departments as $d)
                                <option value={{$d->id}}   @if($active_department_id == $d->id) selected @endif >
                                    {{$d->short_name}}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div><!-- col-6 -->
             

                </div><!-- row -->


                
                <div class="row">
                    <div class="col-md-6 col-md-offset-6">
                    <div class="form-group">
                        {!! Form::label('unit_quote_price', 'Amount *' ) !!}
                        {!! Form::number('amount', null,['class'=>'form-control','id'=>'amount_deduct'  ,'required', 'min'=>0 ]) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('unit_quote_price', 'Remarks *' ) !!}
                        {!! Form::textarea('remarks', null,['class'=>'form-control','id'=>'remarks_deduct'  ,'required', 'min'=>0 ]) !!}
                    </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-md-offset-6 btn-group-lg">
                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target='#deduct_modal' id='confirm_deduct'>Deduct funds</button>
                    </div>
                </div>

                <div class="row">
                    <!-- modal -->
                    <div id="deduct_modal" class="modal fade" role="dialog">
                      <div class="modal-dialog">

                        <!-- Modal content-->
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Confirm Deduct Funds</h4>
                          </div>
                          <div class="modal-body" id='modal_body_deduct'>
                                                      
                          </div>
                          <div class="modal-footer">                        
                            {{ Form::submit('Deduct funds',  ['class'=>'btn btn-danger', 'id'=>'add','value'=>'add'])}}
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                          </div>
                        </div>

                      </div>
                    </div><!-- modal -->
                </div>              
            </div><!-- panel-body -->
        {{Form::close()}}
        </div><!-- panel -->
        
        </div><!-- main col-lg-12 -->
        
    </div>
</div>


<style type="text/css">
    
@media screen and (min-width: 768px)
.lg_btn {
    padding-top: 48px;
    padding-bottom: 48px;
}

.lg_btn {
    padding: 50px; 
    margin-bottom: 30px;
    font-size: 28px;
}
</style>


<script type="text/javascript">

    aysems = {!! json_encode($aysems->toArray()) !!}
    departments = {!! json_encode($departments->toArray()) !!}

    aysem_id_name = {}
    for(i in aysems){
        aysem_id_name[aysems[i]['aysem']] = aysems[i]['short_name']
    }

    dept_id_name = {}
    for(i in departments){
        dept_id_name[departments[i]['id']] = departments[i]['short_name']
        
    }

    $('#panel_add').hide()
    $('#panel_deduct').hide()


    function show_add(){
        $('#panel_add').show()
        $('#panel_deduct').hide()
        $('#choices').hide()
    }

    function show_deduct(){
        $('#panel_add').hide()
        $('#panel_deduct').show()
        $('#choices').hide()
    }

    $(document).ready(function(){

        $('#confirm_add').click(function(){
            aysem = $('#aysem_add').val()
            department = $('#department_add').val()
            amount = $('#amount_add').val()
            remarks = $('#remarks_add').val()

            html_str = ''
            html_str += '<p><strong>Semester:</strong>'+aysem_id_name[aysem]+'</p>'
            html_str += '<p><strong>Department:</strong>'+dept_id_name[department]+'</p>'
            html_str += '<p><strong>Amount:</strong>'+amount+'</p>'
            html_str += '<p><strong>Remarks:</strong>'+remarks+'</p>'
           
            $('#modal_body_add').html(html_str)
        })

        $('#confirm_deduct').click(function(){
            aysem = $('#aysem_deduct').val()
            department = $('#department_deduct').val()
            amount = $('#amount_deduct').val()
            remarks = $('#remarks_deduct').val()

            html_str = ''
            html_str += '<p><strong>Semester:</strong>'+aysem_id_name[aysem]+'</p>'
            html_str += '<p><strong>Department:</strong>'+dept_id_name[department]+'</p>'
            html_str += '<p><strong>Amount:</strong>'+amount+'</p>'
            html_str += '<p><strong>Remarks:</strong>'+remarks+'</p>'
           
            $('#modal_body_deduct').html(html_str)
        })


    })
</script>>

@endsection