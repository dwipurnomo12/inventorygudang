@extends('layouts.app')

@include('customer.create')
@include('customer.edit')

@section('content')
    <div class="section-header">
        <h1>Data Customer</h1>
        <div class="ml-auto">
            <a href="javascript:void(0)" class="btn btn-primary" id="button_tambah_customer"><i class="fa fa-plus"></i>
                Customer</a>
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
                                    <th>Nama Customer</th>
                                    <th>Alamat</th>
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
                url: "/customer/get-data",
                type: "GET",
                dataType: 'JSON',
                success: function(response) {
                    let counter = 1;
                    $('#table_id').DataTable().clear();
                    $.each(response.data, function(key, value) {
                        let customer = `
                <tr class="barang-row" id="index_${value.id}">
                    <td>${counter++}</td>   
                    <td>${value.customer}</td>
                    <td>${value.alamat}</td>
                    <td>
                        <a href="javascript:void(0)" id="button_edit_customer" data-id="${value.id}" class="btn btn-icon btn-warning btn-lg mb-2"><i class="far fa-edit"></i> </a>
                        <a href="javascript:void(0)" id="button_hapus_customer" data-id="${value.id}" class="btn btn-icon btn-danger btn-lg mb-2"><i class="fas fa-trash"></i> </a>
                    </td>
                </tr>
            `;
                        $('#table_id').DataTable().row.add($(customer)).draw(false);
                    });
                }
            });
        });
    </script>

    <!-- Show Modal Tambah Jenis Barang -->
    <script>
        $('body').on('click', '#button_tambah_customer', function() {
            $('#modal_tambah_customer').modal('show');
        });

        $('#store').click(function(e) {
            e.preventDefault();

            let customer = $('#customer').val();
            let alamat = $('#alamat').val();
            let token = $("meta[name='csrf-token']").attr("content");

            let formData = new FormData();
            formData.append('customer', customer);
            formData.append('alamat', alamat);
            formData.append('_token', token);

            $.ajax({
                url: '/customer',
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
                        url: '/customer/get-data',
                        type: "GET",
                        cache: false,
                        success: function(response) {
                            $('#table-barangs').html('');

                            let counter = 1;
                            $('#table_id').DataTable().clear();
                            $.each(response.data, function(key, value) {
                                let customer = `
                                <tr class="barang-row" id="index_${value.id}">
                                    <td>${counter++}</td>   
                                    <td>${value.customer}</td>
                                    <td>${value.alamat}</td>
                                    <td>
                                        <a href="javascript:void(0)" id="button_edit_customer" data-id="${value.id}" class="btn btn-icon btn-warning btn-lg mb-2"><i class="far fa-edit"></i> </a>
                                        <a href="javascript:void(0)" id="button_hapus_customer" data-id="${value.id}" class="btn btn-icon btn-danger btn-lg mb-2"><i class="fas fa-trash"></i> </a>
                                    </td>
                                </tr>
                             `;
                                $('#table_id').DataTable().row.add($(customer))
                                    .draw(false);
                            });

                            $('#customer').val('');
                            $('#alamat').val('');
                            $('#modal_tambah_customer').modal('hide');

                            let table = $('#table_id').DataTable();
                            table.draw(); // memperbarui Datatables
                        },
                        error: function(error) {
                            console.log(error);
                        }
                    })
                },

                error: function(error) {
                    if (error.responseJSON && error.responseJSON.customer && error.responseJSON
                        .customer[0]) {
                        $('#alert-customer').removeClass('d-none');
                        $('#alert-customer').addClass('d-block');

                        $('#alert-customer').html(error.responseJSON.customer[0]);
                    }

                    if (error.responseJSON && error.responseJSON.alamat && error.responseJSON.alamat[
                        0]) {
                        $('#alert-alamat').removeClass('d-none');
                        $('#alert-alamat').addClass('d-block');

                        $('#alert-alamat').html(error.responseJSON.alamat[0]);
                    }
                }
            });
        });
    </script>

    <!-- Edit Data Jenis Barang -->
    <script>
        //Show modal edit
        $('body').on('click', '#button_edit_customer', function() {
            let customer_id = $(this).data('id');

            $.ajax({
                url: `/customer/${customer_id}/edit`,
                type: "GET",
                cache: false,
                success: function(response) {
                    $('#customer_id').val(response.data.id);
                    $('#edit_customer').val(response.data.customer);
                    $('#edit_alamat').val(response.data.alamat);

                    $('#modal_edit_customer').modal('show');
                }
            });
        });

        // Proses Update Data
        $('#update').click(function(e) {
            e.preventDefault();

            let customer_id = $('#customer_id').val();
            let customer = $('#edit_customer').val();
            let alamat = $('#edit_alamat').val();
            let token = $("meta[name='csrf-token']").attr('content');

            let formData = new FormData();
            formData.append('customer', customer);
            formData.append('alamat', alamat);
            formData.append('_token', token);
            formData.append('_method', 'PUT');

            $.ajax({
                url: `/customer/${customer_id}`,
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
                    rowData.eq(1).text(response.data.customer);
                    rowData.eq(2).text(response.data.alamat);

                    $('#modal_edit_customer').modal('hide');
                },

                error: function(error) {
                    if (error.responseJSON && error.responseJSON.customer && error.responseJSON
                        .customer[0]) {
                        $('#alert-customer').removeClass('d-none');
                        $('#alert-customer').addClass('d-block');

                        $('#alert-customer').html(error.responseJSON.customer[0]);
                    }

                    if (error.responseJSON && error.responseJSON.alamat && error.responseJSON.alamat[
                        0]) {
                        $('#alert-alamat').removeClass('d-none');
                        $('#alert-alamat').addClass('d-block');

                        $('#alert-alamat').html(error.responseJSON.alamat[0]);
                    }
                }
            });
        });
    </script>

    <!-- Hapus Data Barang -->
    <script>
        $('body').on('click', '#button_hapus_customer', function() {
            let customer_id = $(this).data('id');
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
                        url: `/customer/${customer_id}`,
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
                            $(`#index_${customer_id}`).remove();

                            $.ajax({
                                url: "/customer/get-data",
                                type: "GET",
                                dataType: 'JSON',
                                success: function(response) {
                                    let counter = 1;
                                    $('#table_id').DataTable().clear();
                                    $.each(response.data, function(key, value) {
                                        let customer = `
                                        <tr class="barang-row" id="index_${value.id}">
                                            <td>${counter++}</td>   
                                            <td>${value.customer}</td>
                                            <td>${value.alamat}</td>
                                            <td>
                                                <a href="javascript:void(0)" id="button_edit_customer" data-id="${value.id}" class="btn btn-icon btn-warning btn-lg mb-2"><i class="far fa-edit"></i> </a>
                                                <a href="javascript:void(0)" id="button_hapus_customer" data-id="${value.id}" class="btn btn-icon btn-danger btn-lg mb-2"><i class="fas fa-trash"></i> </a>
                                            </td>
                                        </tr>
                                    `;
                                        $('#table_id').DataTable().row.add(
                                            $(customer)).draw(false);
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
