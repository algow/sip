@extends('layouts.app')
@section('content')
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
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    @isset($jenis)
                        <h2 class="panel-title" style="font-weight:bold">{{ strtoupper($jenis) }}</h2>
                    @endisset
                </div>
                <div class="panel-body">
                    <div class="col-md-6" style="float:right; padding-right:1px">
                        @role('admin')
                            @isset($jenis)
                                <a class="btn btn-info" style="float:right" href="{{ route($jenis . '.create') }}">Rekam {{ $jenis }}</a>
                                {{ Form::open(['url' => route('spm.export'), 'method' => 'get', 'style'=>'float:right']) }}
                                    {{ Form::hidden('jenis', $jenis) }}
                                    {{ Form::hidden('satker', $satker) }}
                                    {{ Form::hidden('tanggal', $tanggal) }}
                                    {{ Form::submit('Excel Export', ['class'=>'btn btn-success']) }}
                                {!! Form::close() !!}
                            @endisset
                        @endrole
                    </div>
                    <div class="col-md-6" style="float:left; padding-left:1px">
                        <h5><strong>Tanggal Diterima FO</strong> :
                            @isset($tanggal)
                                {{ $tanggal_terima }}
                            @endisset
                        </h5>
                        <h5><strong>Diinput Pada</strong> :
                            @isset($input)
                                {{ $diinput }}
                            @endisset
                        </h5>
                    </div>
                    {!! $html->table(['class'=>'table-striped table-bordered table-hover', 'width'=>'100%']) !!}
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('scripts')
    {!! $html->scripts() !!}
@stop
