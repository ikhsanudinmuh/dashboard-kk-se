{{-- file untuk menampilkan navbar --}}
  <nav class="navbar navbar-dark navbar-expand-lg" style="background-color: #BF0000;">
    <div class="container-fluid">
      <a class="navbar-brand" href="/"><img src="/assets/logo kk se.png" alt="" style="height: 50px"></a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav">
              <a class="nav-link" href="/publication">Publication</a>
              <a class="nav-link" href="/research">Research</a>
              <a class="nav-link" href="/hki">HKI</a>
              <a class="nav-link" href="/abdimas">Abdimas</a>
            </div>
        </div>
        <div class="d-flex flex-row-reverse">
            <div class="p-2">
                <div class="dropdown">
                  {{-- validasi user telah login --}}
                  @if (Auth::check() == TRUE)
                    <button class="btn btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                      {{-- menampilkan nama user yang login --}}
                      {{ Auth::user()->name }}
                    </button>
                    {{-- validasi jika user yang login adalah role user atau lecturer --}}
                    @if (Auth::user()->role == 'user' || Auth::user()->role == 'lecturer')
                      <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="/logout">Logout</a></li>
                      </ul>               
                    {{-- validasi jika user yang login adalah role admin --}}
                    @elseif (Auth::user()->role == 'admin')
                      <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="/user/manage">Manage User</a></li>
                        <li><a class="dropdown-item" href="/publication_type/manage">Manage Publication Type</a></li>
                        <li><a class="dropdown-item" href="/journal_accreditation/manage">Manage Journal Accreditation</a></li>
                        <li><a class="dropdown-item" href="/lab/manage">Manage Lab</a></li>
                        <li><a class="dropdown-item" href="/research_type/manage">Manage Research Type</a></li>
                        <li><a class="dropdown-item" href="/patent_type/manage">Manage Patent Type</a></li>
                        <li><a class="dropdown-item" href="/abdimas_type/manage">Manage Abdimas Type</a></li>
                        <li><a class="dropdown-item" href="/logout">Logout</a></li>
                      </ul>
                    @endif
                  {{-- jika user belum login, maka akan ditampilkan button login --}}
                  @else
                    <a class="btn btn-light" href="/login" role="button">Login</a>
                  @endif
                </div>
            </div>
        </div>
    </div>
  </nav>