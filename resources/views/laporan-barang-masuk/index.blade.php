@extends('layouts.app')

@section('content')

<div class="section-header">
    <h1>Laporan Barang Masuk</h1>
    <div class="ml-auto">
        <a href="javascript:void(0)" class="btn btn-danger" id="print-barang-masuk"><i class="fa fa-sharp fa-light fa-print"></i> Print PDF</a>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="form-group">
                    <form id="filter_form" action="/laporan-barang-masuk/get-data" method="GET">
                        <div class="row">
                            <div class="col-md-5">
                                <label>Pilih Tanggal Mulai :</label>
                                <input type="date" class="form-control" name="tanggal_mulai" id="tanggal_mulai">
                            </div>
                            <div class="col-md-5">
                                <label>Pilih Tanggal Selesai :</label>
                                <input type="date" class="form-control" name="tanggal_selesai" id="tanggal_selesai">
                            </div>
                            <div class="col-md-2 d-flex align-items-end">
                                <button type="submit" class="btn btn-primary">Filter</button>
                                <button type="button" class="btn btn-danger" id="refresh_btn">Refresh</button>
                            </div>
                        </div>
                    </form>
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
                                <th>Kode Transaksi</th>
                                <th>Tanggal Masuk</th>
                                <th>Nama Barang</th>
                                <th>Jumlah Masuk</th>
                                <th>Supplier</th>
                            </tr>
                        </thead>
                        <tbody id="tabel-laporan-barang-masuk">
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



<!-- Script Get Data -->
<script>
    $(document).ready(function() {
        loadData(); // Panggil fungsi loadData saat halaman dimuat

        $('#filter_form').submit(function(event) {
            event.preventDefault();
            loadData(); // Panggil fungsi loadData saat tombol filter ditekan
        });

        $('#refresh_btn').on('click', function() {
            refreshTable();
        });

        //Fungsi load data berdasarkan range tanggal_mulai dan tanggal_selesai
        function loadData() {
            var tanggalMulai = $('#tanggal_mulai').val();
            var tanggalSelesai = $('#tanggal_selesai').val();
            
            $.ajax({
                url: '/laporan-barang-masuk/get-data',
                type: 'GET',
                dataType: 'json',
                data: {
                    tanggal_mulai: tanggalMulai,
                    tanggal_selesai: tanggalSelesai
                },
                success: function(response) {
                    $('#tabel-laporan-barang-masuk').empty();

                    if (response.length > 0) {
                        $.each(response, function(index, item) {
                            getSupplierName(item.supplier_id, function(supplier){
                                var row = '<tr>' +
                                    '<td>' + (index + 1) + '</td>' +
                                    '<td>' + item.kode_transaksi + '</td>' +
                                    '<td>' + item.tanggal_masuk + '</td>' +
                                    '<td>' + item.nama_barang + '</td>' +
                                    '<td>' + item.jumlah_masuk + '</td>' +
                                    '<td>' + supplier + '</td>' +
                                    '</tr>';
                                $('#tabel-laporan-barang-masuk').append(row);
                            });
                        });
                    } else {
                        var emptyRow = '<tr><td colspan="6">Tidak ada data yang tersedia.</td></tr>';
                        $('#tabel-laporan-barang-masuk').append(emptyRow);
                    }

                    $('#table_id').DataTable(); // Inisialisasi DataTable setelah menambahkan data ke tabel
                
                },
                error: function(xhr, status, error) {
                    console.log(error);
                }
            });
            function getSupplierName(supplierId, callback){
                $.getJSON('{{ url('api/supplier') }}', function(suppliers){
                    var supplier = suppliers.find(function(s){
                        return s.id === supplierId;
                    });
                    callback(supplier ? supplier.supplier : '');
                });
            }
        }

        //Fungsi Refresh Tabel
        function refreshTable(){
            $('#filter_form')[0].reset();
            loadData();
        }

        //Print barang masuk
        $('#print-barang-masuk').on('click', function(){
            var tanggalMulai    = $('#tanggal_mulai').val();
            var tanggalSelesai  = $('#tanggal_selesai').val();
            
            var url = '/laporan-barang-masuk/print-barang-masuk';

            if(tanggalMulai && tanggalSelesai){
                url += '?tanggal_mulai=' + tanggalMulai + '&tanggal_selesai=' + tanggalSelesai;
            }

            window.location.href = url;
        });

    });
</script>



@endsection