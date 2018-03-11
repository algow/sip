@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2 class="panel-title">Kontrak</h2>
                </div>
                <div class="panel-body">
                    @role('admin')
                        <p> <a class="btn btn-primary" href="{{ url('/admin/supplier/create') }}">Rekam Kontrak</a></p>
                    @endrole
                    
                    <table class="table-striped table-bordered table-hover" id="kontrak" width="100%">
                        <thead>
                            <tr>
                                <th>Kode Satker</th>
                                <th>Nama Supplier</th>
                                <th>Tgl Terima FO</th>
                                <th>No Kontrak</th>
                                <th>Nilai Kontrak</th>
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
    $('#kontrak').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{!! route("get.kontrak") !!}',
        columns: [
            {data: 'kode_satker', name: 'kode_satker'},
            {data: 'nama_supplier', name: 'nama_supplier'},
            {data: 'tanggal_terima', name: 'tanggal_terima'},
            {data: 'kode', name: 'kode'},
            {data: 'nilai_kontrak', name: 'nilai_kontrak', render: $.fn.dataTable.render.number('.', null, null, 'Rp ')},
            {data: 'keterangan', name: 'keterangan'},
            {data: 'diambil_pada', name: 'diambil_pada'},
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ]
    });
});
</script>
@endsection