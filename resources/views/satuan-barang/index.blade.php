@extends('layouts.app')

@include('satuan-barang.create')
@include('satuan-barang.edit')

@section('content')
    <div class="section-header">
        <h1>Satuan Barang</h1>
        <div class="ml-auto">
            <a href="javascript:void(0)" class="btn btn-primary" id="button_tambah_satuan"><i class="fa fa-plus"></i> Satuan
                Barang</a>
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
                                    <th>Satuan Barang</th>
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
                url: "/satuan-barang/get-data",
                type: "GET",
                dataType: 'JSON',
                success: function(response) {
                    let counter = 1;
                    $('#table_id').DataTable().clear();
                    $.each(response.data, function(key, value) {
                        let satuan = `
                <tr class="barang-row" id="index_${value.id}">
                    <td>${counter++}</td>   
                    <td>${value.satuan}</td>
                    <td>
                        <a href="javascript:void(0)" id="button_edit_satuan" data-id="${value.id}" class="btn btn-icon btn-warning btn-lg mb-2"><i class="far fa-edit"></i> </a>
                        <a href="javascript:void(0)" id="button_hapus_satuan" data-id="${value.id}" class="btn btn-icon btn-danger btn-lg mb-2"><i class="fas fa-trash"></i> </a>
                    </td>
                </tr>
            `;
                        $('#table_id').DataTable().row.add($(satuan)).draw(false);
                    });
                }
            });
        });
    </script>

    <!-- Show Modal Tambah Jenis Barang -->
    <script>
        $('body').on('click', '#button_tambah_satuan', function() {
            $('#modal_tambah_satuan').modal('show');
        });

        $('#store').click(function(e) {
            e.preventDefault();

            let satuan = $('#satuan').val();
            let token = $("meta[name='csrf-token']").attr("content");

            let formData = new FormData();
            formData.append('satuan', satuan);
            formData.append('_token', token);

            $.ajax({
                url: '/satuan-barang',
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
                        url: '/satuan-barang/get-data',
                        type: "GET",
                        cache: false,
                        success: function(response) {
                            $('#table-barangs').html('');

                            let counter = 1;
                            $('#table_id').DataTable().clear();
                            $.each(response.data, function(key, value) {
                                let satuan = `
                                <tr class="barang-row" id="index_${value.id}">
                                    <td>${counter++}</td>   
                                    <td>${value.satuan}</td>
                                    <td>
                                        <a href="javascript:void(0)" id="button_edit_satuan" data-id="${value.id}" class="btn btn-icon btn-warning btn-lg mb-2"><i class="far fa-edit"></i> </a>
                                        <a href="javascript:void(0)" id="button_hapus_satuan" data-id="${value.id}" class="btn btn-icon btn-danger btn-lg mb-2"><i class="fas fa-trash"></i> </a>
                                    </td>
                                </tr>
                             `;
                                $('#table_id').DataTable().row.add($(satuan)).draw(
                                    false);
                            });

                            $('#satuan').val('');
                            $('#modal_tambah_satuan').modal('hide');

                            let table = $('#table_id').DataTable();
                            table.draw(); // memperbarui Datatables
                        },
                        error: function(error) {
                            console.log(error);
                        }
                    })
                },

                error: function(error) {
                    if (error.responseJSON && error.responseJSON.satuan && error.responseJSON.satuan[
                        0]) {
                        $('#alert-satuan').removeClass('d-none');
                        $('#alert-satuan').addClass('d-block');

                        $('#alert-satuan').html(error.responseJSON.satuan[0]);
                    }
                }
            });
        });
    </script>

    <!-- Edit Data Jenis Barang -->
    <script>
        //Show modal edit
        $('body').on('click', '#button_edit_satuan', function() {
            let satuan_id = $(this).data('id');

            $.ajax({
                url: `/satuan-barang/${satuan_id}/edit`,
                type: "GET",
                cache: false,
                success: function(response) {
                    $('#satuan_id').val(response.data.id);
                    $('#edit_satuan').val(response.data.satuan);

                    $('#modal_edit_satuan').modal('show');
                }
            });
        });

        // Proses Update Data
        $('#update').click(function(e) {
            e.preventDefault();

            let satuan_id = $('#satuan_id').val();
            let satuan = $('#edit_satuan').val();
            let token = $("meta[name='csrf-token']").attr('content');

            let formData = new FormData();
            formData.append('satuan', satuan);
            formData.append('_token', token);
            formData.append('_method', 'PUT');

            $.ajax({
                url: `/satuan-barang/${satuan_id}`,
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
                    rowData.eq(1).text(response.data.satuan);

                    $('#modal_edit_satuan').modal('hide');
                },

                error: function(error) {
                    if (error.responseJSON && error.responseJSON.satuan && error.responseJSON.satuan[
                        0]) {
                        $('#alert-satuan').removeClass('d-none');
                        $('#alert-satuan').addClass('d-block');

                        $('#alert-satuan').html(error.responseJSON.satuan[0]);
                    }
                }
            });
        });
    </script>

    <!-- Hapus Data Barang -->
    <script>
        $('body').on('click', '#button_hapus_satuan', function() {
            let satuan_id = $(this).data('id');
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
                        url: `/satuan-barang/${satuan_id}`,
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
                            $(`#index_${satuan_id}`).remove();

                            $.ajax({
                                url: "/satuan-barang/get-data",
                                type: "GET",
                                dataType: 'JSON',
                                success: function(response) {
                                    let counter = 1;
                                    $('#table_id').DataTable().clear();
                                    $.each(response.data, function(key, value) {
                                        let satuan = `
                                        <tr class="barang-row" id="index_${value.id}">
                                            <td>${counter++}</td>   
                                            <td>${value.satuan}</td>
                                            <td>
                                                <a href="javascript:void(0)" id="button_edit_satuan" data-id="${value.id}" class="btn btn-icon btn-warning btn-lg mb-2"><i class="far fa-edit"></i> </a>
                                                <a href="javascript:void(0)" id="button_hapus_satuan" data-id="${value.id}" class="btn btn-icon btn-danger btn-lg mb-2"><i class="fas fa-trash"></i> </a>
                                            </td>
                                        </tr>
                                    `;
                                        $('#table_id').DataTable().row.add(
                                            $(satuan)).draw(false);
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
