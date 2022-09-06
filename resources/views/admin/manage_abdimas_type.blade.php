{{-- halaman untuk manage data tipe abdimas --}}
{{-- memanggil header --}}
@include('layouts.header')
        <title>Manage Abdimas Type | {{ env('APP_NAME') }}</title>    

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
            <h3>Manage Abdimas Type Data</h3>
          </div>

          <div class="mb-3">
            {{-- button untuk memanggil modal add data --}}
            <button type="button" class="btn text-white" data-bs-toggle="modal" data-bs-target="#addData" style="background-color: #BF0000">
                Add Data
            </button>
          </div>

          {{-- tabel data tipe abdimas --}}
          <table id="table_abdimas_type" class="display">
            <thead>
              <tr>
                  <th>Name</th>
                  <th>Action</th>
              </tr>
            </thead>
            <tbody>
              {{-- menampikan data tipe abdimas di tabel --}}
              @foreach ($abdimas_type as $at)
                <tr>
                    <td>{{ $at->name }}</td>
                    <td>
                      <div class="d-flex">
                        <button type="button" class="btn btn-warning me-1" data-bs-toggle="modal" data-bs-target="#editAbdimasType{{ $at->id }}">
                          <i class="fa-solid fa-pen-to-square"></i>
                        </button>
                        <form action="{{ route('abdimas_type.destroy', [$at->id]) }}" method="POST">
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

        <!-- Modal untuk tambah data abdimas_type -->
        <div class="modal fade" id="addData" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Abdimas Type Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <form action="{{ route('abdimas_type.store') }}" method="post" enctype="">
                    @csrf      
                    <div class="mb-3">
                        <label for="" class="form-label">Name :</label>
                        <input type="text" class="form-control" name="name">
                        <div class="invalid-feedback">@error('name') {{ $message }} @enderror</div>
                    </div>
                    <div class="d-grid mb-3">
                        <button type="submit" class="btn text-white" style="background-color: #BF0000">Submit</button>
                    </div>
                  </form>
                </div>
            </div>
          </div>
        </div>

        @foreach ($abdimas_type as $at)
          <!-- Modal untuk edit data abdimas_type -->
          <div class="modal fade" id="editAbdimasType{{ $at->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                  <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">Edit Abdimas Type Data</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <form action="{{ route('abdimas_type.update', ['id' => $at->id]) }}" method="post" enctype="">
                      @csrf               
                      @method('put')       
                      <div class="mb-3">
                          <label for="" class="form-label">Name :</label>
                          <input type="text" class="form-control" name="name" value="{{ $at->name }}">
                          <div class="invalid-feedback">@error('name') {{ $message }} @enderror</div>
                      </div>
                      <div class="d-grid mb-3">
                          <button type="submit" class="btn text-white" style="background-color: #BF0000">Update</button>
                      </div>
                    </form>
                  </div>
              </div>
            </div>
          </div>
        @endforeach

        <script>
          $(document).ready( function () {
              $('#table_abdimas_type').DataTable();
          } );
      </script>

    </body>
</html>