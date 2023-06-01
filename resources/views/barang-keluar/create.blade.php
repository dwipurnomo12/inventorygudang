<div class="modal fade" role="dialog" id="modal_tambah_barangKeluar">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Tambah Barang Keluar</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form enctype="multipart/form-data">
          <div class="modal-body">

            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Tanggal Keluar</label>
                  <input type="text" class="form-control" name="tanggal_keluar" id="tanggal_keluar">
                  <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-tanggal_keluar"></div>
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
                  <label>Customer</label>
                  <select class="form-control" name="customer_id" id="customer_id">
                    @foreach ($customers as $customer)
                        @if (old('customer_id') == $customer->id)
                          <option value="{{ $customer->id }}" selected>{{ $customer->customer}}</option>
                        @else
                          <option value="{{ $customer->id }}">{{ $customer->customer}}</option>
                        @endif
                    @endforeach
                  </select>
                  <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-customer_id"></div>
                </div>
  
                <div class="form-group">
                  <label>Jumlah Keluar</label>
                  <div class="input-group">
                    <input type="number" class="form-control" name="jumlah_keluar" id="jumlah_keluar" min="0" style="width: 75%;">
                    <div class="input-group-append" style="width: 25%;">
                      <input type="text" class="form-control" name="satuan" id="satuan_id" disabled>
                    </div>
                    <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-jumlah_keluar"></div>
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





