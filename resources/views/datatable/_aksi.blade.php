<script>
$(document).ready(function(){
    $(".form-hide-{{ $id }}").hide();
    $(".btn-{{ $id }}").click(function(){
        $(".form-hide-{{ $id }}").fadeIn("slow");
        $(".btn-{{ $id }}").hide("slow");
    });
    $(document.body).on('submit', '.konfirmasi', function () {
        var $el = $(this);
        var text = $el.data('confirm') ? $el.data('confirm') : 'Yakin akan menghapus record ini?';
        var c = confirm(text);
        return c;
    });
});
</script>

@if($prefix == 'admin')
    {!! Form::model($model, ['url' => $delete, 'method' => 'delete', 'class' => 'form-inline konfirmasi'])!!}
    <a class="btn-sm btn-primary" href="{{ $edit_url }}" title="ubah">
        <i class="fa fa-pencil fa-lg" aria-hidden="true"></i>
    </a>
    @empty($prefix)
        <a class="btn-sm btn-success" href="{{ $kontak }}" title="hubungi satker" target="_blank" style="margin-right:2px">
            <i class="fa fa-whatsapp fa-lg" aria-hidden="true"></i>
        </a>
    @endempty
    <button title="hapus" type='submit' class='btn-xs btn-danger' value='submit'><i class="fa fa-trash fa-md"></i></button>
    {!! Form::close()!!}
@endif

@if($prefix == 'fo')
    @isset($pengambil)
        {{ $pengambil }}
    @endisset
    @empty($tanggal)
        <button type="button" class="btn-md btn-success btn-{{ $id }}"><i class="fa fa-play fa-md"></i></button>
        <form action = "{{ route('spm.diambil') }}" method = "POST" class = "form-hide-{{ $id }}">
            {{ csrf_field() }}
           {{ Form::hidden('id', $id) }}
           {{ Form::text('pengambil', null, ['class'=>'form-control input-sm']) }}
           {{ Form::submit('Go', ['class'=>'btn btn-info btn-xs']) }}
        </form>
    @endempty
@endif