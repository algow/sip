@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2 class="panel-title">Supplier</h2>
                </div>
                <div class="panel-body">
                    @role('admin')
                        <p> <a class="btn btn-primary" href="{{ url('/admin/supplier/create') }}">Rekam Kontrak</a></p>
                    @endrole
                        <h5 style="margin-top: 1px; margin-bottom: 15px;"><strong>Tanggal Diterima FO</strong> :
                            @isset($tanggal)
                                {{ $tanggal_terima }}
                            @endisset
                        </h5>
                    <table class="table-striped table-bordered table-hover" id="supplier" width="100%">
                        <thead>
                            <tr>
                                <th>Kode Satker</th>
                                <th>Nama Supplier</th>
                                <th>Nomor SPM</th>
                                <th>Tanggal SPM</th>
                                <th>Nilai SPM</th>
                                <th>Keterangan</th>
                                <th>Diambil Pada</th>
                                <th></th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(function() {
    $('#supplier').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route("supplier.ajax") }}' + '?jenis=' + '{{ $jenis }}' + '&satker=' + '{{ $satker }}' + '&tanggal=' + '{{ $tanggal }}',
        columns: [
            {data: 'kode_satker', name: 'kode_satker'},
            {data: 'nama_supplier', name: 'nama_supplier'},
            {data: 'kode', name: 'kode'},
            {data: 'tanggal_spm', name: 'tanggal_spm'},
            {data: 'nilai_spm', name: 'nilai_spm', render: $.fn.dataTable.render.number('.', null, null, 'Rp ')},
            {data: 'keterangan', name: 'keterangan'},
            {data: 'diambil_pada', name: 'diambil_pada'},
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ]
    });
});
</script>
@endsection