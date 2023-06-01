<div class="modal fade" tabindex="-1" role="dialog" id="modal_edit_role">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Edit Role</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form enctype="multipart/form-data">
          <div class="modal-body">

            <input type="hidden" id="role_id">
            <div class="form-group">
                <label>Role</label>
                <input type="text" class="form-control" name="role" id="edit_role">
                <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-role"></div>
            </div>
            <div class="form-group">
                <label>Deskripsi</label>
                <textarea class="form-control" name="deskripsi" id="edit_deskripsi" rows="3"></textarea>
                <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-deskripsi"></div>
            </div>
        </div>
        <div class="modal-footer bg-whitesmoke br">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Keluar</button>
          <button type="button" class="btn btn-primary" id="update">Edit</button>
        </div>
        </form>
      </div>
    </div>
  </div>
</div>



