<?php

namespace App\Http\Controllers;

use App\Models\JournalAccreditation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JournalAccreditationController extends Controller
{
    public function index()
    {
        //validasi user telah login
        if (Auth::check() == TRUE) {
            //validasi user yang login
            if (Auth::user()->role == 'admin') {
                //menampilkan data akreditasi jurnal
                $journal_accreditation = JournalAccreditation::all();
    
                return view('admin.manage_journal_accreditation', ['journal_accreditation' => $journal_accreditation]);
            }
        } 
    
        return view('auth.unauthorized');
    }

    public function store(Request $request)
    {
        //validasi input user
        $data = $request->validate([
            'name' => 'string|unique:journal_accreditations,name',
        ]);

        //membuat data akreditasi jurnal baru
        $journal_accreditation = new JournalAccreditation;

        $journal_accreditation->name = $data['name'];
        
        //menyimpan data akreditasi jurnal
        $journal_accreditation->save();

        return redirect('/journal_accreditation/manage')->with('success', 'Successfully add data');
    }

    public function update(Request $request, $id)
    {
        //validasi input user
        $data = $request->validate([
            'name' => 'string|unique:journal_accreditations,name',
        ]);

        //mencari data akreditasi jurnal berdasarkan id
        $journal_accreditation = JournalAccreditation::findOrFail($id);

        $journal_accreditation->name = $data['name'];
        
        //mengubah data akreditasi jurnal
        $journal_accreditation->save();

        return redirect('/journal_accreditation/manage')->with('success', 'Successfully update data');
    }

    public function destroy($id)
    {
        //mencari data akreditasi jurnal berdasarkan id
        $journal_accreditation = JournalAccreditation::find($id);
        //menghapus data akreditasi jurnal
        $journal_accreditation->delete();

        return redirect('/journal_accreditation/manage')->with('success', 'Successfully delete data');
    }
}
