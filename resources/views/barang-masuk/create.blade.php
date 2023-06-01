<div class="modal fade" role="dialog" id="modal_tambah_barangMasuk">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Tambah Barang Masuk</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form enctype="multipart/form-data">
          <div class="modal-body">

            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Tanggal Masuk</label>
                  <input type="text" class="form-control" name="tanggal_masuk" id="tanggal_masuk">
                  <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-tanggal_masuk"></div>
                </div>
    
                <div class="form-group">
                  <label>Kode Transaksi</label>
                  <input type="text" class="form-control" name="kode_transaksi" id="kode_transaksi" readonly>
                  <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-kode_transaksi"></div>
                </div>
    
                <div class="form-group">
                  <label>Stok Saat Ini</label>
                  <input type="number" class="form-control" name="stok" id="stok" disabled>
                  <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-stok"></div>
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                  <label>Pilih Barang</label>
                    <select class="js-example-basic-single" name="nama_barang" id="nama_barang" style="width: 100%">
                      <option selected>Pilih Barang</option>
                      @foreach ($barangs as $barang)
                        <option value="{{ $barang->nama_barang }}">{{ $barang->nama_barang }}</option>
                      @endforeach
                    </select>
                    <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-nama_barang"></div>
                </div>

                <div class="form-group">
                  <label>Supplier</label>
                  <select class="form-control" name="supplier_id" id="supplier_id">
                    @foreach ($suppliers as $supplier)
                        @if (old('supplier_id') == $supplier->id)
                          <option value="{{ $supplier->id }}" selected>{{ $supplier->supplier}}</option>
                        @else
                          <option value="{{ $supplier->id }}">{{ $supplier->supplier}}</option>
                        @endif
                    @endforeach
                  </select>
                  <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-supplier_id"></div>
                </div>
    
                <div class="form-group">
                  <label>Jumlah Masuk</label>
                  <div class="input-group">
                    <input type="number" class="form-control" name="jumlah_masuk" id="jumlah_masuk" min="0" style="width: 75%;">
                    <div class="input-group-append" style="width: 25%;">
                      <input type="text" class="form-control" name="satuan" id="satuan_id" disabled>
                    </div>
                    <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-jumlah_masuk"></div>
                  </div>
                </div>

              </div>
            </div>            
          </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Keluar</button>
          <button type="button" class="btn btn-primary" id="store">Tambah</button>
        </div>
        </form>
      </div>
    </div>
  </div>
</div>





