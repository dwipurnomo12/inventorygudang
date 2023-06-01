@extends('layouts.app')

@section('content')
<div class="section-header">
  <h1>Dashboard</h1>
</div>

<div class="row">
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
      <div class="card card-statistic-1">
        <div class="card-icon bg-primary">
          <i class="fas fa-thin fa-cubes"></i>
        </div>
        <div class="card-wrap">
          <div class="card-header">
            <h4>Semua Barang</h4>
          </div>
          <div class="card-body">
            {{ $barang }}
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
      <div class="card card-statistic-1">
        <div class="card-icon bg-danger">
          <i class="fas fa-file-import"></i>
        </div>
        <div class="card-wrap">
          <div class="card-header">
            <h4>Barang Masuk</h4>
          </div>
          <div class="card-body">
            {{ $barangMasuk }}
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
      <div class="card card-statistic-1">
        <div class="card-icon bg-warning">
          <i class="fas fa-file-export"></i>
        </div>
        <div class="card-wrap">
          <div class="card-header">
            <h4>Barang Keluar</h4>
          </div>
          <div class="card-body">
            {{ $barangKeluar }}
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
      <div class="card card-statistic-1">
        <div class="card-icon bg-success">
          <i class="far fa-user"></i>
        </div>
        <div class="card-wrap">
          <div class="card-header">
            <h4>Pengguna</h4>
          </div>
          <div class="card-body">
            {{ $user }}
          </div>
        </div>
      </div>
    </div>
</div>

<div class="row">
  <div class="col-lg-6 col-md-6 col-sm-6 col-6">
    <div class="card">
      <div class="card-header">
        <h4>Grafik Barang Masuk & Barang Keluar</h4>
      </div>
      <div class="card-body">
        <canvas id="summaryChart"></canvas>
      </div>
    </div>
  </div>

  <div class="col-lg-6 col-md-6 col-sm-6 col-6">
    <div class="card">
      <div class="card-header">
        <h4>Stok Mencapai Batas Minimum</h4>
      </div>
      <div class="card-body">
        <table class="table">
          <thead>
            <tr>
              <th scope="col">No</th>
              <th scope="col">Kode Barang</th>
              <th scope="col">Nama Barang</th>
              <th scope="col">Stok</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($barangMinimum as $barang)
              <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $barang->kode_barang }}</td>
                <td>{{ $barang->nama_barang }}</td>
                <td><span class="badge badge-warning"> {{ $barang->stok }}</span></td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
  </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
var ctx = document.getElementById('summaryChart').getContext('2d');
    var chart = new Chart(ctx, {
      type: 'bar',
      data: {
        labels: [
          @foreach($barangMasukData as $data)
              '{{ date("F", strtotime($data->date)) }}',
          @endforeach
        ],
        datasets: [
          {
            label : 'Barang Masuk',
            data: [
                @foreach($barangMasukData as $data)
                    '{{ $data->total }}',
                @endforeach
            ],
            backgroundColor: 'blue'
          },
          {
            label : 'Barang Keluar',
            data: [
                @foreach($barangKeluarData as $data)
                    '{{ $data->total }}',
                @endforeach
            ],
            backgroundColor: 'red'
          }
        ]
      },
      options: {
        scales: {
          y: {
            beginAtZero: true,
            precision: 0,
            stepSize: 1,
            ticks: {
              callback: function(value) {
                if (value % 1 === 0) {
                  return value;
                }
              }
            }
          }
        }
      }
    });
</script>
@endpush
