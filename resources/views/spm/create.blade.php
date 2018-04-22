@extends('layouts.app')
@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2 class="panel-title">Rekam Penolakan {{ $spm[0] }}</h2>
                </div>
                <div class="panel-body">
                    {!! Form::open(['url' => route($spm[0] . '.store'), 'method' => 'post', 'class'=>'form-horizontal']) !!}
                        @include('spm._form')
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>

@endsection