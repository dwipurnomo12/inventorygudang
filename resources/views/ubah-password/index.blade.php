@extends('layouts.app')

@section('content')

<div class="section-header">
    <h1>Ubah Password</h1>
</div>

<div class="card">
    <div class="card-body">
        <form action="/ubah-password" method="POST" id="ubahPassword">
        @method('put')
        @csrf

        <div class="mb-3">
            <label for="current_password" class="form-label @error('current_password') is-invalid @enderror">Masukkan Password Lama</label>
            <input type="password" class="form-control" id="current_password" name="current_password" required>
            <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-current_password"></div>
        </div>

        <div class="mb-3">
            <label for="passwordNew" class="form-label @error('passwordNew') is-invalid @enderror">Masukkan password Baru</label>
            <input type="password" class="form-control" id="passwordNew" name="passwordNew" required>
            <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-passwordNew"></div>
        </div>

        <div class="mb-3">
            <label for="konfirmasiPassword" class="form-label @error('konfirmasiPassword') is-invalid @enderror">konfirmasi password</label>
            <input type="password" class="form-control" id="konfirmasiPassword" name="konfirmasiPassword" required>
            <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-konfirmasiPassword"></div>
        </div>

        <button type="submit" class="btn btn-primary mb-5 float-end">Reset Password</button>

        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
$(document).ready(function(){
    $('#ubahPassword').submit(function(e){
        e.preventDefault();

        let current_password    = $('#current_password').val();            
        let passwordNew         = $('#passwordNew').val();            
        let konfirmasiPassword  = $('#konfirmasiPassword').val();
        let token               = $("meta[name='csrf-token']").attr("content");

        let formData = new FormData();
        formData.append('current_password', current_password);
        formData.append('passwordNew', passwordNew);
        formData.append('konfirmasiPassword', konfirmasiPassword);
        formData.append('_token', token);

        $.ajax({
            url: '/ubah-password',
            type: "POST",
            cache: false,
            data: formData,
            contentType: false,
            processData: false,

            success:function(response){
                $('#current_password').val('');
                $('#passwordNew').val('');
                $('#konfirmasiPassword').val('');

                Swal.fire({
                    type: 'success',
                    icon: 'success',
                    title: `${response.message}`,
                    showConfirmButton: true,
                    timer: 3000
                });
            },
            error:function(error){
                if (error.responseJSON && error.responseJSON.current_password) {
                    $('#alert-current_password').removeClass('d-none');
                    $('#alert-current_password').addClass('d-block');

                    $('#alert-current_password').text(error.responseJSON.current_password);
                }

                if (error.responseJSON && error.responseJSON.passwordNew) {
                    $('#alert-passwordNew').removeClass('d-none');
                    $('#alert-passwordNew').addClass('d-block');

                    $('#alert-passwordNew').text(error.responseJSON.passwordNew);
                }

                if (error.responseJSON && error.responseJSON.konfirmasiPassword) {
                    $('#alert-konfirmasiPassword').removeClass('d-none');
                    $('#alert-konfirmasiPassword').addClass('d-block');

                    $('#alert-konfirmasiPassword').text(error.responseJSON.konfirmasiPassword);
                }
            }
        });
    });
});
</script>

@endpush