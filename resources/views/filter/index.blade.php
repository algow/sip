@extends('layouts.app')
@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <ul class="breadcrumb">
                <li><a href="{{ url('/home') }}">Dashboard</a></li>
                <li class="active"><a href="{{ url('/admin/filter') }}">Filter</a></li>
            </ul>
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                      <div class="x_title">
                        <h2>Filter Dokumen <small>pilih sesuai tanggal validasi atau kode satker</small></h2>
                        <div class="clearfix"></div>
		      </div>
                      <div class="x_content">
                        {!! Form::open(['url' => route('get.filter'),'method' => 'get', 'class'=>'form-horizontal form-label-left', 'id'=>'demo-form2']) !!}
                           @include('filter._form')
                        {!! Form::close() !!}
                      </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection