@include('layouts.header')
        <title>Publication per Author per Year Statistics | {{ env('APP_NAME') }}</title>    
    </head>
    <body>
      @include('layouts.navbar')
      <div class="container">
        <div class="mt-3 mb-3">
          statistik
        </div>

        <div class="mb-3">
          <label for="" class="form-label">Author :</label>
          <select class="form-select" id="author_select">
            <option value="" selected>Please select</option>
            @foreach ($author as $a)
                <option value={{ $a->id }}>{{ $a->name . ' - ' . $a->code }}</option>                                    
            @endforeach
          </select>
        </div>

        <div class="mb-3">
          <canvas id="myChart"</canvas>
        </div>

      </div>

      <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.js"></script>    
      
      <script>
        $(document).ready(function() {
          const ctx = document.getElementById('myChart')
          let myChart = new Chart(ctx, {type: 'bar'})
          
          $('#author_select').change(function () {
            myChart.destroy()
            let Years = new Array()
            let Total = new Array()
            let author_id = $('#author_select').val()
            let author
            $.ajax({
              url: `{{ url('/publication/get_stats/per_author_per_year/${author_id}') }}`,
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              },
              method: 'GET',
              success: function(response) {
                response.forEach(function(data){
                  data.publications.forEach(function(publication) {
                    Years.push(publication.year);
                    Total.push(publication.total);

                  }) 
                  author = data.code
                });
                myChart = new Chart(ctx, {
                  type: 'bar',
                  data: {
                    labels: Years,
                    datasets: [{
                      label: `Total Publications of ${author} per Year`,
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
            })            
          })

        })

        
      </script>

    </body>
</html>