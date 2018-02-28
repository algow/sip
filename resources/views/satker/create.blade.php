@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <ul class="breadcrumb">
                <li><a href="{{ url('/home') }}">Dashboard</a></li>
                <li><a href="{{ url('/admin/satker') }}">Satker</a></li>
                <li class="active">Tambah Penulis</li>
            </ul>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2 class="panel-title">Tambah Satker</h2>
                </div>

                <div class="panel-body">
                   <form action="{{ route('satker.store') }}" method="post" class="form-horizontal">
                        {{ csrf_field() }}
                        <div class="form-group">
                          <div class="col-md-6">
                            {!! Form::label('kode', 'Kode Satker', ['class'=>'control-label']) !!}
                            {!! Form::text('kode', null, ['class'=>'form-control']) !!}
                          </div>
                        </div>

                        <div class="form-group">
                          <div class="col-md-6">
                            {!! Form::label('nama_satker', 'Nama Satker', ['class'=>'control-label']) !!}
                            {!! Form::text('nama_satker', null, ['class'=>'form-control']) !!}
                          </div>
                        </div>
                        
                        <div class="form-group">
                          <div class="col-md-6">
                            {!! Form::label('whatsapp', 'Nomor Telepon', ['class'=>'control-label']) !!}
                            {!! Form::text('whatsapp', null, ['class'=>'form-control']) !!}
                          </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6">
                                @if (count($errors) > 0)
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6">
                                <input class="btn btn-primary" value="Simpan" type="submit">
                            </div>
                        </div>
                   </form>   
                </div>
            </div>
        </div>
    </div>
</div>
@endsection