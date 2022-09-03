@include('layouts.header')
        <title>Manage User | {{ env('APP_NAME') }}</title>    

        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.css">  
        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.js"></script>
        <script src="https://kit.fontawesome.com/c2640fba80.js" crossorigin="anonymous"></script>
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
            <h3>User Data</h3>
          </div>

          <table id="table_user" class="display">
            <thead>
              <tr>
                  <th>Name</th>
                  <th>Code</th>
                  <th>Role</th>
                  <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($user as $u)
                <tr>
                    <td>{{ $u->name }}</td>
                    <td>{{ $u->code }}</td>
                    <td>{{ $u->role }}</td>
                    <td>
                      <div class="d-flex">
                        <button type="button" class="btn btn-warning me-1" data-bs-toggle="modal" data-bs-target="#editUser{{ $u->id }}">
                          <i class="fa-solid fa-pen-to-square"></i>
                        </button>
                        <form action="{{ route('user.destroy', [$u->id]) }}" method="POST">
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

        @foreach ($user as $u)
          <!-- Modal untuk edit data user -->
          <div class="modal fade" id="editUser{{ $u->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                  <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">Edit User Data</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <form action="{{ route('user.update', ['id' => $u->id]) }}" method="post" enctype="">
                      @csrf               
                      @method('put')       
                      <div class="mb-3">
                          <label for="" class="form-label">Name :</label>
                          <input type="text" class="form-control" name="name" value="{{ $u->name }}" disabled>
                          <div class="invalid-feedback">@error('name') {{ $message }} @enderror</div>
                      </div>
                      <div class="mb-3">
                          <label for="" class="form-label">Code :</label>
                          <input type="text" class="form-control" name="code" value="{{ $u->code }}">
                          <div class="invalid-feedback">@error('code') {{ $message }} @enderror</div>
                      </div>
                      <div class="mb-3">
                          <label for="" class="form-label">Role :</label>
                          <select name="role" id="" class="form-select">
                            @if ($u->role == 'user')
                              <option value="user" selected>User</option>
                              <option value="lecturer">Lecturer</option>
                              <option value="admin">Admin</option>      
                            @elseif ($u->role == 'lecturer')                                      
                              <option value="user">User</option>
                              <option value="lecturer" selected>Lecturer</option>
                              <option value="admin">Admin</option>            
                            @elseif ($u->role == 'admin')                                      
                              <option value="user">User</option>
                              <option value="lecturer">Lecturer</option>
                              <option value="admin" selected>Admin</option>          
                            @endif
                          </select>
                          <div class="invalid-feedback">@error('role') {{ $message }} @enderror</div>
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
              $('#table_user').DataTable();
          } );
      </script>

    </body>
</html>