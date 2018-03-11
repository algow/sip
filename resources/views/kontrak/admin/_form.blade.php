<div class="form-group">
  <div class="col-md-6">
    {!! Form::label('kode_satker', 'Kode Satker', ['class'=>'control-label']) !!}
    {!! Form::select('kode_satker', [''=>'']+App\Satker::pluck('kode','kode')->all(), null, ['class'=>'form-control js-example-basic-single']) !!}
  </div>
</div>

<div class="form-group">
  <div class="col-md-6">
    {!! Form::label('kode', 'Nomor Kontrak', ['class'=>'control-label']) !!}
    {!! Form::text('kode', null, ['class'=>'form-control']) !!}
  </div>
</div>

<div class="form-group">
  <div class="col-md-6">
    {!! Form::label('tanggal_terima', 'Tanggal Diterima FO', ['class'=>'control-label']) !!}
    {!! Form::date('tanggal_terima', null, ['class'=>'form-control']) !!}
  </div>
</div>

<div class="form-group">
  <div class="col-md-6">
    {!! Form::label('nama_supplier', 'Nama Supplier', ['class'=>'control-label']) !!}
    {!! Form::text('nama_supplier', null, ['class'=>'form-control']) !!}
  </div>
</div>

<div class="form-group">
  <div class="col-md-6">
    {!! Form::label('nilai_kontrak', 'Nilai Kontrak', ['class'=>'control-label']) !!}
    {!! Form::text('nilai_kontrak', null, ['class'=>'form-control']) !!}
  </div>
</div>

<div class="form-group">
  <div class="col-md-6">
    {!! Form::label('keterangan', 'Keterangan', ['class'=>'control-label']) !!}
    {!! Form::text('keterangan', null, ['class'=>'form-control']) !!}
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
