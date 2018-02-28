@extends('layouts.app')
@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2 class="panel-title">Rekam Kontrak</h2>
                </div>
                <div class="panel-body">
                    {!! Form::open(['url' => route('kontrak.store'), 'method' => 'post', 'class'=>'form-horizontal']) !!}
                        @include('kontrak.admin._form')
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>

@endsection