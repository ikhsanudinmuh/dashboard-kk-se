<?php

namespace App\Http\Controllers;

use App\Models\PublicationType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PublicationTypeController extends Controller
{
    public function index()
    {
        if (Auth::check() == TRUE) {
            if (Auth::user()->role == 'admin') {
                $publication_type = PublicationType::all();
    
                return view('admin.manage_publication_type', ['publication_type' => $publication_type]);
            }
        } 
    
        return view('auth.unauthorized');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'string|unique:publication_types,name',
        ]);

        $publication_type = new PublicationType;

        $publication_type->name = $data['name'];
        
        $publication_type->save();

        return redirect('/publication_type/manage')->with('success', 'Successfully add data');
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name' => 'string|unique:publication_types,name',
        ]);

        $publication_type = PublicationType::findOrFail($id);

        $publication_type->name = $data['name'];
        
        $publication_type->save();

        return redirect('/publication_type/manage')->with('success', 'Successfully update data');
    }

    public function destroy($id)
    {
        $publication_type = PublicationType::find($id);
        $publication_type->delete();

        return redirect('/publication_type/manage')->with('success', 'Successfully delete data');
    }
}
