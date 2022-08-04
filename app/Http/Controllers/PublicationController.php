<?php

namespace App\Http\Controllers;

use App\Models\Publication;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PublicationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $writer = User::where('role', 'lecturer')
                    ->orderBy('name')
                    ->get();

        $publication = DB::table('publications')->get();

        return view('publication.index', ['writer' => $writer, 'publication' => $publication]);
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
            'writer_1_id' => 'required|numeric',
            'lab' => 'required|string',
            'title' => 'required|string',
            'type' => 'required|string',
            'journal_conference' => 'required|string',
            'journal_accreditation' => 'required|string',
            'link' => 'required',
            'publication_file' => 'mimes:pdf',
        ]);

        $publication = new Publication();
        $publication->year = $data['year'];
        $publication->writer_1_id = $data['writer_1_id'];
        $publication->writer_2_id = $request->writer_2_id != '' ? $request->writer_2_id : null;
        $publication->writer_3_id = $request->writer_3_id != '' ? $request->writer_3_id : null;
        $publication->writer_4_id = $request->writer_4_id != '' ? $request->writer_4_id : null;
        $publication->writer_5_id = $request->writer_5_id != '' ? $request->writer_5_id : null;
        $publication->writer_6_id = $request->writer_6_id != '' ? $request->writer_6_id : null;
        $publication->lab = $data['lab'];
        $publication->partner_institution = $request->partner_institution != '' ? $request->partner_institution : null;
        $publication->title = $data['title'];
        $publication->type = $data['type'];
        $publication->journal_conference = $data['journal_conference'];
        $publication->journal_accreditation = $data['journal_accreditation'];
        $publication->link = $data['link'];

        if ($request->hasFile('publication_file')) {
            $file = 'publication_' . time() . $request->file('publication_file')->extension();

            $request->publication_file->move(public_path('publication_file'), $file);
            $publication->publication_file = $file;
        }

        
        $publication->save();
        
        return redirect('/publication')->with('success', 'Successfully added publication data');
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
