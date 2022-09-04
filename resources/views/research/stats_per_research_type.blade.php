@include('layouts.header')
        <title>Research per Type Statistics | {{ env('APP_NAME') }}</title>    
    </head>
    <body>
      @include('layouts.navbar')
      <div class="container">
        <div class="mt-3 mb-3">
          <h3>Research Data Statistics</h3>
        </div>
        <div class="mb-3">
          <canvas id="myChart"</canvas>
        </div>

      </div>

      <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.js"></script>    
      
      <script>
        $(document).ready(function() {
          var researchType = new Array();
          var total = new Array();
          $.ajax({
            url: `{{ url('/research/get_stats/per_research_type') }}`,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            method: 'GET',
            success: function(response) {
              response.forEach(function(data){
                researchType.push(data.rt_name);
                total.push(data.total);
              });
              const ctx = document.getElementById('myChart');
              const myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                  labels: researchType,
                  datasets: [{
                    label: 'Total Researchs per Type',
                    data: total,
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