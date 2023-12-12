@extends('layouts.app')

@include('data-pengguna.create')
@include('data-pengguna.edit')

@section('content')
    <div class="section-header">
        <h1>Data Pengguna</h1>
        <div class="ml-auto">
            <a href="javascript:void(0)" class="btn btn-primary" id="button_tambah_pengguna"><i class="fa fa-plus"></i> Tambah
                Pengguna</a>
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
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Role</th>
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
                url: "/data-pengguna/get-data",
                type: "GET",
                dataType: 'JSON',
                success: function(response) {
                    let counter = 1;
                    if ($.fn.DataTable.isDataTable('#table_id')) {
                        $('#table_id').DataTable().destroy();
                    }
                    $('#table_id').DataTable().clear();
                    $.each(response.data, function(key, value) {
                        let pengguna = `
                        <tr class="pengguna-row" id="index_${value.id}">
                            <td>${counter++}</td>
                            <td>${value.name}</td>
                            <td>${value.email}</td>
                            <td>${value.role.role}</td>
                            <td>
                                <a href="javascript:void(0)" id="button_edit_pengguna" data-id="${value.id}" class="btn btn-icon btn-warning btn-lg mb-2"><i class="far fa-edit"></i> </a>
                                <a href="javascript:void(0)" id="button_hapus_pengguna" data-id="${value.id}" class="btn btn-icon btn-danger btn-lg mb-2"><i class="fas fa-trash"></i> </a>
                            </td>
                        </tr>
                        `;
                        $('#table_id').DataTable().row.add($(pengguna)).draw(false);
                    });
                }
            });
        });
    </script>

    <!-- Show Modal Tambah barang -->
    <script>
        $('body').on('click', '#button_tambah_pengguna', function() {
            $('#modal_tambah_pengguna').modal('show');
        });

        $('#store').click(function(e) {
            e.preventDefault();

            let name = $('#name').val();
            let email = $('#email').val();
            let password = $('#password').val();
            let role_id = $('#role_id').val();
            let token = $("meta[name='csrf-token']").attr("content");

            let formData = new FormData();
            formData.append('name', name);
            formData.append('email', email);
            formData.append('password', password);
            formData.append('role_id', role_id);
            formData.append('_token', token);

            $.ajax({
                url: '/data-pengguna',
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
                        url: '/data-pengguna/get-data',
                        type: "GET",
                        dataType: 'JSON',
                        cache: false,
                        success: function(response) {
                            $('#table-pengguna').html(
                                ''); // kosongkan tabel terlebih dahulu

                            let counter = 1;
                            $('#table_id').DataTable().clear();
                            $.each(response.data, function(key, value) {
                                getRoleName(value.role_id, function(role) {
                                    let pengguna = `
                            <tr class="pengguna-row" id="index_${value.id}">
                                <td>${counter++}</td>
                                <td>${value.name}</td>
                                <td>${value.email}</td>
                                <td>${role}</td>
                                <td>
                                    <a href="javascript:void(0)" id="button_edit_pengguna" data-id="${value.id}" class="btn btn-icon btn-warning btn-lg mb-2"><i class="far fa-edit"></i> </a>
                                    <a href="javascript:void(0)" id="button_hapus_pengguna" data-id="${value.id}" class="btn btn-icon btn-danger btn-lg mb-2"><i class="fas fa-trash"></i> </a>
                                </td>
                            </tr>
                            `;
                                    $('#table_id').DataTable().row.add($(
                                        pengguna)).draw(false);
                                });
                            });

                            $('#name').val('');
                            $('#email').val('');
                            $('#password').val('');
                            $('#role_id').val('');

                            $('#modal_tambah_pengguna').modal('hide');

                            let table = $('#table_id').DataTable();
                            table.draw(); // memperbarui Datatables

                            function getRoleName(roleId, callback) {
                                $.getJSON('{{ url('api/role') }}', function(roles) {
                                    var role = roles.find(function(s) {
                                        return s.id === roleId;
                                    });
                                    callback(role ? role.role : '');
                                });
                            }
                        },
                        error: function(error) {
                            console.log(error);
                        }
                    });

                },

                error: function(error) {
                    if (error.responseJSON && error.responseJSON.name && error.responseJSON.name[0]) {
                        $('#alert-name').removeClass('d-none');
                        $('#alert-name').addClass('d-block');

                        $('#alert-name').html(error.responseJSON.name[0]);
                    }

                    if (error.responseJSON && error.responseJSON.email && error.responseJSON.email[0]) {
                        $('#alert-email').removeClass('d-none');
                        $('#alert-email').addClass('d-block');

                        $('#alert-email').html(error.responseJSON.email[0]);
                    }

                    if (error.responseJSON && error.responseJSON.password && error.responseJSON
                        .password[0]) {
                        $('#alert-password').removeClass('d-none');
                        $('#alert-password').addClass('d-block');

                        $('#alert-password').html(error.responseJSON.password[0]);
                    }

                    if (error.responseJSON && error.responseJSON.role_id && error.responseJSON.role_id[
                            0]) {
                        $('#alert-role_id').removeClass('d-none');
                        $('#alert-role_id').addClass('d-block');

                        $('#alert-role_id').html(error.responseJSON.role_id[0]);
                    }
                }
            });
        });
    </script>


    <!-- Edit Data Pengguna -->
    <script>
        // Menampilkan Form Modal Edit
        $('body').on('click', '#button_edit_pengguna', function() {
            let pengguna_id = $(this).data('id');

            $.ajax({
                url: `/data-pengguna/${pengguna_id}/edit`,
                type: "GET",
                cache: false,
                success: function(response) {
                    $('#pengguna_id').val(response.data.id);
                    $('#edit_name').val(response.data.name);
                    $('#edit_email').val(response.data.email);
                    $('#edit_password').val(response.data.password);
                    $('#edit_role_id').val(response.data.role_id);

                    $('#modal_edit_pengguna').modal('show');
                }
            });
        });

        // Proses Update Data
        $('#update').click(function(e) {
            e.preventDefault();

            let pengguna_id = $('#pengguna_id').val();
            let name = $('#edit_name').val();
            let email = $('#edit_email').val();
            let password = $('#edit_password').val();
            let role_id = $('#edit_role_id').val();
            let token = $("meta[name='csrf-token']").attr("content");


            // Buat objek FormData
            let formData = new FormData();
            formData.append('name', name);
            formData.append('email', email);
            formData.append('role_id', role_id);
            formData.append('_token', token);
            formData.append('_method', 'PUT');

            // Periksa apakah password diubah atau tidak
            if (password !== '') {
                formData.append('password', password);
            }

            $.ajax({
                url: `/data-pengguna/${pengguna_id}`,
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
                        url: '/data-pengguna/get-data',
                        type: "GET",
                        dataType: 'JSON',
                        cache: false,
                        success: function(response) {
                            $('#table-pengguna').html(
                                ''); // kosongkan tabel terlebih dahulu

                            let counter = 1;
                            $('#table_id').DataTable().clear();
                            $.each(response.data, function(key, value) {
                                getRoleName(value.role_id, function(role) {
                                    let pengguna = `
                                <tr class="pengguna-row" id="index_${value.id}">
                                    <td>${counter++}</td>
                                    <td>${value.name}</td>
                                    <td>${value.email}</td>
                                    <td>${role}</td>
                                    <td>
                                        <a href="javascript:void(0)" id="button_edit_pengguna" data-id="${value.id}" class="btn btn-icon btn-warning btn-lg mb-2"><i class="far fa-edit"></i> </a>
                                        <a href="javascript:void(0)" id="button_hapus_pengguna" data-id="${value.id}" class="btn btn-icon btn-danger btn-lg mb-2"><i class="fas fa-trash"></i> </a>
                                    </td>
                                </tr>
                                `;
                                    $('#table_id').DataTable().row.add($(
                                        pengguna)).draw(false);
                                });
                            });

                            $('#name').val('');
                            $('#email').val('');
                            $('#password').val('');
                            $('#role_id').val('');

                            $('#modal_edit_pengguna').modal('hide');

                            let table = $('#table_id').DataTable();
                            table.draw(); // memperbarui Datatables

                            function getRoleName(roleId, callback) {
                                $.getJSON('{{ url('api/role') }}', function(roles) {
                                    var role = roles.find(function(s) {
                                        return s.id === roleId;
                                    });
                                    callback(role ? role.role : '');
                                });
                            }
                        },
                        error: function(error) {
                            console.log(error);
                        }
                    });
                },

                error: function(error) {
                    if (error.responseJSON && error.responseJSON.name && error.responseJSON.name[0]) {
                        $('#alert-name').removeClass('d-none');
                        $('#alert-name').addClass('d-block');

                        $('#alert-name').html(error.responseJSON.name[0]);
                    }

                    if (error.responseJSON && error.responseJSON.email && error.responseJSON.email[0]) {
                        $('#alert-email').removeClass('d-none');
                        $('#alert-email').addClass('d-block');

                        $('#alert-email').html(error.responseJSON.email[0]);
                    }

                    if (error.responseJSON && error.responseJSON.role_id && error.responseJSON.role_id[
                            0]) {
                        $('#alert-role_id').removeClass('d-none');
                        $('#alert-role_id').addClass('d-block');

                        $('#alert-role_id').html(error.responseJSON.role_id[0]);
                    }
                }
            });
        })
    </script>

    <!-- Hapus Data Barang -->
    <script>
        $('body').on('click', '#button_hapus_pengguna', function() {
            let pengguna_id = $(this).data('id');
            let token = $("meta[name='csrf-token']").attr("content");

            Swal.fire({
                title: 'Apakah Kamu Yakin?',
                text: "ingin menghapus data ini!",
                icon: 'warning',
                showCancelButton: true,
                cancelButtonText: 'TIDAK',
                confirmButtonText: 'YA, HAPUS!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `/data-pengguna/${pengguna_id}`,
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
                            $(`#index_${pengguna_id}`).remove();

                            $.ajax({
                                url: "/data-pengguna/get-data",
                                type: "GET",
                                dataType: 'JSON',
                                success: function(response) {
                                    let counter = 1;
                                    if ($.fn.DataTable.isDataTable('#table_id')) {
                                        $('#table_id').DataTable().destroy();
                                    }
                                    $('#table_id').DataTable().clear();
                                    $.each(response.data, function(key, value) {
                                        getRoleName(value.role_id, function(
                                            role) {
                                            let pengguna = `
                                        <tr class="pengguna-row" id="index_${value.id}">
                                            <td>${counter++}</td>
                                            <td>${value.name}</td>
                                            <td>${value.email}</td>
                                            <td>${role}</td>
                                            <td>
                                                <a href="javascript:void(0)" id="button_edit_pengguna" data-id="${value.id}" class="btn btn-icon btn-warning btn-lg mb-2"><i class="far fa-edit"></i> </a>
                                                <a href="javascript:void(0)" id="button_hapus_pengguna" data-id="${value.id}" class="btn btn-icon btn-danger btn-lg mb-2"><i class="fas fa-trash"></i> </a>
                                            </td>
                                        </tr>
                                        `;
                                            $('#table_id')
                                                .DataTable().row
                                                .add($(pengguna))
                                                .draw(false);
                                        });
                                    });

                                    function getRoleName(roleId, callback) {
                                        $.getJSON('{{ url('api/role') }}', function(
                                            roles) {
                                            var role = roles.find(function(
                                                s) {
                                                return s.id ===
                                                    roleId;
                                            });
                                            callback(role ? role.role : '');
                                        });
                                    }
                                }
                            });
                        }
                    })
                }
            })
        })
    </script>
@endsection
