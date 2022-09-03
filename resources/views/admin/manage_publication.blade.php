@include('layouts.header')
        <title>Publications | {{ env('APP_NAME') }}</title>    

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
                <h3>Manage Publication Data</h3>
            </div>
            <div class="mb-3">
                <table id="table_publication" class="display">
                    <thead>
                        <tr>
                            <th>Year</th>
                            <th>Title</th>
                            <th>Journal/Conference</th>
                            <th>Link</th>
                            <th>Detail</th>
                            <th>File</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($publication as $p)
                            <tr>
                                <td>{{ $p->year }}</td>
                                <td>{{ $p->title }}</td>
                                <td>{{ $p->journal_conference }}</td>
                                <td><a href="{{ $p->link }}" target="_blank">Link</a></td>
                                <td>
                                    <button type="button" class="btn text-white" data-bs-toggle="modal" data-bs-target="#publicationdetail{{ $p->id }}" style="background-color: #BF0000">
                                        Detail
                                    </button>
                                </td>
                                <td>
                                    @if ($p->publication_file != null)
                                        <button type="button" class="btn text-white" data-bs-toggle="modal" data-bs-target="#publicationfile{{ $p->id }}" style="background-color: #BF0000">
                                            Open File
                                        </button>                                        
                                    @else
                                        No File
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex">
                                        <button type="button" class="btn btn-warning me-1" data-bs-toggle="modal" data-bs-target="#editPublication{{ $p->id }}">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </button>
                                        <form action="{{ route('publication.destroy', [$p->id]) }}" method="POST">
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

        @foreach ($publication as $p)
            <!-- Modal untuk lihat detail data publikasi -->
            <div class="modal fade" id="publicationdetail{{ $p->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">{{ $p->title }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <h6>Year : </h6>
                        {{ $p->year }}
                        <br><br>

                        <h6>Author : </h6>
                        {{ $p->author1 }}
                        @if ($p->author2 != NULL) , {{ $p->author2 }} @endif
                        @if ($p->author3 != NULL) , {{ $p->author3 }} @endif
                        @if ($p->author4 != NULL) , {{ $p->author4 }} @endif
                        @if ($p->author5 != NULL) , {{ $p->author5 }} @endif
                        @if ($p->author6 != NULL) , {{ $p->author6 }} @endif
                        <br><br>

                        <h6>Research Lab : </h6>
                        {{ $p->lab_name }}
                        <br><br>

                        <h6>Partner Institution : </h6>
                        @if ($p->partner_institution != NULL) {{ $p->partner_institution }} @endif
                        <br><br>

                        <h6>Publication Type : </h6>
                        {{ $p->publication_type }}
                        <br><br>

                        <h6>Journal/Conference : </h6>
                        {{ $p->journal_conference }}
                        <br><br>

                        <h6>Journal Accreditation : </h6>
                        {{ $p->journal_accreditation }}
                        <br><br>

                        <h6>Link : </h6>
                        <a href="{{ $p->link }}" target="_blank">Link</a>
                        <br><br>

                    </div>
                </div>
                </div>
            </div>            

            <!-- Modal untuk lihat pdf dari publikasi -->
            <div class="modal fade" id="publicationfile{{ $p->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">{{ $p->title }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        @if ($p->publication_file)
                            <iframe src="/publication_file/{{ $p->publication_file }}" align="top" height="620" width="100%" frameborder="0" scrolling="auto"></iframe>                            
                        @endif
                    </div>
                </div>
                </div>
            </div>            

            <!-- Modal untuk edit data publikasi -->
        <div class="modal fade" id="editPublication{{ $p->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Publication Data</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('publication.update', [$p->id]) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('put')
                            <div class="mb-3">
                                <label for="" class="form-label">Year(YYYY) :</label>
                                <input type="text" class="form-control @error('year') is-invalid @enderror" id="" name="year" value="{{ $p->year }}">
                                <div class="invalid-feedback">@error('year') {{ $message }} @enderror</div>
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Author 1 :</label>
                                <select class="form-select @error('author_1_id') is-invalid @enderror" name="author_1_id" >
                                    @foreach ($author as $a)
                                        @if ($a->id == $p->author_1_id)
                                            <option value={{ $a->id }} selected>{{ $a->name . ' - ' . $a->code }}</option>
                                        @else
                                            <option value={{ $a->id }}>{{ $a->name . ' - ' . $a->code }}</option>                                      
                                        @endif
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">@error('author_1_id') {{ $message }} @enderror</div>
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Author 2(Optional) :</label>
                                <select class="form-select @error('author_2_id') is-invalid @enderror" name="author_2_id">
                                    <option value="">Please select</option>
                                    @foreach ($author as $a)
                                        @if ($a->id == $p->author_2_id)
                                            <option value={{ $a->id }} selected>{{ $a->name . ' - ' . $a->code }}</option>
                                        @else
                                            <option value={{ $a->id }}>{{ $a->name . ' - ' . $a->code }}</option>                                      
                                        @endif
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">@error('author_2_id') {{ $message }} @enderror</div>
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Author 3(Optional) :</label>
                                <select class="form-select @error('author_3_id') is-invalid @enderror" name="author_3_id">
                                    <option value="">Please select</option>
                                    @foreach ($author as $a)
                                        @if ($a->id == $p->author_3_id)
                                            <option value={{ $a->id }} selected>{{ $a->name . ' - ' . $a->code }}</option>
                                        @else
                                            <option value={{ $a->id }}>{{ $a->name . ' - ' . $a->code }}</option>                                      
                                        @endif
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">@error('author_3_id') {{ $message }} @enderror</div>
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Author 4(Optional) :</label>
                                <select class="form-select @error('author_4_id') is-invalid @enderror" name="author_4_id">
                                    <option value="">Please select</option>
                                    @foreach ($author as $a)
                                        @if ($a->id == $p->author_4_id)
                                            <option value={{ $a->id }} selected>{{ $a->name . ' - ' . $a->code }}</option>
                                        @else
                                            <option value={{ $a->id }}>{{ $a->name . ' - ' . $a->code }}</option>                                      
                                        @endif
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">@error('author_4_id') {{ $message }} @enderror</div>
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Author 5(Optional) :</label>
                                <select class="form-select @error('author_5_id') is-invalid @enderror" name="author_5_id">
                                    <option value="">Please select</option>
                                    @foreach ($author as $a)
                                        @if ($a->id == $p->author_5_id)
                                            <option value={{ $a->id }} selected>{{ $a->name . ' - ' . $a->code }}</option>
                                        @else
                                            <option value={{ $a->id }}>{{ $a->name . ' - ' . $a->code }}</option>                                      
                                        @endif
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">@error('author_5_id') {{ $message }} @enderror</div>
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Author 6(Optional) :</label>
                                <select class="form-select @error('author_6_id') is-invalid @enderror" name="author_6_id">
                                    <option value="">Please select</option>
                                    @foreach ($author as $a)
                                        @if ($a->id == $p->author_6_id)
                                            <option value={{ $a->id }} selected>{{ $a->name . ' - ' . $a->code }}</option>
                                        @else
                                            <option value={{ $a->id }}>{{ $a->name . ' - ' . $a->code }}</option>                                      
                                        @endif
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">@error('author_6_id') {{ $message }} @enderror</div>
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Research Lab :</label>
                                <select class="form-select @error('lab_id') is-invalid @enderror" name="lab_id">
                                    @foreach ($lab as $l)
                                        @if ($l->id == $p->lab_id)
                                            <option value={{ $l->id }} selected>{{ $l->name }}</option>                               
                                        @else
                                            <option value={{ $l->id }}>{{ $l->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">@error('lab_id') {{ $message }} @enderror</div>
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Partner Institution(Optional) :</label>
                                <textarea name="partner_institution" class="form-control @error('partner_instition') is-invalid @enderror" cols="30" rows="3">@if ($p->partner_institution){{ $p->partner_institution }}@endif</textarea>
                                <div class="invalid-feedback">@error('partner_institution') {{ $message }} @enderror</div>
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Title :</label>
                                <textarea name="title" class="form-control @error('title') is-invalid @enderror" cols="30" rows="3">@if ($p->title){{ $p->title }}@endif</textarea>
                                <div class="invalid-feedback">@error('title') {{ $message }} @enderror</div>
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Publication Type :</label>
                                <select class="form-select @error('publication_type_id') is-invalid @enderror" name="publication_type_id">
                                    @foreach ($publication_type as $pt)
                                        @if ($pt->id == $p->publication_type_id)
                                            <option value={{ $pt->id }} selected>{{ $pt->name }}</option>                                            
                                        @else
                                            <option value={{ $pt->id }}>{{ $pt->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">@error('publication_type_id') {{ $message }} @enderror</div>
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Journal/Conference :</label>
                                <textarea name="journal_conference" class="form-control @error('journal_conference') is-invalid @enderror" cols="30" rows="3">@if ($p->journal_conference){{ $p->journal_conference }}@endif</textarea>
                                <div class="invalid-feedback">@error('journal_conference') {{ $message }} @enderror</div>
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Journal Accreditation :</label>
                                <select class="form-select @error('journal_accreditation_id') is-invalid @enderror" name="journal_accreditation_id">
                                    @foreach ($journal_accreditation as $ja)
                                        @if ($ja->id == $p->journal_accreditation_id)
                                            <option value={{ $ja->id }} selected>{{ $ja->name }}</option>                                            
                                        @else
                                            <option value={{ $ja->id }}>{{ $ja->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">@error('journal_accreditation_id') {{ $message }} @enderror</div>
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Link :</label>
                                <input type="text" class="form-control @error('link') is-invalid @enderror" id="" name="link" value="{{ $p->link }}">
                                <div class="invalid-feedback">@error('link') {{ $message }} @enderror</div>
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">File(Optional) :</label>
                                <input type="file" class="form-control" name="publication_file">
                                <div class="invalid-feedback">@error('publication_file') {{ $message }} @enderror</div>
                            </div>
                            <div class="d-grid mb-3">
                                <button type="submit" class="btn text-white" style="background-color: #BF0000">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        @endforeach

        <script>
            $(document).ready( function () {
                $('#table_publication').DataTable();
            } );
        </script>
    </body>
</html>