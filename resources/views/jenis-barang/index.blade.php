@extends('layouts.app')

@include('jenis-barang.create')
@include('jenis-barang.edit')

@section('content')
    <div class="section-header">
        <h1>Data Jenis Barang</h1>
        <div class="ml-auto">
            <a href="javascript:void(0)" class="btn btn-primary" id="button_tambah_jenis_barang"><i class="fa fa-plus"></i>
                Jenis Barang</a>
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
                                    <th>Jenis Barang</th>
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
    <!-- Datatables Jquery -->
    <script>
        $(document).ready(function() {
            $('#table_id').DataTable({
                paging: true
            });
            $.ajax({
                url: "/jenis-barang/get-data",
                type: "GET",
                dataType: 'JSON',
                success: function(response) {
                    let counter = 1;
                    $('#table_id').DataTable().clear();
                    $.each(response.data, function(key, value) {
                        let jenisBarang = `
                <tr class="barang-row" id="index_${value.id}">
                    <td>${counter++}</td>   
                    <td>${value.jenis_barang}</td>
                    <td>
                        <a href="javascript:void(0)" id="button_edit_jenis_barang" data-id="${value.id}" class="btn btn-icon btn-warning btn-lg mb-2"><i class="far fa-edit"></i> </a>
                        <a href="javascript:void(0)" id="button_hapus_jenis_barang" data-id="${value.id}" class="btn btn-icon btn-danger btn-lg mb-2"><i class="fas fa-trash"></i> </a>
                    </td>
                </tr>
            `;
                        $('#table_id').DataTable().row.add($(jenisBarang)).draw(false);
                    });
                }
            });
        });
    </script>

    <!-- Show Modal Tambah Jenis Barang -->
    <script>
        $('body').on('click', '#button_tambah_jenis_barang', function() {
            $('#modal_tambah_jenis_barang').modal('show');
        });

        $('#store').click(function(e) {
            e.preventDefault();

            let jenis_barang = $('#jenis_barang').val();
            let token = $("meta[name='csrf-token']").attr("content");

            let formData = new FormData();
            formData.append('jenis_barang', jenis_barang);
            formData.append('_token', token);

            $.ajax({
                url: '/jenis-barang',
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
                        url: '/jenis-barang/get-data',
                        type: "GET",
                        cache: false,
                        success: function(response) {
                            $('#table-barangs').html('');

                            let counter = 1;
                            $('#table_id').DataTable().clear();
                            $.each(response.data, function(key, value) {
                                let jenisBarang = `
                                <tr class="barang-row" id="index_${value.id}">
                                    <td>${counter++}</td>   
                                    <td>${value.jenis_barang}</td>
                                    <td>
                                        <a href="javascript:void(0)" id="button_edit_jenis_barang" data-id="${value.id}" class="btn btn-icon btn-warning btn-lg mb-2"><i class="far fa-edit"></i> </a>
                                        <a href="javascript:void(0)" id="button_hapus_jenis_barang" data-id="${value.id}" class="btn btn-icon btn-danger btn-lg mb-2"><i class="fas fa-trash"></i> </a>
                                    </td>
                                </tr>
                             `;
                                $('#table_id').DataTable().row.add($(jenisBarang))
                                    .draw(false);
                            });

                            $('#jenis_barang').val('');
                            $('#modal_tambah_jenis_barang').modal('hide');

                            let table = $('#table_id').DataTable();
                            table.draw(); // memperbarui Datatables
                        },
                        error: function(error) {
                            console.log(error);
                        }
                    })
                },

                error: function(error) {
                    if (error.responseJSON && error.responseJSON.jenis_barang && error.responseJSON
                        .jenis_barang[0]) {
                        $('#alert-jenis_barang').removeClass('d-none');
                        $('#alert-jenis_barang').addClass('d-block');

                        $('#alert-jenis_barang').html(error.responseJSON.jenis_barang[0]);
                    }
                }
            });
        });
    </script>

    <!-- Edit Data Jenis Barang -->
    <script>
        //Show modal edit
        $('body').on('click', '#button_edit_jenis_barang', function() {
            let jenis_id = $(this).data('id');

            $.ajax({
                url: `/jenis-barang/${jenis_id}/edit`,
                type: "GET",
                cache: false,
                success: function(response) {
                    $('#jenis_id').val(response.data.id);
                    $('#edit_jenis_barang').val(response.data.jenis_barang);

                    $('#modal_edit_jenis_barang').modal('show');
                }
            });
        });

        // Proses Update Data
        $('#update').click(function(e) {
            e.preventDefault();

            let jenis_id = $('#jenis_id').val();
            let jenis_barang = $('#edit_jenis_barang').val();
            let token = $("meta[name='csrf-token']").attr('content');

            let formData = new FormData();
            formData.append('jenis_barang', jenis_barang);
            formData.append('_token', token);
            formData.append('_method', 'PUT');

            $.ajax({
                url: `/jenis-barang/${jenis_id}`,
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

                    let row = $(`#index_${response.data.id}`);
                    let rowData = row.find('td');
                    rowData.eq(1).text(response.data.jenis_barang);

                    $('#modal_edit_jenis_barang').modal('hide');
                },

                error: function(error) {
                    if (error.responseJSON && error.responseJSON.jenis_barang && error.responseJSON
                        .jenis_barang[0]) {
                        $('#alert-jenis_barang').removeClass('d-none');
                        $('#alert-jenis_barang').addClass('d-block');

                        $('#alert-jenis_barang').html(error.responseJSON.jenis_barang[0]);
                    }
                }
            });
        });
    </script>

    <!-- Hapus Data Barang -->
    <script>
        $('body').on('click', '#button_hapus_jenis_barang', function() {
            let jenis_id = $(this).data('id');
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
                        url: `/jenis-barang/${jenis_id}`,
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
                            $('#table_id').DataTable().clear().draw();

                            $.ajax({
                                url: "/jenis-barang/get-data",
                                type: "GET",
                                dataType: 'JSON',
                                success: function(response) {
                                    let counter = 1;
                                    $('#table_id').DataTable().clear();
                                    $.each(response.data, function(key, value) {
                                        let jenisBarang = `
                                        <tr class="barang-row" id="index_${value.id}">
                                            <td>${counter++}</td>   
                                            <td>${value.jenis_barang}</td>
                                            <td>
                                                <a href="javascript:void(0)" id="button_edit_jenis_barang" data-id="${value.id}" class="btn btn-icon btn-warning btn-lg mb-2"><i class="far fa-edit"></i> </a>
                                                <a href="javascript:void(0)" id="button_hapus_jenis_barang" data-id="${value.id}" class="btn btn-icon btn-danger btn-lg mb-2"><i class="fas fa-trash"></i> </a>
                                            </td>
                                        </tr>
                                    `;
                                        $('#table_id').DataTable().row.add(
                                            $(jenisBarang)).draw(false);
                                    });
                                }
                            });
                        }
                    })
                }
            });
        });
    </script>
@endsection
