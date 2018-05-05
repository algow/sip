@extends('layouts.app')
@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2 class="panel-title">Ubah Penolakan {{ $spm[0] }}</h2>
                </div>
                <div class="panel-body">
                    {!! Form::model($find, ['url' => route($spm[0] . '.update', $find->id), 'method' => 'put', 'class'=>'form-horizontal']) !!}
                        @include('spm._form')
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>

@stop