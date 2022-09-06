{{-- halaman untuk menampilkan statistik data publikasi per author --}}
{{-- memanggil header --}}
@include('layouts.header')
        <title>Publication per Author Statistics | {{ env('APP_NAME') }}</title>    
    </head>
    <body>
      {{-- memanggil navbar --}}
      @include('layouts.navbar')
      <div class="container">
        <div class="mt-3 mb-3">
          <h3>Publication Data Statistics</h3>
        </div>
        <div class="mb-3">
          <canvas id="myChart"</canvas>
        </div>

      </div>

      <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.js"></script>    
      
      <script>
        $(document).ready(function() {
          var Author = new Array();
          var Total = new Array();
          $.ajax({
            url: `{{ url('/publication/get_stats/per_author') }}`,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            method: 'GET',
            success: function(response) {
              response.forEach(function(data){
                Author.push(data.code);
                Total.push(data.total);
              });
            const ctx = document.getElementById('myChart');
            const myChart = new Chart(ctx, {
              type: 'bar',
              data: {
                labels: Author,
                datasets: [{
                  label: 'Total Publications per Author',
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