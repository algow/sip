<a class="btn-sm btn-primary" href="{{ $edit_url }}" title="ubah" style="margin-right:2px">
    <i class="fa fa-pencil fa-lg" aria-hidden="true"></i>
</a>
@empty($tanggal)
<a class="btn-sm btn-success" href="{{ $kontak }}" title="hubungi satker" target="_blank">
    <i class="fa fa-whatsapp fa-lg" aria-hidden="true"></i>
</a>
@endempty