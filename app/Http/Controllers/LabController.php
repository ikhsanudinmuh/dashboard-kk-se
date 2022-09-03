<?php

namespace App\Http\Controllers;

use App\Models\Lab;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LabController extends Controller
{
    public function index()
    {
        if (Auth::check() == TRUE) {
            if (Auth::user()->role == 'admin') {
                $lab = Lab::all();
    
                return view('admin.manage_lab', ['lab' => $lab]);
            }
        } 
    
        return view('auth.unauthorized');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'string|unique:labs,name',
        ]);

        $lab = new Lab;

        $lab->name = $data['name'];
        
        $lab->save();

        return redirect('/lab/manage')->with('success', 'Successfully add data');
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name' => 'string|unique:labs,name',
        ]);

        $lab = Lab::findOrFail($id);

        $lab->name = $data['name'];
        
        $lab->save();

        return redirect('/lab/manage')->with('success', 'Successfully update data');
    }

    public function destroy($id)
    {
        $lab = Lab::find($id);
        $lab->delete();

        return redirect('/lab/manage')->with('success', 'Successfully delete data');
    }
}
