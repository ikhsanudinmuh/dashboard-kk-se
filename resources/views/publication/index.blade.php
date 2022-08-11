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
            @if (Auth::check() == TRUE  && Auth::user()->role == 'lecturer')
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
                            <label for="" class="form-label">Writer 1 :</label>
                            <select class="form-select @error('writer_1_id') is-invalid @enderror" name="writer_1_id">
                                @foreach ($writer as $w)
                                    <option value="" selected>Please select</option>
                                    <option value={{ $w->id }}>{{ $w->name . ' - ' . $w->code }}</option>                                    
                                @endforeach
                            </select>
                            <div class="invalid-feedback">@error('writer_1_id') {{ $message }} @enderror</div>
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Writer 2(Optional) :</label>
                            <select class="form-select @error('writer_2_id') is-invalid @enderror" name="writer_2_id">
                                @foreach ($writer as $w)
                                    <option value="" selected>Please select</option>
                                    <option value={{ $w->id }}>{{ $w->name . ' - ' . $w->code }}</option>                                    
                                @endforeach
                            </select>
                            <div class="invalid-feedback">@error('writer_2_id') {{ $message }} @enderror</div>
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Writer 3(Optional) :</label>
                            <select class="form-select @error('writer_3_id') is-invalid @enderror" name="writer_3_id">
                                @foreach ($writer as $w)
                                    <option value="" selected>Please select</option>
                                    <option value={{ $w->id }}>{{ $w->name . ' - ' . $w->code }}</option>                                    
                                @endforeach
                            </select>
                            <div class="invalid-feedback">@error('writer_3_id') {{ $message }} @enderror</div>
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Writer 4(Optional) :</label>
                            <select class="form-select @error('writer_4_id') is-invalid @enderror" name="writer_4_id">
                                @foreach ($writer as $w)
                                    <option value="" selected>Please select</option>
                                    <option value={{ $w->id }}>{{ $w->name . ' - ' . $w->code }}</option>                                    
                                @endforeach
                            </select>
                            <div class="invalid-feedback">@error('writer_4_id') {{ $message }} @enderror</div>
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Writer 5(Optional) :</label>
                            <select class="form-select @error('writer_5_id') is-invalid @enderror" name="writer_5_id">
                                @foreach ($writer as $w)
                                    <option value="" selected>Please select</option>
                                    <option value={{ $w->id }}>{{ $w->name . ' - ' . $w->code }}</option>                                    
                                @endforeach
                            </select>
                            <div class="invalid-feedback">@error('writer_5_id') {{ $message }} @enderror</div>
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Writer 6(Optional) :</label>
                            <select class="form-select @error('writer_6_id') is-invalid @enderror" name="writer_6_id">
                                @foreach ($writer as $w)
                                    <option value="" selected>Please select</option>
                                    <option value={{ $w->id }}>{{ $w->name . ' - ' . $w->code }}</option>                                    
                                @endforeach
                            </select>
                            <div class="invalid-feedback">@error('writer_6_id') {{ $message }} @enderror</div>
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
                            <label for="" class="form-label">Type :</label>
                            <select class="form-select @error('type') is-invalid @enderror" name="type">
                                <option value="Jurnal Internasional">Jurnal Internasional</option>
                                <option value="Prosiding Internasional">Prosiding Internasional</option>
                            </select>
                            <div class="invalid-feedback">@error('type') {{ $message }} @enderror</div>
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Journal/Conference :</label>
                            <textarea name="journal_conference" class="form-control @error('journal_conference') is-invalid @enderror" cols="30" rows="3"></textarea>
                            <div class="invalid-feedback">@error('journal_conference') {{ $message }} @enderror</div>
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Journal Accreditation :</label>
                            <input type="text" class="form-control @error('journal_accreditation') is-invalid @enderror" id="" name="journal_accreditation">
                            <div class="invalid-feedback">@error('journal_accreditation') {{ $message }} @enderror</div>
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