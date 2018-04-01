<script>
$(document).ready(function(){
    $(".form-hide-{{ $id }}").hide();
    $(".btn-{{ $id }}").click(function(){
        $(".form-hide-{{ $id }}").fadeIn("slow");
        $(".btn-{{ $id }}").hide("slow");
    });
});
</script>

@if($prefix == 'admin')
    <a class="btn-sm btn-primary" href="{{ $edit_url }}" title="ubah" style="margin-right:2px">
        <i class="fa fa-pencil fa-lg" aria-hidden="true"></i>
    </a>
    @empty($tanggal)
        <a class="btn-sm btn-success" href="{{ $kontak }}" title="hubungi satker" target="_blank">
            <i class="fa fa-whatsapp fa-lg" aria-hidden="true"></i>
        </a>
    @endempty
@endif

@if($prefix == 'fo')
    @isset($pengambil)
        {{ $pengambil }}
    @endisset
    @empty($tanggal)
        <button type="button" class="btn-md btn-success btn-{{ $id }}"><i class="fa fa-play fa-md"></i></button>
        <form action = "{{ route('spm.diambil') }}" method = "POST" class = "form-hide-{{ $id }}">
           {{ Form::hidden('id', $id) }}
           {{ Form::text('pengambil', null, ['class'=>'form-control input-sm']) }}
           {{ Form::submit('Go', ['class'=>'btn btn-info btn-xs']) }}
        </form>
    @endempty
@endif