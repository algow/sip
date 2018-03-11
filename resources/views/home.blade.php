@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    {!! $chart->html() !!}
                    <!--
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    -->
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
{!! $chart->script() !!}
@endsection