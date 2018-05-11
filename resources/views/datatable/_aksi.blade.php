@if($prefix == 'admin')
    {!! Form::model($model, ['url' => $delete, 'method' => 'delete', 'class' => 'form-inline konfirmasi'])!!}
    <a class="btn-sm btn-primary" href="{{ $edit_url }}" title="ubah">
        <i class="fa fa-pencil fa-lg" aria-hidden="true"></i>
    </a>
    @empty($tanggal)
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
        <form action = "{{ route('spm.diambil') }}" method = "POST" class = "form-hide-{{ $id }}" onSubmit="return setPetugas(event);">
           {{ csrf_field() }}
           {{ Form::hidden('id', $id) }}
           {{ Form::text('pengambil', null, ['class'=>'form-control input-sm']) }}
           <button id="btn-{{ $id }}" class="btn-md btn-primary">Go</button>
        </form>
    @endempty
@endif

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

    function setPetugas(e)
    {
        var _token = $("input[name='_token']").val();
        var id = $("input[name='id']").val();
        var pengambil = $("input[name='pengambil']").val();

        $.ajax({
            dataType:"json",
            type:"POST",
            url: "{{ route('spm.diambil') }}",
            data: {"_token" : _token, "id" : id, "pengambil" : pengambil},
            success: function(data) {
              $(".form-hide-{{ $id }}").empty();
              $(".form-hide-{{ $id }}").val(data[1]);
            }
        });
        e.preventDefault();
        return false;
    }
</script>
