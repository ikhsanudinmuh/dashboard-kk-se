{{-- halaman index data hki --}}
{{-- memanggil header --}}
@include('layouts.header')
        <title>HKIs | {{ env('APP_NAME') }}</title>    

        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.css">  
        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.js"></script>
    </head>
    <body>
      {{-- memanggil navbar --}}
      @include('layouts.navbar')

      <div class="container">
        {{-- menampilkan alert ketika berhasil menambahkan data --}}
        @if (session('success'))
          <div class="alert alert-success" role="alert">
              {{ session('success') }}
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        @endif

        <div class="mt-3 mb-3">
          <h3>HKI Data</h3>
        </div>

        {{-- validasi user telah login --}}
        @if (Auth::check() == TRUE)
        {{-- validasi jika user yang login adalah role lecturer --}}
          @if (Auth::user()->role == 'lecturer')
            <div class="mb-3">
                <button type="button" class="btn text-white" data-bs-toggle="modal" data-bs-target="#addData" style="background-color: #BF0000">
                  Add Data
                </button>
            </div>
          @endif
          {{-- validasi jika user yang login adalah role admin --}}
          @if (Auth::user()->role == 'admin')
              <div class="mb-3">
                <button type="button" class="btn text-white" data-bs-toggle="modal" data-bs-target="#addData" style="background-color: #BF0000">
                    Add Data
                </button>
                <a class="btn btn-warning" href="/hki/manage" role="button">Manage Data</a>
              </div>
          @endif
        @endif

        <div class="mb-3">
          {{-- tabel data hki --}}
          <table id="table_hki" class="display">
            <thead>
              <tr>
                <th>Year</th>
                <th>Patent Type</th>
                <th>Creation Type</th>
                <th>Title</th>
                <th>Detail</th>
                <th>File</th>
              </tr>
            </thead>
            <tbody>
              {{-- menampilkan data hki di tabel --}}
              @foreach ($hki as $hd)
                <tr>
                  <td>{{ $hd->year }}</td>
                  <td>{{ $hd->patent_type }}</td>
                  <td>{{ $hd->creation_type }}</td>
                  <td>{{ $hd->title }}</td>
                  <td>
                      <button type="button" class="btn text-white" data-bs-toggle="modal" data-bs-target="#hkiDetail{{ $hd->id }}" style="background-color: #BF0000">
                          Detail
                      </button>
                  </td>
                  <td>
                      @if ($hd->hki_file != null)
                          <button type="button" class="btn text-white" data-bs-toggle="modal" data-bs-target="#hkiFile{{ $hd->id }}" style="background-color: #BF0000">
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

        <h3>HKI Statistics</h3>
        <div class="d-flex justify-content-start">
          <a class="btn btn-primary me-2" href="{{ route('hki.stats', ['view' => 'per_year']) }}" role="button">Hki per Year</a>
          <a class="btn btn-primary me-2" href="{{ route('hki.stats', ['view' => 'per_patent_type']) }}" role="button">Hki per Patent Type</a>
          <a class="btn btn-primary me-2" href="{{ route('hki.stats', ['view' => 'per_member']) }}" role="button">Hki per Member</a>
          <a class="btn btn-primary me-2" href="{{ route('hki.stats', ['view' => 'per_member_per_year']) }}" role="button">Hki per Member per Year</a>
        </div>

        <div class="mb-3"></div>
      </div>

      <!-- Modal untuk tambah data hki -->
      <div class="modal fade" id="addData" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add HKI Data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('hki.store') }}" method="post" enctype="multipart/form-data">
                  @csrf
                  <div class="mb-3">
                    <label for="" class="form-label">Year(YYYY) :</label>
                    <input type="text" class="form-control @error('year') is-invalid @enderror" id="" name="year">
                    <div class="invalid-feedback">@error('year') {{ $message }} @enderror</div>
                  </div>
                  <div class="mb-3">
                    <label for="" class="form-label">Leader :</label>
                    <select class="form-select @error('leader_id') is-invalid @enderror" name="leader_id">
                      <option value="" selected>Please select</option>
                      @foreach ($member as $m)
                        <option value={{ $m->id }}>{{ $m->name . ' - ' . $m->code }}</option>                                    
                      @endforeach
                    </select>
                    <div class="invalid-feedback">@error('leader_id') {{ $message }} @enderror</div>
                  </div>
                  <div class="mb-3">
                    <label for="" class="form-label">Member 1(Optional) :</label>
                    <select class="form-select @error('member_1_id') is-invalid @enderror" name="member_1_id">
                      <option value="" selected>Please select</option>
                      @foreach ($member as $m)
                        <option value={{ $m->id }}>{{ $m->name . ' - ' . $m->code }}</option>                                    
                      @endforeach
                    </select>
                    <div class="invalid-feedback">@error('member_1_id') {{ $message }} @enderror</div>
                  </div>
                  <div class="mb-3">
                    <label for="" class="form-label">Member 2(Optional) :</label>
                    <select class="form-select @error('member_2_id') is-invalid @enderror" name="member_2_id">
                      <option value="" selected>Please select</option>
                      @foreach ($member as $m)
                        <option value={{ $m->id }}>{{ $m->name . ' - ' . $m->code }}</option>                                    
                      @endforeach
                    </select>
                    <div class="invalid-feedback">@error('member_2_id') {{ $message }} @enderror</div>
                  </div>
                  <div class="mb-3">
                    <label for="" class="form-label">Member 3(Optional) :</label>
                    <select class="form-select @error('member_3_id') is-invalid @enderror" name="member_3_id">
                      <option value="" selected>Please select</option>
                      @foreach ($member as $m)
                        <option value={{ $m->id }}>{{ $m->name . ' - ' . $m->code }}</option>                                    
                      @endforeach
                    </select>
                    <div class="invalid-feedback">@error('member_3_id') {{ $message }} @enderror</div>
                  </div>
                  <div class="mb-3">
                    <label for="" class="form-label">Patent Type :</label>
                    <select class="form-select @error('patent_type_id') is-invalid @enderror" name="patent_type_id">
                      @foreach ($patent_type as $pt)
                        <option value={{ $pt->id }}>{{ $pt->name }}</option>                                    
                      @endforeach
                    </select>
                    <div class="invalid-feedback">@error('patent_type_id') {{ $message }} @enderror</div>
                  </div>
                  <div class="mb-3">
                    <label for="" class="form-label">Creation Type(Optional) :</label>
                    <input type="text" class="form-control @error('creation_type') is-invalid @enderror" id="" name="creation_type">
                    <div class="invalid-feedback">@error('creation_type') {{ $message }} @enderror</div>
                  </div>
                  <div class="mb-3">
                    <label for="" class="form-label">Title :</label>
                    <textarea name="title" class="form-control @error('title') is-invalid @enderror" cols="30" rows="3"></textarea>
                    <div class="invalid-feedback">@error('title') {{ $message }} @enderror</div>
                  </div>
                  <div class="mb-3">
                    <label for="" class="form-label">Description(Optional) :</label>
                    <textarea name="description" class="form-control @error('description') is-invalid @enderror" cols="30" rows="3"></textarea>
                    <div class="invalid-feedback">@error('description') {{ $message }} @enderror</div>
                  </div>
                  <div class="mb-3">
                    <label for="" class="form-label">Registration Number(Optional) :</label>
                    <input type="text" class="form-control @error('registration_number') is-invalid @enderror" id="" name="registration_number">
                    <div class="invalid-feedback">@error('registration_number') {{ $message }} @enderror</div>
                  </div>
                  <div class="mb-3">
                    <label for="" class="form-label">Sertification Number(Optional) :</label>
                    <input type="text" class="form-control @error('sertification_number') is-invalid @enderror" id="" name="sertification_number">
                    <div class="invalid-feedback">@error('sertification_number') {{ $message }} @enderror</div>
                  </div>
                  <div class="mb-3">
                    <label for="" class="form-label">File(Optional) :</label>
                    <input type="file" class="form-control" name="hki_file">
                    <div class="invalid-feedback">@error('hki_file') {{ $message }} @enderror</div>
                  </div>
                  <div class="d-grid mb-3">
                      <button type="submit" class="btn text-white" style="background-color: #BF0000">Submit</button>
                  </div>
                </form>
            </div>
        </div>
        </div>
      </div>

      @foreach ($hki as $hd)
          <!-- Modal untuk lihat detail data hki -->
          <div class="modal fade" id="hkiDetail{{ $hd->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">{{ $hd->title }}</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <h6>Year : </h6>
                {{ $hd->year }}
                <br><br>

                <h6>Leader : </h6>
                @if ($hd->leader != NULL) {{ $hd->leader }} @endif
                <br><br>

                <h6>Member : </h6>
                @if ($hd->member1 != NULL) {{ $hd->member1 }}, @endif
                @if ($hd->member2 != NULL) {{ $hd->member2 }}, @endif
                @if ($hd->member3 != NULL) {{ $hd->member3 }} @endif
                <br><br>

                <h6>Patent Type : </h6>
                @if ($hd->patent_type != NULL) {{ $hd->patent_type }} @endif
                <br><br>

                <h6>Creation Type : </h6>
                @if ($hd->creation_type != NULL) {{ $hd->creation_type }} @endif
                <br><br>

                <h6>Title : </h6>
                {{ $hd->title }}
                <br><br>

                <h6>Description : </h6>
                @if ($hd->description != NULL) {{ $hd->description }} @endif
                <br><br>
                
                <h6>Registration Number : </h6>
                @if ($hd->registration_number != NULL) {{ $hd->registration_number }} @endif
                <br><br>

                <h6>Sertification Number : </h6>
                @if ($hd->sertification_number != NULL) {{ $hd->sertification_number }} @endif
                <br><br>
                
              </div>
            </div>
            </div>
          </div>            

          <!-- Modal untuk lihat pdf dari hki -->
          <div class="modal fade" id="hkiFile{{ $hd->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-lg">
              <div class="modal-content">
                  <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">{{ $hd->title }}</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                      @if ($hd->hki_file)
                          <iframe src="/hki_file/{{ $hd->hki_file }}" align="top" height="620" width="100%" frameborder="0" scrolling="auto"></iframe>                            
                      @endif
                  </div>
              </div>
              </div>
          </div>            
        @endforeach
    
      <script>
          $(document).ready( function () {
              $('#table_hki').DataTable();
          } );
      </script>
    </body>
</html>