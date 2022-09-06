<?php

namespace App\Http\Controllers;

use App\Models\Lab;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LabController extends Controller
{
    public function index()
    {
        //validasi user telah login
        if (Auth::check() == TRUE) {
            //validasi user yang login adalah admin
            if (Auth::user()->role == 'admin') {
                //menampilkan data lab
                $lab = Lab::all();
    
                return view('admin.manage_lab', ['lab' => $lab]);
            }
        } 
    
        return view('auth.unauthorized');
    }

    public function store(Request $request)
    {
        //validasi input user
        $data = $request->validate([
            'name' => 'string|unique:labs,name',
        ]);

        //membuat data lab baru
        $lab = new Lab;

        $lab->name = $data['name'];
        
        //menyimpan data lab
        $lab->save();

        return redirect('/lab/manage')->with('success', 'Successfully add data');
    }

    public function update(Request $request, $id)
    {
        //validasi input user
        $data = $request->validate([
            'name' => 'string|unique:labs,name',
        ]);

        //mencari data lab berdasarkan id
        $lab = Lab::findOrFail($id);

        $lab->name = $data['name'];
        
        //mengubah data lab
        $lab->save();

        return redirect('/lab/manage')->with('success', 'Successfully update data');
    }

    public function destroy($id)
    {
        //mencari data lab berdasarkan id
        $lab = Lab::find($id);
        //menghapus data lab
        $lab->delete();

        return redirect('/lab/manage')->with('success', 'Successfully delete data');
    }
}
