@include('layouts.header')
        <title>Researchs | {{ env('APP_NAME') }}</title>    

        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.css">  
        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.js"></script>
    </head>
    <body>
      @include('layouts.navbar')

      <div class="container">
        @if (session('success'))
          <div class="alert alert-success" role="alert">
              {{ session('success') }}
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        @endif

        <div class="mt-3 mb-3">
          <h3>Research Data</h3>
        </div>

        @if (Auth::check() == TRUE)
          @if (Auth::user()->role == 'lecturer')
            <div class="mb-3">
                <button type="button" class="btn text-white" data-bs-toggle="modal" data-bs-target="#addData" style="background-color: #BF0000">
                  Add Data
                </button>
            </div>
          @endif
          @if (Auth::user()->role == 'admin')
              <div class="mb-3">
                <button type="button" class="btn text-white" data-bs-toggle="modal" data-bs-target="#addData" style="background-color: #BF0000">
                    Add Data
                </button>
                <a class="btn btn-warning" href="/research/manage" role="button">Manage Data</a>
              </div>
          @endif
        @endif

        <div class="mb-3">
          <table id="table_research" class="display">
            <thead>
              <tr>
                <th>Year</th>
                <th>Research Type</th>
                <th>Activity Name</th>
                <th>Title</th>
                <th>Status</th>
                <th>Detail</th>
                <th>File</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($research as $r)
                <tr>
                  <td>{{ $r->year }}</td>
                  <td>{{ $r->research_type }}</td>
                  <td>{{ $r->activity_name }}</td>
                  <td>{{ $r->title }}</td>
                  <td>{{ $r->status }}</td>
                  <td>
                      <button type="button" class="btn text-white" data-bs-toggle="modal" data-bs-target="#researchDetail{{ $r->id }}" style="background-color: #BF0000">
                          Detail
                      </button>
                  </td>
                  <td>
                      @if ($r->research_file != null)
                          <button type="button" class="btn text-white" data-bs-toggle="modal" data-bs-target="#researchFile{{ $r->id }}" style="background-color: #BF0000">
                              Open File
                          </button>                                        
                      @else
                          No File
                      @endif
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>

        <h3>Research Statistics</h3>
        <div class="d-flex justify-content-start">
          <a class="btn btn-primary me-2" href="{{ route('research.stats', ['view' => 'per_year']) }}" role="button">Research per Year</a>
          <a class="btn btn-primary me-2" href="{{ route('research.stats', ['view' => 'per_research_type']) }}" role="button">Research per Type</a>
          <a class="btn btn-primary me-2" href="{{ route('research.stats', ['view' => 'per_member']) }}" role="button">Research per Member</a>
          <a class="btn btn-primary me-2" href="{{ route('research.stats', ['view' => 'per_member_per_year']) }}" role="button">Research per Member per Year</a>
        </div>

        <div class="mb-3"></div>
      </div>

      <!-- Modal untuk tambah data penelitian -->
      <div class="modal fade" id="addData" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Research Data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('research.store') }}" method="post" enctype="multipart/form-data">
                  @csrf
                  <div class="mb-3">
                    <label for="" class="form-label">Year(YYYY) :</label>
                    <input type="text" class="form-control @error('year') is-invalid @enderror" id="" name="year">
                    <div class="invalid-feedback">@error('year') {{ $message }} @enderror</div>
                  </div>
                  <div class="mb-3">
                    <label for="" class="form-label">Research Type :</label>
                    <select class="form-select @error('research_type_id') is-invalid @enderror" name="research_type_id">
                      <option value="" selected>Please select</option>
                      @foreach ($research_type as $rt)
                      <option value={{ $rt->id }}>{{ $rt->name }}</option>                                    
                      @endforeach
                    </select>
                    <div class="invalid-feedback">@error('research_type_id') {{ $message }} @enderror</div>
                  </div>
                  <div class="mb-3">
                    <label for="" class="form-label">Activity Name(Optional) :</label>
                    <input type="text" class="form-control @error('activity_name') is-invalid @enderror" id="" name="activity_name">
                    <div class="invalid-feedback">@error('activity_name') {{ $message }} @enderror</div>
                  </div>
                  <div class="mb-3">
                    <label for="" class="form-label">Research Title :</label>
                    <textarea name="title" class="form-control @error('title') is-invalid @enderror" cols="30" rows="3"></textarea>
                    <div class="invalid-feedback">@error('title') {{ $message }} @enderror</div>
                  </div>
                  <div class="mb-3">
                    <label for="" class="form-label">Status :</label>
                    <select class="form-select @error('status') is-invalid @enderror" name="status">
                        <option value='Submit Proposal'>Submit Proposal</option>
                        <option value='Funded'>Funded</option>
                        <option value='Closed'>Closed</option>
                    </select>
                    <div class="invalid-feedback">@error('status') {{ $message }} @enderror</div>
                  </div>
                  <div class="mb-3">
                    <label for="" class="form-label">Research Leader :</label>
                    <select class="form-select @error('leader_id') is-invalid @enderror" name="leader_id">
                      <option value="" selected>Please select</option>
                      @foreach ($member as $m)
                        <option value={{ $m->id }}>{{ $m->name . ' - ' . $m->code }}</option>                                    
                      @endforeach
                    </select>
                    <div class="invalid-feedback">@error('leader_id') {{ $message }} @enderror</div>
                  </div>
                  <div class="mb-3">
                    <label for="" class="form-label">Research Member 1(Optional) :</label>
                    <select class="form-select @error('member_1_id') is-invalid @enderror" name="member_1_id">
                      <option value="" selected>Please select</option>
                      @foreach ($member as $m)
                        <option value={{ $m->id }}>{{ $m->name . ' - ' . $m->code }}</option>                                    
                      @endforeach
                    </select>
                    <div class="invalid-feedback">@error('member_1_id') {{ $message }} @enderror</div>
                  </div>
                  <div class="mb-3">
                    <label for="" class="form-label">Research Member 2(Optional) :</label>
                    <select class="form-select @error('member_2_id') is-invalid @enderror" name="member_2_id">
                      <option value="" selected>Please select</option>
                      @foreach ($member as $m)
                        <option value={{ $m->id }}>{{ $m->name . ' - ' . $m->code }}</option>                                    
                      @endforeach
                    </select>
                    <div class="invalid-feedback">@error('member_2_id') {{ $message }} @enderror</div>
                  </div>
                  <div class="mb-3">
                    <label for="" class="form-label">Research Member 3(Optional) :</label>
                    <select class="form-select @error('member_3_id') is-invalid @enderror" name="member_3_id">
                      <option value="" selected>Please select</option>
                      @foreach ($member as $m)
                        <option value={{ $m->id }}>{{ $m->name . ' - ' . $m->code }}</option>                                    
                      @endforeach
                    </select>
                    <div class="invalid-feedback">@error('member_3_id') {{ $message }} @enderror</div>
                  </div>
                  <div class="mb-3">
                    <label for="" class="form-label">Partner(Optional) :</label>
                    <textarea name="partner" class="form-control @error('partner') is-invalid @enderror" cols="30" rows="3"></textarea>
                    <div class="invalid-feedback">@error('partner') {{ $message }} @enderror</div>
                  </div>
                  <div class="mb-3">
                    <label for="" class="form-label">Research Lab :</label>
                    <select class="form-select @error('lab_id') is-invalid @enderror" name="lab_id">
                      @foreach ($lab as $l)
                          <option value={{ $l->id }}>{{ $l->name }}</option>                               
                      @endforeach
                    </select>
                    <div class="invalid-feedback">@error('lab_id') {{ $message }} @enderror</div>
                  </div>
                  <div class="mb-3">
                    <label for="" class="form-label">File(Optional) :</label>
                    <input type="file" class="form-control" name="research_file">
                    <div class="invalid-feedback">@error('research_file') {{ $message }} @enderror</div>
                  </div>
                  <div class="d-grid mb-3">
                      <button type="submit" class="btn text-white" style="background-color: #BF0000">Submit</button>
                  </div>
                </form>
            </div>
        </div>
        </div>
      </div>

      @foreach ($research as $r)
          <!-- Modal untuk lihat detail data penelitian -->
          <div class="modal fade" id="researchDetail{{ $r->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">{{ $r->title }}</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <h6>Year : </h6>
                {{ $r->year }}
                <br><br>

                <h6>Research Type : </h6>
                @if ($r->research_type != NULL) {{ $r->research_type }} @endif
                <br><br>

                <h6>Activity Name : </h6>
                @if ($r->activity_name != NULL) {{ $r->activity_name }} @endif
                <br><br>

                <h6>Research Title : </h6>
                {{ $r->title }}
                <br><br>

                <h6>Status : </h6>
                {{ $r->status }}
                <br><br>

                <h6>Research Leader : </h6>
                @if ($r->leader != NULL) {{ $r->leader }} @endif
                <br><br>

                <h6>Research Member : </h6>
                @if ($r->member1 != NULL) {{ $r->member1 }}, @endif
                @if ($r->member2 != NULL) {{ $r->member2 }}, @endif
                @if ($r->member3 != NULL) {{ $r->member3 }} @endif
                <br><br>

                <h6>Partner : </h6>
                @if ($r->partner != NULL) {{ $r->partner }} @endif
                <br><br>

                <h6>Research Lab : </h6>
                {{ $r->lab_name }}
                <br><br>
              </div>
            </div>
            </div>
          </div>            

          <!-- Modal untuk lihat pdf dari penelitian -->
          <div class="modal fade" id="researchFile{{ $r->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-lg">
              <div class="modal-content">
                  <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">{{ $r->title }}</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                      @if ($r->research_file)
                          <iframe src="/research_file/{{ $r->research_file }}" align="top" height="620" width="100%" frameborder="0" scrolling="auto"></iframe>                            
                      @endif
                  </div>
              </div>
              </div>
          </div>            
        @endforeach
    
      <script>
          $(document).ready( function () {
              $('#table_research').DataTable();
          } );
      </script>
    </body>
</html>