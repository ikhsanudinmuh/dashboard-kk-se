<?php

namespace App\Http\Controllers;

use App\Models\ResearchType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ResearchTypeController extends Controller
{
    public function index()
    {
        if (Auth::check() == TRUE) {
            if (Auth::user()->role == 'admin') {
                $research_type = ResearchType::all();
    
                return view('admin.manage_research_type', ['research_type' => $research_type]);
            }
        } 
    
        return view('auth.unauthorized');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'string|unique:research_types,name',
        ]);

        $research_type = new ResearchType;

        $research_type->name = $data['name'];
        
        $research_type->save();

        return redirect('/research_type/manage')->with('success', 'Successfully add data');
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name' => 'string|unique:research_types,name',
        ]);

        $research_type = ResearchType::findOrFail($id);

        $research_type->name = $data['name'];
        
        $research_type->save();

        return redirect('/research_type/manage')->with('success', 'Successfully update data');
    }

    public function destroy($id)
    {
        $research_type = ResearchType::find($id);
        $research_type->delete();

        return redirect('/research_type/manage')->with('success', 'Successfully delete data');
    }
}
