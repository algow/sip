<div class="form-group">
    <div class="col-md-6">
        @if (count($errors) > 0)
            <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        {{ $error }}
                    @endforeach
            </div>
        @endif
    </div>
</div>
<div class="form-group">
  <div class="col-md-6">
    {!! Form::label('jenis', 'Jenis Dokumen:', ['class'=>'control-label']) !!}
    {!! Form::select('jenis', array('' => '-- Semua --', 'kontrak' => 'Kontrak', 'pmrt' => 'PMRT', 'supplier' => 'Supplier'), null, ['class'=>'form-control']) !!}
  </div>
</div>

<div class="form-group">
  <div class="col-md-6">
      {!! Form::label('satker', 'Kode Satker:', ['class'=>'control-label']) !!}
      </br>
      {!! Form::select('satker', [''=>'']+App\Satker::pluck('kode','kode')->all(), null, ['class'=>'form-control js-example-basic-single']) !!}
  </div>
</div>

<div class="form-group">
  <div class="col-md-6">
    {!! Form::label('tanggal', 'Tanggal Diterima FO:', ['class'=>'control-label']) !!}
    {!! Form::date('tanggal', null, ['class'=>'form-control']) !!}
  </div>
</div>

<div class="form-group">
    <div class="col-md-6">
        <input class="btn btn-primary" value="Telusuri" type="submit">
    </div>
</div>