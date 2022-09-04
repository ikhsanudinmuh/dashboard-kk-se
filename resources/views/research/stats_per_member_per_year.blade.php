@include('layouts.header')
        <title>Research per Member per Year Statistics | {{ env('APP_NAME') }}</title>    
    </head>
    <body>
      @include('layouts.navbar')
      <div class="container">
        <div class="mt-3 mb-3">
          <h3>Research Data Statistics</h3>
        </div>

        <div class="mb-3">
          <label for="" class="form-label">Member :</label>
          <select class="form-select" id="member_select">
            <option value="" selected>Please select</option>
            @foreach ($member as $m)
                <option value={{ $m->id }}>{{ $m->name . ' - ' . $m->code }}</option>                                    
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
          
          $('#member_select').change(function () {
            myChart.destroy()
            let Years = new Array()
            let Total = new Array()
            let member_id = $('#member_select').val()
            let member
            $.ajax({
              url: `{{ url('/research/get_stats/per_member_per_year/${member_id}') }}`,
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              },
              method: 'GET',
              success: function(response) {
                response.forEach(function(data){
                  data.researchs.forEach(function(research) {
                    Years.push(research.year);
                    Total.push(research.total);

                  }) 
                  member = data.code
                });
                myChart = new Chart(ctx, {
                  type: 'bar',
                  data: {
                    labels: Years,
                    datasets: [{
                      label: `Total Researchs of ${member} per Year`,
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