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

@if (in_array('Edit', $spm))
<div class="form-group">
  <div class="col-md-2">
    {!! Form::text('created_at', null, ['class'=>'form-control', 'readonly' => 'true']) !!}
  </div>
</div>
@endif

<div class="form-group">
  <div class="col-md-6">
    {!! Form::label('kode_satker', 'Kode Satker', ['class'=>'control-label']) !!}
    {!! Form::select('kode_satker', [''=>'']+App\Satker::pluck('kode','kode')->all(), null, ['class'=>'form-control js-example-basic-single', 'id'=>'kode-satker']) !!}
  </div>
</div>

<div class="form-group">
  <div class="col-md-6">
    {{ Form::label('kode', $spm[1], ['class'=>'control-label']) }}
    {!! Form::text('kode', null, ['class'=>'form-control', 'id'=>'kode']) !!}
  </div>
</div>

@isset($spm[3])
<div class="form-group">
  <div class="col-md-3">
    {!! Form::label('tanggal_spm', 'Tanggal SPM', ['class'=>'control-label']) !!}
    {!! Form::date('tanggal_spm', null, ['class'=>'form-control']) !!}
  </div>
</div>
@endisset

<div class="form-group">
  <div class="col-md-3">
    {!! Form::label('tanggal_terima', 'Tanggal Diterima FO', ['class'=>'control-label']) !!}
    {!! Form::date('tanggal_terima', null, ['class'=>'form-control']) !!}
  </div>
</div>

@if($spm[0] === "spm")
<div class="form-group" style="margin:0px 0 2px 10px">
    <div class="form-check">
    {!! Form::checkbox('set_default', null, null, ['class' => 'form-check-input', 'id'=>'set-default', 'onChange'=>'setDefault()']) !!}
    {!! Form::label('keterangan', 'Tetapkan Nama Satker sebagai Nama Supplier', ['class' => 'form-check-label']) !!}
    </div>
</div>
@endif

<div class="form-group">
  <div class="col-md-6">
    {!! Form::label('nama_supplier', 'Nama Supplier', ['class'=>'control-label']) !!}
    {!! Form::text('nama_supplier', null, ['class'=>'form-control', 'id'=>'get-supplier']) !!}
  </div>
</div>

<div class="form-group">
  <div class="col-md-6">
    {{ Form::label('nilai_spm', $spm[2], ['class'=>'control-label']) }}
    {!! Form::text('nilai_spm', null, ['class'=>'form-control']) !!}
  </div>
</div>

<div class="form-group" style="margin:0px 0 2px 10px">
    <div class="form-check">
    {!! Form::checkbox('set_default', null, null, ['class' => 'form-check-input', 'id'=>'set-default2']) !!}
    {!! Form::label('keterangan', 'Tetapkan default Keterangan', ['class' => 'form-check-label']) !!}
    </div>
</div>

<div class="form-group" id="hidden-keterangan">
  <div class="col-md-6">
    {!! Form::label('keterangan', 'Keterangan', ['class'=>'control-label']) !!}
    {!! Form::text('keterangan', null, ['class'=>'form-control', 'id'=>'get-keterangan']) !!}
  </div>
</div>

{{ Form::hidden('jenis', $spm[0], ['id'=>'jenis']) }}
<div class="form-group" style="margin:0px 0 2px 10px">
    <div class="form-check">
        <input class="form-check-input" name="cegah_sms" type="checkbox" value="ya">
        <label for="cegah_sms" class="form-check-label bg-warning">Cegah Pengiriman SMS</label>
    </div>
</div>
<div class="form-group">
    <div class="col-md-6">
        <input class="btn btn-primary" value="Simpan" type="submit">
    </div>
</div>

<!-- Saya ndak paham javascript
 Sori kalau kodingannya ngaco -->

@section('scripts')
<script>
    function setDefault()
    {
        var satker = $('#kode-satker').val();

        $.ajax({
            dataType:"json",
            type:"GET",
            url:"{{ route('nama') }}",
            data: { "kode" : satker },
            success: function(data) {
                $("#get-supplier").val(data[0].nama_satker);
            }
        });
    }

    $(document).ready(function(){
        $('#set-default2').on('change', function(){
            if(this.checked)
                $("#get-keterangan").attr({
                    "value" : "Sesuai dengan keterangan sistem"
                });
            else
                $('#get-keterangan').attr({
                    "value" : ""
                });
        });

        $('.btn').on('click', function () {
            var kode = $("#kode").val();
            var jenis = $("#jenis").val();

            if(jenis === "kontrak" && kode.length < 6)
            {
                return confirm('Apakah anda yakin sedang menginput PENOLAKAN KONTRAK?');
            }
            else if(jenis === "spm" && kode.length > 5)
            {
                return confirm('Apakah anda yakin sedang menginput PENOLAKAN SPM?');
            }
            else
            {
                return true;
            }
        });
    });
</script>
@endsection
