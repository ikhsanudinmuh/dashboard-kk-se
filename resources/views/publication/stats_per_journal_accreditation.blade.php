@include('layouts.header')
        <title>Publication per Journal Accreditation Statistics | {{ env('APP_NAME') }}</title>    
    </head>
    <body>
      @include('layouts.navbar')
      <div class="container">
        <div class="mt-3 mb-3">
          statistik
        </div>
        <div class="mb-3">
          <canvas id="myChart"</canvas>
        </div>

      </div>

      <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.js"></script>    
      
      <script>
        $(document).ready(function() {
          var journalAccreditation = new Array();
          var total = new Array();
          $.ajax({
            url: `{{ url('/publication/get_stats/per_journal_accreditation') }}`,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            method: 'GET',
            success: function(response) {
              response.forEach(function(data){
                journalAccreditation.push(data.ja_name);
                total.push(data.total);
              });
              const ctx = document.getElementById('myChart');
              const myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                  labels: journalAccreditation,
                  datasets: [{
                    label: 'Total Publications per Journal Accreditation',
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