<div class="form-group">
    <div class="col-md-6">
        {!! Form::label('excel', 'Pilih file', ['class'=>'control-label']) !!}
        {!! Form::file('excel') !!}
    </div>
</div>
<div class="form-group">
    <div class="col-md-6">
        {!! Form::submit('Import', ['class'=>'btn btn-primary']) !!}
    </div>
</div>