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
    {!! Form::label('kode_satker', 'Kode Satker', ['class'=>'control-label']) !!}
    {!! Form::select('kode_satker', [''=>'']+App\Satker::pluck('kode','kode')->all(), null, ['class'=>'form-control js-example-basic-single']) !!}
  </div>
</div>

<div class="form-group">
  <div class="col-md-6">
    {{ Form::label('kode', $spm[1], ['class'=>'control-label']) }}
    {!! Form::text('kode', null, ['class'=>'form-control']) !!}
  </div>
</div>

@isset($spm[3])
<div class="form-group">
  <div class="col-md-6">
    {!! Form::label('tanggal_spm', 'Tanggal SPM', ['class'=>'control-label']) !!}
    {!! Form::date('tanggal_spm', null, ['class'=>'form-control']) !!}
  </div>
</div>
@endisset

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
    {{ Form::label('nilai_spm', $spm[2], ['class'=>'control-label']) }}
    {!! Form::text('nilai_spm', null, ['class'=>'form-control']) !!}
  </div>
</div>

<div class="form-group">
  <div class="col-md-6">
    {!! Form::label('keterangasn', 'Keterangan', ['class'=>'control-label']) !!}
    {!! Form::text('keterangan', null, ['class'=>'form-control']) !!}
  </div>
</div>

{{ Form::hidden('jenis', $spm[0]) }}

<div class="form-group">
    <div class="col-md-6">
        <input class="btn btn-primary" value="Simpan" type="submit">
    </div>
</div>
