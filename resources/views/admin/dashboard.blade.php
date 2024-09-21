  @extends('admin.layout.layouts')
  @section('title', 'Admin | Home')
  @section('content')
      <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/chartjs-plugin-datalabels/2.0.0/chartjs-plugin-datalabels.min.js">
      </script>

      <style>
          .card {
              width: 100%;
              border: 1px solid #ccc;
              border-radius: 8px;
              box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
              overflow: hidden;
              background-color: #fff;
          }

          /* Image at the top of the card */
          .card img {
              width: 100%;
              height: 300px;
              object-fit: cover;
          }

          /* Content inside the card */
          .card-body {
              padding: 15px;
          }

          .card-title {
              font-size: 1.5rem;
              font-weight: bold;
              margin-bottom: 10px;
          }

          .card-text {
              font-size: 1rem;
              color: #666;
              margin-bottom: 20px;
          }

          .card-footer {
              display: flex;
              justify-content: space-between;
              align-items: center;
              padding: 10px;
              background-color: #f1f1f1;
          }
      </style>
      <div class="content-wrapper pb-0">
          <div class="page-header flex-wrap">
              <div class="header-right d-flex flex-wrap mt-2 mt-sm-0">
                  <div class="d-flex align-items-center">
                      <a href="#" style="color: rgb(161, 0, 0)">
                          <p class="m-0 pe-3">Dashboard</p>
                      </a>
                      <a class="ps-3 me-4" href="#" style="color: rgb(161, 0, 0)">
                          <p class="m-0" id="time">
                          </p>
                      </a>
                  </div>

              </div>
          </div>
          <!-- table row starts here -->
          <div class="row">
              <div class="col-xl-3 grid-margin">
                  <div class="card card-stat stretch-card mb-3">
                      <div class="card-body">
                          <div class="d-flex justify-content-between">
                              <div class="text-white">
                                  <h3 class="fw-bold mb-0">{{ $kec }}</h3>
                                  <h6>Jumlah Kecamatan</h6>
                                  {{-- <div class="badge badge-danger">{{ round($kecPercentage, 2) }}%</div> --}}
                              </div>
                              <div class="flot-bar-wrapper">
                                  <div id="column-chart" class="flot-chart"></div>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
              <div class="col-xl-3 grid-margin">
                  <div class="card card-stat stretch-card mb-3">
                      <div class="card-body">
                          <div class="d-flex justify-content-between">
                              <div class="text-white">
                                  <h3 class="fw-bold mb-0">{{ $kelurahan }}</h3>
                                  <h6>Jumlah Kelurahan</h6>
                                  {{-- <div class="badge badge-danger">{{ round($kelurahanPercentage, 2) }}%</div> --}}
                              </div>
                              <div class="flot-bar-wrapper">
                                  <div id="column-chart" class="flot-chart"></div>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
              <div class="col-xl-3 grid-margin">
                  <div class="card card-stat stretch-card mb-3">
                      <div class="card-body">
                          <div class="d-flex justify-content-between">
                              <div class="text-white">
                                  <h3 class="fw-bold mb-0">{{ $tps }}</h3>
                                  <h6>Jumlah TPS</h6>
                                  {{-- <div class="badge badge-danger">{{ round($tpsPercentage, 2) }}%</div> --}}
                              </div>
                              <div class="flot-bar-wrapper">
                                  <div id="column-chart" class="flot-chart"></div>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
              <div class="col-xl-3 grid-margin">
                  <div class="card card-stat stretch-card mb-3">
                      <div class="card-body">
                          <div class="d-flex justify-content-between">
                              <div class="text-white">
                                  <h3 class="fw-bold mb-0">{{ $calon }}</h3>
                                  <h6>Jumlah Calon</h6>
                                  {{-- <div class="badge badge-danger">{{ round($tpsPercentage, 2) }}%</div> --}}
                              </div>
                              <div class="flot-bar-wrapper">
                                  <div id="column-chart" class="flot-chart"></div>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
          <div class="row">
              <div class="col-md-4">
                  <canvas id="tpsChart"></canvas>
              </div>
              <div class="col-md-8">
                  <canvas id="suaraChart"></canvas>
              </div>
          </div>

          <!-- Chart container -->
      </div>

      <script>
          const calonNames = @json($calonNames);
          const suaraCalon = @json($suaraCalon);

          // Menghitung total suara untuk persentase
          const totalSuara = suaraCalon.reduce((a, b) => a + b, 0);
          const percentages = suaraCalon.map(suara => totalSuara > 0 ? (suara / totalSuara * 100).toFixed(2) : 0);

          // Mengatur warna untuk setiap calon
          const backgroundColors = ['rgba(255, 99, 132, 0.6)', 'rgba(54, 162, 235, 0.6)', 'rgba(255, 206, 86, 0.6)'];
          const borderColors = ['rgba(255, 99, 132, 1)', 'rgba(54, 162, 235, 1)', 'rgba(255, 206, 86, 1)'];

          var ctx = document.getElementById('suaraChart').getContext('2d');
          var suaraChart = new Chart(ctx, {
              type: 'bar',
              data: {
                  labels: calonNames,
                  datasets: [{
                      label: 'Jumlah Suara',
                      data: suaraCalon,
                      backgroundColor: backgroundColors,
                      borderColor: borderColors,
                      borderWidth: 1
                  }]
              },
              options: {
                  responsive: true,
                  scales: {
                      y: {
                          beginAtZero: true,
                          title: {
                              display: true,
                              text: 'Jumlah Suara'
                          }
                      },
                      x: {
                          title: {
                              display: true,
                              text: 'Nama Calon'
                          }
                      }
                  },
                  plugins: {
                      tooltip: {
                          callbacks: {
                              label: function(context) {
                                  const suara = context.raw;
                                  const calonIndex = context.dataIndex;
                                  const persentase = percentages[calonIndex];
                                  return `Jumlah Suara: ${suara} (${persentase}%)`;
                              }
                          }
                      },
                      legend: {
                          display: true
                      },
                      datalabels: {
                          anchor: 'end',
                          align: 'end',
                          formatter: (value, context) => {
                              const persentase = percentages[context.dataIndex];
                              return `${value} (${persentase}%)`;
                          }
                      }
                  }
              },
              plugins: [ChartDataLabels] // Pastikan untuk menambahkan plugin ChartDataLabels
          });
      </script>



      <script>
          var ctx = document.getElementById('tpsChart').getContext('2d');
          var filledTpsCount = {{ $filledTpsCount }};
          var remainingTpsCount = {{ $remainingTpsCount }};
          var totalTps = filledTpsCount + remainingTpsCount;

          var tpsChart = new Chart(ctx, {
              type: 'pie',
              data: {
                  labels: ['TPS Masuk  {{ $filledTpsCount }}', 'TPS Belum Masuk {{ $remainingTpsCount }}',
                      'Total TPS {{ $tps }}'
                  ],
                  datasets: [{
                      label: 'Status TPS',
                      data: [filledTpsCount, remainingTpsCount],
                      backgroundColor: [
                          'rgba(75, 192, 192, 0.6)', // Warna untuk TPS terisi
                          'rgba(255, 99, 132, 0.6)' // Warna untuk TPS belum terisi
                      ],
                      borderColor: [
                          'rgba(75, 192, 192, 1)',
                          'rgba(255, 99, 132, 1)'
                      ],
                      borderWidth: 1
                  }]
              },
              options: {
                  responsive: true,
                  plugins: {
                      legend: {
                          position: 'top',
                      },
                      tooltip: {
                          callbacks: {
                              label: function(tooltipItem) {
                                  var label = tooltipItem.label || '';
                                  if (label) {
                                      label += ': ';
                                  }
                                  label += tooltipItem.raw; // Menampilkan jumlah
                                  label += ' (' + ((tooltipItem.raw / totalTps) * 100).toFixed(2) +
                                      '%)'; // Menampilkan persentase
                                  return label;
                              }
                          }
                      },
                      datalabels: {
                          anchor: 'center',
                          align: 'center',
                          formatter: function(value, context) {
                              return value + ' (' + ((value / totalTps) * 100).toFixed(2) +
                                  '%)'; // Menampilkan jumlah dan persentase
                          },
                          color: 'white' // Warna teks
                      }
                  }
              }
          });
      </script>
      <script>
          // Menampilkan waktu saat ini
          function updateClock() {
              const now = new Date();
              const hours = String(now.getHours()).padStart(2, '0');
              const minutes = String(now.getMinutes()).padStart(2, '0');
              const seconds = String(now.getSeconds()).padStart(2, '0');

              const timeString = hours + ':' + minutes + ':' + seconds;
              document.getElementById('time').textContent = timeString;
          }
          // Update jam setiap detik
          setInterval(updateClock, 1000);
          // Menjalankan fungsi pertama kali
          updateClock();
      </script>

  @endsection
