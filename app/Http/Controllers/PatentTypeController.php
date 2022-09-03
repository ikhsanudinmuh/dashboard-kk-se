<?php

namespace App\Http\Controllers;

use App\Models\PatentType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PatentTypeController extends Controller
{
    public function index()
    {
        if (Auth::check() == TRUE) {
            if (Auth::user()->role == 'admin') {
                $patent_type = PatentType::all();
    
                return view('admin.manage_patent_type', ['patent_type' => $patent_type]);
            }
        } 
    
        return view('auth.unauthorized');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'string|unique:patent_types,name',
        ]);

        $patent_type = new PatentType;

        $patent_type->name = $data['name'];
        
        $patent_type->save();

        return redirect('/patent_type/manage')->with('success', 'Successfully add data');
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name' => 'string|unique:patent_types,name',
        ]);

        $patent_type = PatentType::findOrFail($id);

        $patent_type->name = $data['name'];
        
        $patent_type->save();

        return redirect('/patent_type/manage')->with('success', 'Successfully update data');
    }

    public function destroy($id)
    {
        $patent_type = PatentType::find($id);
        $patent_type->delete();

        return redirect('/patent_type/manage')->with('success', 'Successfully delete data');
    }
}
