<?php

namespace App\Http\Controllers;

use App\Models\AbdimasType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AbdimasTypeController extends Controller
{
    public function index()
    {
        if (Auth::check() == TRUE) {
            if (Auth::user()->role == 'admin') {
                $abdimas_type = AbdimasType::all();
    
                return view('admin.manage_abdimas_type', ['abdimas_type' => $abdimas_type]);
            }
        } 
    
        return view('auth.unauthorized');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'string|unique:abdimas_types,name',
        ]);

        $abdimas_type = new AbdimasType;

        $abdimas_type->name = $data['name'];
        
        $abdimas_type->save();

        return redirect('/abdimas_type/manage')->with('success', 'Successfully add data');
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name' => 'string|unique:abdimas_types,name',
        ]);

        $abdimas_type = AbdimasType::findOrFail($id);

        $abdimas_type->name = $data['name'];
        
        $abdimas_type->save();

        return redirect('/abdimas_type/manage')->with('success', 'Successfully update data');
    }

    public function destroy($id)
    {
        $abdimas_type = AbdimasType::find($id);
        $abdimas_type->delete();

        return redirect('/abdimas_type/manage')->with('success', 'Successfully delete data');
    }
}
