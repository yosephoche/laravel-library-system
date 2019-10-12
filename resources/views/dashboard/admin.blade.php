@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="panel panel-default">
          <div class="panel-heading">
            <h2 class="panel-title">Dashboard</h2>
          </div>

          <div class="panel-body">
              Selamat datang di Menu Administrasi. Silahkan pilih menu administrasi yang diinginkan.
              <hr>
              <h4>Statistik Peminjaman Tahun 2019</h4>
              <canvas id="chartPenulis" width="400" height="150"></canvas>
              <br><br>
              <h4>Statistik Jumlah Pengunjung</h4>
              <canvas id="chartPengunjung" width="400" height="150"></canvas>

              <br><br>
              <h4>Statistik Jumlah Pengunjung</h4>
              <canvas id="chartBuku" width="400" height="150"></canvas>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('scripts')
    <script src="{{url('/js/Chart.min.js')}}"></script>
    <script>
    var data = {
        labels: {!! json_encode($members) !!},
        datasets: [{
            label: 'Jumlah Peminjaman',
            data: {!! json_encode($borrows) !!},
            backgroundColor: "rgba(151,187,205,0.5)",
            borderColor: "rgba(151,187,205,0.8)",
        }]
    };

    var options = {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true,
                    stepSize: 1
                }
            }]
        }
    };

    var ctx = document.getElementById("chartPenulis").getContext("2d");

    var authorChart = new Chart(ctx, {
        type: 'bar',
        data: data,
        options: options
    });

    var pengunjung = {
      labels: {!! json_encode($members) !!},
      datasets: [{
          label: 'Jumlah Pengunjung',
          data: {!! json_encode($pengunjung) !!},
          backgroundColor: "rgba(151,187,205,0.5)",
          borderColor: "rgba(151,187,205,0.8)",
      }]
    };

    var chartPengunjung = document.getElementById("chartPengunjung").getContext("2d");
    var chart = new Chart(chartPengunjung, {
      type: 'bar',
      data: pengunjung,
      options: options
    });

    var buku = {
      labels: {!! json_encode($category) !!},
      datasets: [{
          label: 'Jumlah Buku',
          data: {!! json_encode($buku) !!},
          backgroundColor: "rgba(151,187,205,0.5)",
          borderColor: "rgba(151,187,205,0.8)",
      }]
    };

    var chartBuku = document.getElementById("chartBuku").getContext("2d");
    var chart = new Chart(chartBuku, {
      type: 'bar',
      data: buku,
      options: options
    });
    </script>
@endsection
