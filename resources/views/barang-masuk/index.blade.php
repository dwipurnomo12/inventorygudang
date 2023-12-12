@extends('layouts.app')

@include('barang-masuk.create')

@section('content')
    <div class="section-header">
        <h1>Barang Masuk</h1>
        <div class="ml-auto">
            <a href="javascript:void(0)" class="btn btn-primary" id="button_tambah_barangMasuk"><i class="fa fa-plus"></i>
                Barang Masuk</a>
        </div>
    </div>


    <div class="row">
        <div class="col-lg-12">
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
                                    <th>Stok Masuk</th>
                                    <th>Supplier</th>
                                    <th>Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Select2 Autocomplete -->
    <script>
        $(document).ready(function() {
            setTimeout(function() {
                $('.js-example-basic-single').select2();

                $('#nama_barang').on('change', function() {
                    var selectedOption = $(this).find('option:selected');
                    var nama_barang = selectedOption.text();

                    $.ajax({
                        url: '/api/barang-masuk',
                        type: 'GET',
                        data: {
                            nama_barang: nama_barang,
                        },
                        success: function(response) {
                            if (response && (response.stok || response.stok === 0) &&
                                response.satuan_id) {
                                $('#stok').val(response.stok);
                                getSatuanName(response.satuan_id, function(satuan) {
                                    $('#satuan_id').val(satuan);
                                });
                            } else if (response && response.stok === 0) {
                                $('#stok').val(0);
                                $('#satuan_id').val('');
                            }
                        },
                    });

                    function getSatuanName(satuanId, callback) {
                        $.getJSON('{{ url('api/satuan') }}', function(satuans) {
                            var satuan = satuans.find(function(s) {
                                return s.id === satuanId;
                            });
                            callback(satuan ? satuan.satuan : '');
                        });
                    }
                });
            }, 500);
        });
    </script>

    <!-- Datatable -->
    <script>
        $(document).ready(function() {
            $('#table_id').DataTable({
                paging: true
            });

            $.ajax({
                url: "/barang-masuk/get-data",
                type: "GET",
                dataType: 'JSON',
                success: function(response) {
                    let counter = 1;
                    $('#table_id').DataTable().clear();
                    $.each(response.data, function(key, value) {
                        let supplier = getSupplierName(response.supplier, value.supplier_id);
                        let barangMasuk = `
                <tr class="barang-row" id="index_${value.id}">
                    <td>${counter++}</td>   
                    <td>${value.kode_transaksi}</td>
                    <td>${value.tanggal_masuk}</td>
                    <td>${value.nama_barang}</td>
                    <td>${value.jumlah_masuk}</td>
                    <td>${supplier}</td>
                    <td>
                        <a href="javascript:void(0)" id="button_hapus_barangMasuk" data-id="${value.id}" class="btn btn-icon btn-danger btn-lg mb-2"><i class="fas fa-trash"></i> </a>
                    </td>
                </tr>
            `;
                        $('#table_id').DataTable().row.add($(barangMasuk)).draw(false);
                    });

                    function getSupplierName(suppliers, supplierId) {
                        let supplier = suppliers.find(s => s.id === supplierId);
                        return supplier ? supplier.supplier : '';
                    }
                }
            });
        });
    </script>

    <!-- Generate Kode Transaksi Otomatis -->
    <script>
        function generateKodeTransaksi() {
            var tanggal = new Date().toLocaleDateString('id-ID').split('/').reverse().join('-');
            var randomNumber = Math.floor(Math.random() * 10000).toString().padStart(4, '0');
            var kodeTransaksi = 'TRX-IN-' + tanggal + '-' + randomNumber;

            $('#kode_transaksi').val(kodeTransaksi);
            return kodeTransaksi;
        }

        $(document).ready(function() {
            generateKodeTransaksi();
        });
    </script>

    <!-- Show Modal Tambah Jenis Barang -->
    <script>
        $('body').on('click', '#button_tambah_barangMasuk', function() {
            $('#modal_tambah_barangMasuk').modal('show');
            $('#kode_transaksi').val(generateKodeTransaksi());
        });

        $('#store').click(function(e) {
            e.preventDefault();

            let kode_transaksi = $('#kode_transaksi').val();
            let tanggal_masuk = $('#tanggal_masuk').val();
            let nama_barang = $('#nama_barang').val();
            let jumlah_masuk = $('#jumlah_masuk').val();
            let supplier_id = $('#supplier_id').val();
            let token = $("meta[name='csrf-token']").attr("content");

            let formData = new FormData();
            formData.append('kode_transaksi', kode_transaksi);
            formData.append('tanggal_masuk', tanggal_masuk);
            formData.append('nama_barang', nama_barang);
            formData.append('jumlah_masuk', jumlah_masuk);
            formData.append('supplier_id', supplier_id);
            formData.append('_token', token);

            $.ajax({
                url: '/barang-masuk',
                type: "POST",
                cache: false,
                data: formData,
                contentType: false,
                processData: false,

                success: function(response) {
                    Swal.fire({
                        type: 'success',
                        icon: 'success',
                        title: `${response.message}`,
                        showConfirmButton: true,
                        timer: 3000
                    });

                    $.ajax({
                        url: '/barang-masuk/get-data',
                        type: "GET",
                        cache: false,
                        success: function(response) {
                            $('#table-barangs').html('');

                            let counter = 1;
                            $('#table_id').DataTable().clear();
                            $.each(response.data, function(key, value) {
                                let supplier = getSupplierName(response.supplier,
                                    value.supplier_id);
                                let barangMasuk = `
                                <tr class="barang-row" id="index_${value.id}">
                                    <td>${counter++}</td>   
                                    <td>${value.kode_transaksi}</td>
                                    <td>${value.tanggal_masuk}</td>
                                    <td>${value.nama_barang}</td>
                                    <td>${value.jumlah_masuk}</td>
                                    <td>${supplier}</td>
                                    <td>
                                        <a href="javascript:void(0)" id="button_hapus_barangMasuk" data-id="${value.id}" class="btn btn-icon btn-danger btn-lg mb-2"><i class="fas fa-trash"></i> </a>
                                    </td>
                                </tr>
                             `;
                                $('#table_id').DataTable().row.add($(barangMasuk))
                                    .draw(false);
                            });

                            $('#kode_transaksi').val('');
                            $('#nama_barang').val('');
                            $('#jumlah_masuk').val('');
                            $('#stok').val('');

                            $('#modal_tambah_barangMasuk').modal('hide');

                            let table = $('#table_id').DataTable();
                            table.draw(); // memperbarui Datatables

                            function getSupplierName(suppliers, supplierId) {
                                let supplier = suppliers.find(s => s.id === supplierId);
                                return supplier ? supplier.supplier : '';
                            }
                        },
                        error: function(error) {
                            console.log(error);
                        }
                    })
                },

                error: function(error) {
                    if (error.responseJSON && error.responseJSON.kode_transaksi && error.responseJSON
                        .kode_transaksi[0]) {
                        $('#alert-kode_transaksi').removeClass('d-none');
                        $('#alert-kode_transaksi').addClass('d-block');

                        $('#alert-kode_transaksi').html(error.responseJSON.kode_transaksi[0]);
                    }

                    if (error.responseJSON && error.responseJSON.tanggal_masuk && error.responseJSON
                        .tanggal_masuk[0]) {
                        $('#alert-tanggal_masuk').removeClass('d-none');
                        $('#alert-tanggal_masuk').addClass('d-block');

                        $('#alert-tanggal_masuk').html(error.responseJSON.tanggal_masuk[0]);
                    }

                    if (error.responseJSON && error.responseJSON.nama_barang && error.responseJSON
                        .nama_barang[0]) {
                        $('#alert-nama_barang').removeClass('d-none');
                        $('#alert-nama_barang').addClass('d-block');

                        $('#alert-nama_barang').html(error.responseJSON.nama_barang[0]);
                    }

                    if (error.responseJSON && error.responseJSON.jumlah_masuk && error.responseJSON
                        .jumlah_masuk[0]) {
                        $('#alert-jumlah_masuk').removeClass('d-none');
                        $('#alert-jumlah_masuk').addClass('d-block');

                        $('#alert-jumlah_masuk').html(error.responseJSON.jumlah_masuk[0]);
                    }

                    if (error.responseJSON && error.responseJSON.supplier_id && error.responseJSON
                        .supplier_id[0]) {
                        $('#alert-supplier_id').removeClass('d-none');
                        $('#alert-supplier_id').addClass('d-block');

                        $('#alert-supplier_id').html(error.responseJSON.supplier_id[0]);
                    }
                }
            });
        });
    </script>


    <!-- Hapus Data Barang -->
    <script>
        $('body').on('click', '#button_hapus_barangMasuk', function() {
            let barangMasuk_id = $(this).data('id');
            let token = $("meta[name='csrf-token']").attr("content");

            Swal.fire({
                title: 'Apakah Kamu Yakin?',
                text: "ingin menghapus data ini !",
                icon: 'warning',
                showCancelButton: true,
                cancelButtonText: 'TIDAK',
                confirmButtonText: 'YA, HAPUS!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `/barang-masuk/${barangMasuk_id}`,
                        type: "DELETE",
                        cache: false,
                        data: {
                            "_token": token
                        },
                        success: function(response) {
                            Swal.fire({
                                type: 'success',
                                icon: 'success',
                                title: `${response.message}`,
                                showConfirmButton: true,
                                timer: 3000
                            });
                            $(`#index_${barangMasuk_id}`).remove();

                            $.ajax({
                                url: "/barang-masuk/get-data",
                                type: "GET",
                                dataType: 'JSON',
                                success: function(response) {
                                    let counter = 1;
                                    $('#table_id').DataTable().clear();
                                    $.each(response.data, function(key, value) {
                                        let supplier = getSupplierName(
                                            response.supplier, value
                                            .supplier_id);
                                        let barangMasuk = `
                                        <tr class="barang-row" id="index_${value.id}">
                                            <td>${counter++}</td>   
                                            <td>${value.kode_transaksi}</td>
                                            <td>${value.tanggal_masuk}</td>
                                            <td>${value.nama_barang}</td>
                                            <td>${value.jumlah_masuk}</td>
                                            <td>${supplier}</td>
                                            <td>
                                                <a href="javascript:void(0)" id="button_hapus_barangMasuk" data-id="${value.id}" class="btn btn-icon btn-danger btn-lg mb-2"><i class="fas fa-trash"></i> </a>
                                            </td>
                                        </tr>
                                    `;
                                        $('#table_id').DataTable().row.add(
                                            $(barangMasuk)).draw(false);
                                    });

                                    function getSupplierName(suppliers,
                                    supplierId) {
                                        let supplier = suppliers.find(s => s.id ===
                                            supplierId);
                                        return supplier ? supplier.supplier : '';
                                    }
                                }
                            });
                        }
                    });
                }
            });
        });
    </script>

    <script>
        // Mendapatkan tanggal hari ini
        var today = new Date();

        // Mendapatkan nilai tahun, bulan, dan tanggal
        var year = today.getFullYear();
        var month = (today.getMonth() + 1).toString().padStart(2, '0'); // Ditambahkan +1 karena indeks bulan dimulai dari 0
        var day = today.getDate().toString().padStart(2, '0');

        // Menggabungkan nilai tahun, bulan, dan tanggal menjadi format "YYYY-MM-DD"
        var formattedDate = year + '-' + month + '-' + day;

        // Mengisi nilai input field dengan tanggal hari ini
        document.getElementById('tanggal_masuk').value = formattedDate;
    </script>
@endsection
