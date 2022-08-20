@include('layouts.header')
        <title>Publications | Dashboard</title>    

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
                <h3>Publication Data</h3>
            </div>
            @if (Auth::check() == TRUE  && Auth::user()->role == 'lecturer' || Auth::user()->role == 'admin')
                <div class="mb-3">
                    <button type="button" class="btn text-white" data-bs-toggle="modal" data-bs-target="#addData" style="background-color: #BF0000">
                        Add Data
                    </button>
                </div>                
            @endif
            <div class="mb-3">
                <table id="table_publication" class="display">
                    <thead>
                        <tr>
                            <th>Year</th>
                            <th>Title</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($publication as $p)
                            <tr>
                                <td>{{ $p->year }}</td>
                                <td>{{ $p->title }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Add Publication Data Modal -->
        <div class="modal fade" id="addData" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Publication Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('publication.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="" class="form-label">Year(YYYY) :</label>
                            <input type="text" class="form-control @error('year') is-invalid @enderror" id="" name="year">
                            <div class="invalid-feedback">@error('year') {{ $message }} @enderror</div>
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Author 1 :</label>
                            <select class="form-select @error('author_1_id') is-invalid @enderror" name="author_1_id">
                                @foreach ($author as $a)
                                    <option value="" selected>Please select</option>
                                    <option value={{ $a->id }}>{{ $a->name . ' - ' . $a->code }}</option>                                    
                                @endforeach
                            </select>
                            <div class="invalid-feedback">@error('author_1_id') {{ $message }} @enderror</div>
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Author 2(Optional) :</label>
                            <select class="form-select @error('author_2_id') is-invalid @enderror" name="author_2_id">
                                @foreach ($author as $a)
                                    <option value="" selected>Please select</option>
                                    <option value={{ $a->id }}>{{ $a->name . ' - ' . $a->code }}</option>                                    
                                @endforeach
                            </select>
                            <div class="invalid-feedback">@error('author_2_id') {{ $message }} @enderror</div>
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Author 3(Optional) :</label>
                            <select class="form-select @error('author_3_id') is-invalid @enderror" name="author_3_id">
                                @foreach ($author as $a)
                                    <option value="" selected>Please select</option>
                                    <option value={{ $a->id }}>{{ $a->name . ' - ' . $a->code }}</option>                                    
                                @endforeach
                            </select>
                            <div class="invalid-feedback">@error('author_3_id') {{ $message }} @enderror</div>
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Author 4(Optional) :</label>
                            <select class="form-select @error('author_4_id') is-invalid @enderror" name="author_4_id">
                                @foreach ($author as $a)
                                    <option value="" selected>Please select</option>
                                    <option value={{ $a->id }}>{{ $a->name . ' - ' . $a->code }}</option>                                    
                                @endforeach
                            </select>
                            <div class="invalid-feedback">@error('author_4_id') {{ $message }} @enderror</div>
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Author 5(Optional) :</label>
                            <select class="form-select @error('author_5_id') is-invalid @enderror" name="author_5_id">
                                @foreach ($author as $a)
                                    <option value="" selected>Please select</option>
                                    <option value={{ $a->id }}>{{ $a->name . ' - ' . $a->code }}</option>                                    
                                @endforeach
                            </select>
                            <div class="invalid-feedback">@error('author_5_id') {{ $message }} @enderror</div>
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Author 6(Optional) :</label>
                            <select class="form-select @error('author_6_id') is-invalid @enderror" name="author_6_id">
                                @foreach ($author as $a)
                                    <option value="" selected>Please select</option>
                                    <option value={{ $a->id }}>{{ $a->name . ' - ' . $a->code }}</option>                                    
                                @endforeach
                            </select>
                            <div class="invalid-feedback">@error('author_6_id') {{ $message }} @enderror</div>
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Research Lab :</label>
                            <input type="text" class="form-control @error('lab') is-invalid @enderror" id="" name="lab">
                            <div class="invalid-feedback">@error('lab') {{ $message }} @enderror</div>
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Partner Institution(Optional) :</label>
                            <textarea name="partner_institution" class="form-control @error('partner_instition') is-invalid @enderror" cols="30" rows="3"></textarea>
                            <div class="invalid-feedback">@error('partner_institution') {{ $message }} @enderror</div>
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Title :</label>
                            <textarea name="title" class="form-control @error('title') is-invalid @enderror" cols="30" rows="3"></textarea>
                            <div class="invalid-feedback">@error('title') {{ $message }} @enderror</div>
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Publication Type :</label>
                            <select class="form-select @error('publication_type_id') is-invalid @enderror" name="publication_type_id">
                                @foreach ($publication_type as $pt)
                                    <option value={{ $pt->id }}>{{ $pt->name }}</option>                               
                                @endforeach
                            </select>
                            <div class="invalid-feedback">@error('publication_type_id') {{ $message }} @enderror</div>
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Journal/Conference :</label>
                            <textarea name="journal_conference" class="form-control @error('journal_conference') is-invalid @enderror" cols="30" rows="3"></textarea>
                            <div class="invalid-feedback">@error('journal_conference') {{ $message }} @enderror</div>
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Journal Accreditation :</label>
                            <select class="form-select @error('journal_accreditation_id') is-invalid @enderror" name="journal_accreditation_id">
                                @foreach ($journal_accreditation as $ja)
                                    <option value={{ $ja->id }}>{{ $ja->name }}</option>                               
                                @endforeach
                            </select>
                            <div class="invalid-feedback">@error('journal_accreditation_id') {{ $message }} @enderror</div>
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Link :</label>
                            <input type="text" class="form-control @error('link') is-invalid @enderror" id="" name="link">
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

        <script>
            $(document).ready( function () {
                $('#table_publication').DataTable();
            } );
        </script>
    </body>
</html>