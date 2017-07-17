
@extends('app')

@section('content')

<?php

?>

<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">E-Resource Usage Statistics</h1>
	</div>
	<!-- /.col-lg-12 -->
</div>

<div class="row">
@include('_active_dept_selector')
@include('layouts.errors')


    <div class="col-lg-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                E-Resources  
            </div>
            <div class="panel-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Month</th>
                        <th>Usage</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($usagestatistics as $u)
                        <?php
                            $eresource = DB::table('eresources')->where('id', $u->eresource_id)->first();
                            echo $new;
                        ?>
                        <tr>
                            {!! Form::open() !!}
                            {!! Form::hidden('eresource_id', $u->eresource_id) !!}
                            <td>{{$eresource->title}}</td>
                            <td>{{$u->month}}</td>
                            <td>{{$u->usage}}</td>
                            <td><button type="submit" class="btn btn-primary">View Statistics</button></td>
                            {!! Form::close() !!}
                        </tr>
                    @endforeach
                </tbody>
            </table>
            </div>
        </div>
    </div>
</div>

<div id='try'></div>

@endsection
