@extends('layouts.app')

@section('content')

<div class="section-header">
    <h1>Laporan Stok</h1>
    <div class="ml-auto">
        <a href="javascript:void(0)" class="btn btn-danger" id="print-stok"><i class="fa fa-sharp fa-light fa-print"></i> Print PDF</a>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="form-group">
                    <label for="opsi-laporan-stok">Filter Stok Berdasarkan :</label>
                    <select class="form-control" name="opsi-laporan-stok" id="opsi-laporan-stok">
                        <option value="semua" selected>Semua</option>
                        <option value="minimum">Batas Minimum</option>
                        <option value="stok-habis">Stok Habis</option>
                    </select>
                </div>
                
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="table_id" class="display">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kode Barang</th>
                                <th>Nama Barang</th>
                                <th>Stok</th>
                            </tr>
                        </thead>
                        <tbody id="tabel-laporan-stok">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Datatables Jquery -->
<script>
    $(document).ready(function(){
        $('#table_id').DataTable({
            paging: true
        });
    })
</script>

<!-- Dropdown -->
<script>
    $(document).ready(function() {
        loadData('semua');

        $('#opsi-laporan-stok').on('change', function(){
            var selectedOption = $(this).val();
            loadData(selectedOption);
        });

        function loadData(selectedOption) {
            $.ajax({
                url: '/laporan-stok/get-data',
                type: 'GET',
                data: { opsi: selectedOption },
                success: function(response){
                    $('#tabel-laporan-stok').empty();
                    let counter = 1;
                    $.each(response, function(index, item) {
                        getSatuanName(item.satuan_id, function(satuan) {
                            var row = '<tr><td>' + counter++ +
                                '</td><td>' + item.kode_barang +
                                '</td><td>' + item.nama_barang +
                                '</td><td>' + item.stok + ' ' + satuan + '</td></tr>';
                            $('#tabel-laporan-stok').append(row);
                        });
                    });
                }
            });
            function getSatuanName(satuanId, callback){
                $.getJSON('{{ url('api/satuan') }}', function(satuans){
                    var satuan = satuans.find(function(s){
                        return s.id === satuanId;
                    });
                    callback(satuan ? satuan.satuan : '');
                });
            }
        }

        $('#print-stok').on('click', function(){
            var selectedOption = $('#opsi-laporan-stok').val();
            window.location.href = '/laporan-stok/print-stok?opsi=' + selectedOption;
        });
    });
</script>

@endsection