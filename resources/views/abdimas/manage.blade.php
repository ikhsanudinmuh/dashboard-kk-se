{{-- halaman untuk manage data abdimas --}}
{{-- memanggil header --}}
@include('layouts.header')
        <title>Manage Abdimas | {{ env('APP_NAME') }}</title>    

        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.css">  
        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.js"></script>
        <script src="https://kit.fontawesome.com/c2640fba80.js" crossorigin="anonymous"></script>
    </head>
    <body>
      {{-- memanggil navbar --}}
      @include('layouts.navbar')

      <div class="container">
        {{-- menampilkan alert ketika berhasil mengubah atau menghapus data --}}
        @if (session('success'))
          <div class="alert alert-success" role="alert">
              {{ session('success') }}
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        @endif

        <div class="mt-3 mb-3">
          <h3>Manage Abdimas Data</h3>
        </div>

        <div class="mb-3">
          {{-- tabel data abdimas --}}
          <table id="table_abdimas" class="display">
            <thead>
              <tr>
                <th>Year</th>
                <th>Abdimas Type</th>
                <th>Activity Name</th>
                <th>Title</th>
                <th>Status</th>
                <th>Detail</th>
                <th>File</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              {{-- menampilkan data abdimas di tabel --}}
              @foreach ($abdimas as $ad)
                <tr>
                  <td>{{ $ad->year }}</td>
                  <td>{{ $ad->abdimas_type }}</td>
                  <td>{{ $ad->activity_name }}</td>
                  <td>{{ $ad->title }}</td>
                  <td>{{ $ad->status }}</td>
                  <td>
                      <button type="button" class="btn text-white" data-bs-toggle="modal" data-bs-target="#abdimasDetail{{ $ad->id }}" style="background-color: #BF0000">
                          Detail
                      </button>
                  </td>
                  <td>
                      @if ($ad->abdimas_file != null)
                          <button type="button" class="btn text-white" data-bs-toggle="modal" data-bs-target="#abdimasFile{{ $ad->id }}" style="background-color: #BF0000">
                              Open File
                          </button>                                        
                      @else
                          No File
                      @endif
                  </td>
                  <td>
                    <div class="d-flex">
                      <button type="button" class="btn btn-warning me-1" data-bs-toggle="modal" data-bs-target="#editAbdimas{{ $ad->id }}">
                          <i class="fa-solid fa-pen-to-square"></i>
                      </button>
                      <form action="{{ route('abdimas.destroy', [$ad->id]) }}" method="POST">
                          @method('delete')
                          @csrf
                          <button class="btn btn-danger" onclick="return confirm('Are you sure want to delete this data?')"><i class="fa-solid fa-trash"></i></button>
                      </form>
                    </div>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>

        <div class="mb-3"></div>
      </div>

      
      @foreach ($abdimas as $ad)
        <!-- Modal untuk edit data abdimas -->
        <div class="modal fade" id="editAbdimas{{ $ad->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Add Abdimas Data</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                  <form action="{{ route('abdimas.update', [$ad->id]) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <div class="mb-3">
                      <label for="" class="form-label">Year(YYYY) :</label>
                      <input type="text" class="form-control @error('year') is-invalid @enderror" id="" name="year" value="{{ $ad->year }}">
                      <div class="invalid-feedback">@error('year') {{ $message }} @enderror</div>
                    </div>
                    <div class="mb-3">
                      <label for="" class="form-label">Abdimas Type :</label>
                      <select class="form-select @error('abdimas_type_id') is-invalid @enderror" name="abdimas_type_id">
                        @foreach ($abdimas_type as $at)
                          @if ($at->id == $ad->abdimas_type_id)
                            <option value={{ $at->id }} selected>{{ $at->name }}</option>
                          @else
                            <option value={{ $at->id }}>{{ $at->name }}</option>
                          @endif
                        @endforeach
                      </select>
                      <div class="invalid-feedback">@error('abdimas_type_id') {{ $message }} @enderror</div>
                    </div>
                    <div class="mb-3">
                      <label for="" class="form-label">Activity Name(Optional) :</label>
                      <input type="text" class="form-control @error('activity_name') is-invalid @enderror" id="" name="activity_name" value="{{ $ad->activity_name }}">
                      <div class="invalid-feedback">@error('activity_name') {{ $message }} @enderror</div>
                    </div>
                    <div class="mb-3">
                      <label for="" class="form-label">Abdimas Title :</label>
                      <textarea name="title" class="form-control @error('title') is-invalid @enderror" cols="30" rows="3">{{ $ad->title }}</textarea>
                      <div class="invalid-feedback">@error('title') {{ $message }} @enderror</div>
                    </div>
                    <div class="mb-3">
                      <label for="" class="form-label">Status :</label>
                      <select class="form-select @error('status') is-invalid @enderror" name="status">
                        @if ($ad->status == 'Submit Proposal')
                          <option value='Submit Proposal' selected>Submit Proposal</option>
                          <option value='Funded'>Funded</option>
                          <option value='Closed'>Closed</option>
                        @elseif ($ad->status == 'Funded')                            
                          <option value='Submit Proposal'>Submit Proposal</option>
                          <option value='Funded' selected>Funded</option>
                          <option value='Closed'>Closed</option>
                        @elseif ($ad->status == 'Closed')                            
                          <option value='Submit Proposal'>Submit Proposal</option>
                          <option value='Funded'>Funded</option>
                          <option value='Closed' selected>Closed</option>
                        @endif
                      </select>
                      <div class="invalid-feedback">@error('status') {{ $message }} @enderror</div>
                    </div>
                    <div class="mb-3">
                      <label for="" class="form-label">Abdimas Leader :</label>
                      <select class="form-select @error('leader_id') is-invalid @enderror" name="leader_id">
                        @foreach ($member as $m)
                          @if ($m->id == $ad->leader_id)
                            <option value={{ $m->id }} selected>{{ $m->name . ' - ' . $m->code }}</option>
                          @else
                            <option value={{ $m->id }}>{{ $m->name . ' - ' . $m->code }}</option>
                          @endif
                        @endforeach
                      </select>
                      <div class="invalid-feedback">@error('leader_id') {{ $message }} @enderror</div>
                    </div>
                    <div class="mb-3">
                      <label for="" class="form-label">Abdimas Member 1(Optional) :</label>
                      <select class="form-select @error('member_1_id') is-invalid @enderror" name="member_1_id">
                        <option value="">Please select</option>
                        @foreach ($member as $m)
                          @if ($m->id == $ad->member_1_id)
                            <option value={{ $m->id }} selected>{{ $m->name . ' - ' . $m->code }}</option>
                          @else
                            <option value={{ $m->id }}>{{ $m->name . ' - ' . $m->code }}</option>
                          @endif
                        @endforeach
                      </select>
                      <div class="invalid-feedback">@error('member_1_id') {{ $message }} @enderror</div>
                    </div>
                    <div class="mb-3">
                      <label for="" class="form-label">Abdimas Member 2(Optional) :</label>
                      <select class="form-select @error('member_2_id') is-invalid @enderror" name="member_2_id">
                        <option value="">Please select</option>
                        @foreach ($member as $m)
                          @if ($m->id == $ad->member_2_id)
                            <option value={{ $m->id }} selected>{{ $m->name . ' - ' . $m->code }}</option>
                          @else
                            <option value={{ $m->id }}>{{ $m->name . ' - ' . $m->code }}</option>
                          @endif
                        @endforeach
                      </select>
                      <div class="invalid-feedback">@error('member_2_id') {{ $message }} @enderror</div>
                    </div>
                    <div class="mb-3">
                      <label for="" class="form-label">Abdimas Member 3(Optional) :</label>
                      <select class="form-select @error('member_3_id') is-invalid @enderror" name="member_3_id">
                        <option value="">Please select</option>
                        @foreach ($member as $m)
                          @if ($m->id == $ad->member_3_id)
                            <option value={{ $m->id }} selected>{{ $m->name . ' - ' . $m->code }}</option>
                          @else
                            <option value={{ $m->id }}>{{ $m->name . ' - ' . $m->code }}</option>
                          @endif
                        @endforeach
                      </select>
                      <div class="invalid-feedback">@error('member_3_id') {{ $message }} @enderror</div>
                    </div>
                    <div class="mb-3">
                      <label for="" class="form-label">Abdimas Member 4(Optional) :</label>
                      <select class="form-select @error('member_4_id') is-invalid @enderror" name="member_4_id">
                        <option value="">Please select</option>
                        @foreach ($member as $m)
                          @if ($m->id == $ad->member_4_id)
                            <option value={{ $m->id }} selected>{{ $m->name . ' - ' . $m->code }}</option>
                          @else
                            <option value={{ $m->id }}>{{ $m->name . ' - ' . $m->code }}</option>
                          @endif
                        @endforeach
                      </select>
                      <div class="invalid-feedback">@error('member_4_id') {{ $message }} @enderror</div>
                    </div>
                    <div class="mb-3">
                      <label for="" class="form-label">Abdimas Member 5(Optional) :</label>
                      <select class="form-select @error('member_5_id') is-invalid @enderror" name="member_5_id">
                        <option value="">Please select</option>
                        @foreach ($member as $m)
                          @if ($m->id == $ad->member_5_id)
                            <option value={{ $m->id }} selected>{{ $m->name . ' - ' . $m->code }}</option>
                          @else
                            <option value={{ $m->id }}>{{ $m->name . ' - ' . $m->code }}</option>
                          @endif
                        @endforeach
                      </select>
                      <div class="invalid-feedback">@error('member_5_id') {{ $message }} @enderror</div>
                    </div>
                    <div class="mb-3">
                      <label for="" class="form-label">Research Lab :</label>
                      <select class="form-select @error('lab_id') is-invalid @enderror" name="lab_id">
                        @foreach ($lab as $l)
                          @if ($l->id == $ad->lab_id)
                            <option value={{ $l->id }} selected>{{ $l->name }}</option>
                          @else                               
                            <option value={{ $l->id }}>{{ $l->name }}</option>
                          @endif
                        @endforeach
                      </select>
                      <div class="invalid-feedback">@error('lab_id') {{ $message }} @enderror</div>
                    </div>
                    <div class="mb-3">
                      <label for="" class="form-label">Partner(Optional) :</label>
                      <textarea name="partner" class="form-control @error('partner') is-invalid @enderror" cols="30" rows="3">{{ $ad->partner }}</textarea>
                      <div class="invalid-feedback">@error('partner') {{ $message }} @enderror</div>
                    </div>
                    <div class="mb-3">
                      <label for="" class="form-label">Partner Address(Optional) :</label>
                      <textarea name="partner_address" class="form-control @error('partner_address') is-invalid @enderror" cols="30" rows="3">{{ $ad->partner_address }}</textarea>
                      <div class="invalid-feedback">@error('partner_address') {{ $message }} @enderror</div>
                    </div>
                    <div class="mb-3">
                      <label for="" class="form-label">File(Optional) :</label>
                      <input type="file" class="form-control" name="abdimas_file">
                      <div class="invalid-feedback">@error('abdimas_file') {{ $message }} @enderror</div>
                    </div>
                    <div class="d-grid mb-3">
                        <button type="submit" class="btn text-white" style="background-color: #BF0000">Submit</button>
                    </div>
                  </form>
              </div>
          </div>
          </div>
        </div>
          <!-- Modal untuk lihat detail data abdimas -->
          <div class="modal fade" id="abdimasDetail{{ $ad->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">{{ $ad->title }}</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <h6>Year : </h6>
                {{ $ad->year }}
                <br><br>

                <h6>Abdimas Type : </h6>
                @if ($ad->abdimas_type != NULL) {{ $ad->abdimas_type }} @endif
                <br><br>

                <h6>Activity Name : </h6>
                @if ($ad->activity_name != NULL) {{ $ad->activity_name }} @endif
                <br><br>

                <h6>Abdimas Title : </h6>
                {{ $ad->title }}
                <br><br>

                <h6>Status : </h6>
                {{ $ad->status }}
                <br><br>

                <h6>Abdimas Leader : </h6>
                @if ($ad->leader != NULL) {{ $ad->leader }} @endif
                <br><br>

                <h6>Abdimas Member : </h6>
                @if ($ad->member1 != NULL) {{ $ad->member1 }}, @endif
                @if ($ad->member2 != NULL) {{ $ad->member2 }}, @endif
                @if ($ad->member3 != NULL) {{ $ad->member3 }}, @endif
                @if ($ad->member4 != NULL) {{ $ad->member4 }}, @endif
                @if ($ad->member5 != NULL) {{ $ad->member5 }} @endif
                <br><br>

                <h6>Research Lab : </h6>
                {{ $ad->lab_name }}
                <br><br>

                <h6>Partner : </h6>
                @if ($ad->partner != NULL) {{ $ad->partner }} @endif
                <br><br>

                <h6>Partner Address : </h6>
                @if ($ad->partner_address != NULL) {{ $ad->partner_address }} @endif
                <br><br>
              </div>
            </div>
            </div>
          </div>            

          <!-- Modal untuk lihat pdf dari abdimas -->
          <div class="modal fade" id="abdimasFile{{ $ad->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-lg">
              <div class="modal-content">
                  <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">{{ $ad->title }}</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                      @if ($ad->abdimas_file)
                          <iframe src="/abdimas_file/{{ $ad->abdimas_file }}" align="top" height="620" width="100%" frameborder="0" scrolling="auto"></iframe>                            
                      @endif
                  </div>
              </div>
              </div>
          </div>            
        @endforeach
    
      <script>
          $(document).ready( function () {
              $('#table_abdimas').DataTable();
          } );
      </script>
    </body>
</html>