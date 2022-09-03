<?php

namespace App\Http\Controllers;

use App\Models\JournalAccreditation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JournalAccreditationController extends Controller
{
    public function index()
    {
        if (Auth::check() == TRUE) {
            if (Auth::user()->role == 'admin') {
                $journal_accreditation = JournalAccreditation::all();
    
                return view('admin.manage_journal_accreditation', ['journal_accreditation' => $journal_accreditation]);
            }
        } 
    
        return view('auth.unauthorized');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'string|unique:journal_accreditations,name',
        ]);

        $journal_accreditation = new JournalAccreditation;

        $journal_accreditation->name = $data['name'];
        
        $journal_accreditation->save();

        return redirect('/journal_accreditation/manage')->with('success', 'Successfully add data');
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name' => 'string|unique:journal_accreditations,name',
        ]);

        $journal_accreditation = JournalAccreditation::findOrFail($id);

        $journal_accreditation->name = $data['name'];
        
        $journal_accreditation->save();

        return redirect('/journal_accreditation/manage')->with('success', 'Successfully update data');
    }

    public function destroy($id)
    {
        $journal_accreditation = JournalAccreditation::find($id);
        $journal_accreditation->delete();

        return redirect('/journal_accreditation/manage')->with('success', 'Successfully delete data');
    }
}
