{{-- halaman untuk menampilkan statistik data abdimas per tahun --}}
{{-- memanggil header --}}
@include('layouts.header')
        <title>Abdimas per Year Statistics | {{ env('APP_NAME') }}</title>    
    </head>
    <body>
      {{-- memanggil navbar --}}
      @include('layouts.navbar')
      <div class="container">
        <div class="mt-3 mb-3">
          <h3>Abdimas Data Statistics</h3>
        </div>
        <div class="mb-3">
          <canvas id="myChart"</canvas>
        </div>

      </div>

      <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.js"></script>    
      
      <script>
        $(document).ready(function() {
          var Years = new Array();
          var Total = new Array();
          $.ajax({
            url: `{{ url('/abdimas/get_stats/per_year') }}`,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            method: 'GET',
            success: function(response) {
              response.forEach(function(data){
                Years.push(data.year);
                Total.push(data.total);
              });
            const ctx = document.getElementById('myChart');
            const myChart = new Chart(ctx, {
              type: 'bar',
              data: {
                labels: Years,
                datasets: [{
                  label: 'Total Abdimas per Year',
                  data: Total,
                  borderWidth: 1,
                  backgroundColor: 'rgba(255, 99, 132, 0.2)',
                }]
              },
              options: {
                scales: {
                  y: {
                      beginAtZero: true
                  }
                },
                responsive: true,
              }
            });
            },
            error: function(data) {
                console.log(data)
            }
          });
        });

        
      </script>

    </body>
</html>