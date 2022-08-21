<?php

namespace App\Http\Controllers;

use App\Models\Journal_accreditation;
use App\Models\Lab;
use App\Models\Publication;
use App\Models\Publication_type;
use App\Models\User;
use Illuminate\Http\Request;
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
            ->orderBy('name')
            ->get();

        //ambil data tipe publikasi            
        $publication_type = Publication_type::all();

        //ambil data tipe akreditasi jurnal
        $journal_accreditation = Journal_accreditation::all();

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

        // dd($publication);

        return view('publication.index', [
            'author' => $author, 
            'publication' => $publication,
            'publication_type' => $publication_type,
            'journal_accreditation' => $journal_accreditation,
            'lab' => $lab,
        ]);
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

        if ($request->hasFile('publication_file')) {
            $file = 'publication_' . time() . '.' . $request->file('publication_file')->extension();

            $request->publication_file->move(public_path('publication_file'), $file);
            $publication->publication_file = $file;
        } else {
            $publication->publication_file = null;
        }


        try {
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
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
