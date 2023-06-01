<div class="modal fade" tabindex="-1" role="dialog" id="modal_tambah_customer">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Tambah customer</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form enctype="multipart/form-data">
          <div class="modal-body">

            <div class="form-group">
                <label>Nama Perusahaan</label>
                <input type="text" class="form-control" name="customer" id="customer">
                <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-customer"></div>
            </div>
            <div class="form-group">
                <label>Alamat</label>
                <textarea class="form-control" name="alamat" id="alamat" rows="3"></textarea>
                <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-alamat"></div>
            </div>

        </div>
        <div class="modal-footer bg-whitesmoke br">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Keluar</button>
          <button type="button" class="btn btn-primary" id="store">Tambah</button>
        </div>
        </form>
      </div>
    </div>
  </div>
</div>



