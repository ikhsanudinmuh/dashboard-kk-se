<?php

namespace App\Http\Controllers;

use App\Models\JournalAccreditation;
use App\Models\Lab;
use App\Models\Publication;
use App\Models\PublicationType;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PublicationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //ambil data penulis
        $author = User::where('role', 'lecturer')
            ->where('code', '!=', null)
            ->orderBy('name')
            ->get();

        //ambil data tipe publikasi            
        $publication_type = PublicationType::all();

        //ambil data tipe akreditasi jurnal
        $journal_accreditation = JournalAccreditation::all();

        //ambil data lab
        $lab = Lab::all();

        //ambil data publikasi
        $publication = DB::table('publications')
            ->leftJoin('users as a1', 'publications.author_1_id', '=', 'a1.id')
            ->leftJoin('users as a2', 'publications.author_2_id', '=', 'a2.id')
            ->leftJoin('users as a3', 'publications.author_3_id', '=', 'a3.id')
            ->leftJoin('users as a4', 'publications.author_4_id', '=', 'a4.id')
            ->leftJoin('users as a5', 'publications.author_5_id', '=', 'a5.id')
            ->leftJoin('users as a6', 'publications.author_6_id', '=', 'a6.id')
            ->leftJoin('labs', 'publications.lab_id' , '=', 'labs.id')
            ->leftJoin('publication_types', 'publications.publication_type_id' , '=', 'publication_types.id')
            ->leftJoin('journal_accreditations', 'publications.journal_accreditation_id' , '=', 'journal_accreditations.id')
            ->select(
                'publications.*',
                'a1.name as author1',
                'a2.name as author2',
                'a3.name as author3',
                'a4.name as author4',
                'a5.name as author5',
                'a6.name as author6',
                'labs.name as lab_name',
                'publication_types.name as publication_type',
                'journal_accreditations.name as journal_accreditation',
            )
            ->get();

        return view('publication.index', [
            'author' => $author, 
            'publication' => $publication,
            'publication_type' => $publication_type,
            'journal_accreditation' => $journal_accreditation,
            'lab' => $lab,
        ]);
    }

    public function publicationPerYear()
    {
        //menampilkan banyaknya data publikasi berdasarkan tahun
        $data = DB::table('publications')
            ->select('year', DB::raw('count(*) as total'))
            ->groupBy('year')
            ->get();

        return response()->json($data);
    }

    public function publicationPerAuthor()
    {
        //mencari user yang memiliki role lecturer
        $lecturer = User::where('role', 'lecturer')
            ->get();

        //membuat variabel baru bernama response
        $response = [];

        //menghitung banyaknya data publikasi berdasarkan author
        foreach ($lecturer as $author) {
            $count = DB::table('publications')
                ->where('publications.author_1_id', $author->id)
                ->orWhere('publications.author_2_id', $author->id)
                ->orWhere('publications.author_3_id', $author->id)
                ->orWhere('publications.author_4_id', $author->id)
                ->orWhere('publications.author_5_id', $author->id)
                ->orWhere('publications.author_6_id', $author->id)
                ->select(
                    DB::raw('count(*) as total')
                )
                ->get();
                
            array_push($response, [
                'code' => $author->code, 
                'total' => $count[0]->total,
            ]);
        }
        
        return response()->json($response);
    }

    public function publicationPerAuthorPerYear($id)
    {
        //mencari data user berdasarkan id
        $lecturer = User::where('id', $id)
            ->get();

        //membuat variabel baru bernama response
        $response = [];

        //menghitung banyaknya publikasi berdasarkan author dan tahun
        foreach ($lecturer as $author) {
            $data = DB::table('publications')
                ->where('publications.author_1_id', $author->id)
                ->orWhere('publications.author_2_id', $author->id)
                ->orWhere('publications.author_3_id', $author->id)
                ->orWhere('publications.author_4_id', $author->id)
                ->orWhere('publications.author_5_id', $author->id)
                ->orWhere('publications.author_6_id', $author->id)
                ->select(
                    'year',
                    DB::raw('count(*) as total')
                )
                ->groupBy('year')
                ->get();
                
            array_push($response, [
                'code' => $author->code, 
                'publications' => $data,
            ]);
        }
        
        return response()->json($response);
    }

    public function publicationType() 
    {
        //menampilkan banyaknya data publikasi berdasarkan tipe publikasi
        $data = DB::table('publications')
            ->leftJoin('publication_types', 'publications.publication_type_id', '=', 'publication_types.id')
            ->select('publication_types.name as pt_name', DB::raw('count(*) as total'))
            ->groupBy('publication_types.name')
            ->get();

        return response()->json($data);
    }

    public function journalAccreditation() 
    {
        //menampilkan banyaknya data publikasi berdasarkan akreditasi jurnal
        $data = DB::table('publications')
            ->leftJoin('journal_accreditations', 'publications.journal_accreditation_id', '=', 'journal_accreditations.id')
            ->select('journal_accreditations.name as ja_name', DB::raw('count(*) as total'))
            ->groupBy('journal_accreditations.name')
            ->get();

        return response()->json($data);
    }

    public function stats($view) 
    {
        //menampilkan halaman statistik berdasarkan view
        if ($view == 'per_year') {
            return view('publication.stats_per_year');
        } else if($view == 'per_publication_type') {
            return view('publication.stats_per_publication_type');
        } else if($view == 'per_journal_accreditation') {
            return view('publication.stats_per_journal_accreditation');
        } else if($view == 'per_author') {
            return view('publication.stats_per_author');         
        } else if($view == 'per_author_per_year') {
            $author = User::where('role', 'lecturer')
                ->get();
            return view('publication.stats_per_author_per_year', ['author' => $author]);           
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //validasi input user
        $data = $request->validate([
            'year' => 'required|numeric',
            'author_1_id' => 'required|numeric',
            'lab_id' => 'required|numeric',
            'title' => 'required|string',
            'publication_type_id' => 'required|numeric',
            'journal_conference' => 'required|string',
            'journal_accreditation_id' => 'required|numeric',
            'link' => 'required',
            'publication_file' => 'mimes:pdf',
        ]);

        //membuat data publikasi baru
        $publication = new Publication();
        $publication->year = $request->year;
        $publication->author_1_id = $request->author_1_id;
        $publication->author_2_id = $request->author_2_id != '' ? $request->author_2_id : null;
        $publication->author_3_id = $request->author_3_id != '' ? $request->author_3_id : null;
        $publication->author_4_id = $request->author_4_id != '' ? $request->author_4_id : null;
        $publication->author_5_id = $request->author_5_id != '' ? $request->author_5_id : null;
        $publication->author_6_id = $request->author_6_id != '' ? $request->author_6_id : null;
        $publication->lab_id = $request->lab_id;
        $publication->partner_institution = $request->partner_institution != '' ? $request->partner_institution : null;
        $publication->title = $request->title;
        $publication->publication_type_id = $request->publication_type_id;
        $publication->journal_conference = $request->journal_conference;
        $publication->journal_accreditation_id = $request->journal_accreditation_id;
        $publication->link = $request->link;

        //validasi jika ada file yang diupload dan memindahkannya ke folder public
        if ($request->hasFile('publication_file')) {
            $file = 'publication_' . time() . '.' . $request->file('publication_file')->extension();

            $request->publication_file->move(public_path('publication_file'), $file);
            $publication->publication_file = $file;
        } else {
            $publication->publication_file = null;
        }


        try {
            //menyimpan data publikasi
            $publication->save();

            return redirect('/publication')->with('success', 'Successfully added publication data');

        } catch (\Exception $e) {
            return $e->getMessage();
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function manage()
    {
        //validasi user telah login
        if (Auth::check() == TRUE) {
            //validasi user yang login adalah admin
            if (Auth::user()->role == 'admin') {
                //ambil data penulis
                $author = User::where('role', 'lecturer')
                ->where('code', '!=', null)
                ->orderBy('name')
                ->get();

                //ambil data tipe publikasi            
                $publication_type = PublicationType::all();

                //ambil data tipe akreditasi jurnal
                $journal_accreditation = JournalAccreditation::all();

                //ambil data lab
                $lab = Lab::all();

                //ambil data publikasi
                $publication = DB::table('publications')
                    ->leftJoin('users as a1', 'publications.author_1_id', '=', 'a1.id')
                    ->leftJoin('users as a2', 'publications.author_2_id', '=', 'a2.id')
                    ->leftJoin('users as a3', 'publications.author_3_id', '=', 'a3.id')
                    ->leftJoin('users as a4', 'publications.author_4_id', '=', 'a4.id')
                    ->leftJoin('users as a5', 'publications.author_5_id', '=', 'a5.id')
                    ->leftJoin('users as a6', 'publications.author_6_id', '=', 'a6.id')
                    ->leftJoin('labs', 'publications.lab_id' , '=', 'labs.id')
                    ->leftJoin('publication_types', 'publications.publication_type_id' , '=', 'publication_types.id')
                    ->leftJoin('journal_accreditations', 'publications.journal_accreditation_id' , '=', 'journal_accreditations.id')
                    ->select(
                        'publications.*',
                        'a1.name as author1',
                        'a2.name as author2',
                        'a3.name as author3',
                        'a4.name as author4',
                        'a5.name as author5',
                        'a6.name as author6',
                        'labs.name as lab_name',
                        'publication_types.name as publication_type',
                        'journal_accreditations.name as journal_accreditation',
                    )
                    ->get();

                return view('publication.manage', [
                    'author' => $author, 
                    'publication' => $publication,
                    'publication_type' => $publication_type,
                    'journal_accreditation' => $journal_accreditation,
                    'lab' => $lab,
                ]);
            }
        } 

        return view('auth.unauthorized');   
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //validasi input user
        $data = $request->validate([
            'year' => 'required|numeric',
            'author_1_id' => 'required|numeric',
            'lab_id' => 'required|numeric',
            'title' => 'required|string',
            'publication_type_id' => 'required|numeric',
            'journal_conference' => 'required|string',
            'journal_accreditation_id' => 'required|numeric',
            'link' => 'required',
            'publication_file' => 'mimes:pdf',
        ]);

        //mencari data publikasi berdasarkan id, dan menerima input baru
        $publication = Publication::findOrFail($id);

        $publication->year = $request->year;
        $publication->author_1_id = $request->author_1_id;
        $publication->author_2_id = $request->author_2_id != '' ? $request->author_2_id : null;
        $publication->author_3_id = $request->author_3_id != '' ? $request->author_3_id : null;
        $publication->author_4_id = $request->author_4_id != '' ? $request->author_4_id : null;
        $publication->author_5_id = $request->author_5_id != '' ? $request->author_5_id : null;
        $publication->author_6_id = $request->author_6_id != '' ? $request->author_6_id : null;
        $publication->lab_id = $request->lab_id;
        $publication->partner_institution = $request->partner_institution != '' ? $request->partner_institution : null;
        $publication->title = $request->title;
        $publication->publication_type_id = $request->publication_type_id;
        $publication->journal_conference = $request->journal_conference;
        $publication->journal_accreditation_id = $request->journal_accreditation_id;
        $publication->link = $request->link;

        //validasi jika ada file baru
        if ($request->hasFile('publication_file')) {
            $file = 'publication_' . time() . '.' . $request->file('publication_file')->extension();

            $request->publication_file->move(public_path('publication_file'), $file);
            $publication->publication_file = $file;
        }

        try {
            //menyimpan data publikasi
            $publication->save();

            return redirect('/publication/manage')->with('success', 'Successfully update publication data');

        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //mencari data publikasi berdasarkan id
        $publication = Publication::find($id);
        //menghapus data publikasi
        $publication->delete();

        return redirect('/publication/manage')->with('success', 'Successfully delete publication data');
    }
}
