@extends('layouts.app')
@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2 class="panel-title">Daftar Satuan Kerja</h2>
                </div>
                <div class="panel-body">
                    @role('admin')
                        <p> <a class="btn btn-primary" href="{{ route('satker.create') }}">Tambah Satker</a> </p>
                    @endrole
                    {!! $html->table(['class'=>'table-striped table-bordered table-hover', 'width'=>'100%']) !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
{!! $html->scripts() !!}
@endsection