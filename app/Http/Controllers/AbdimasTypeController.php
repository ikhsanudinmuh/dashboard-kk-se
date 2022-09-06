<?php

namespace App\Http\Controllers;

use App\Models\AbdimasType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AbdimasTypeController extends Controller
{
    public function index()
    {
        //validasi user telah login
        if (Auth::check() == TRUE) {
            //validasi user yang login adalah admin
            if (Auth::user()->role == 'admin') {
                //menampikan data tipe abdimas
                $abdimas_type = AbdimasType::all();
    
                return view('admin.manage_abdimas_type', ['abdimas_type' => $abdimas_type]);
            }
        } 
    
        return view('auth.unauthorized');
    }

    public function store(Request $request)
    {
        //validasi input user
        $data = $request->validate([
            'name' => 'string|unique:abdimas_types,name',
        ]);

        //membuat data tipe abdimas baru
        $abdimas_type = new AbdimasType;

        $abdimas_type->name = $data['name'];
        
        //menyimpan data tipe abdimas baru
        $abdimas_type->save();

        return redirect('/abdimas_type/manage')->with('success', 'Successfully add data');
    }

    public function update(Request $request, $id)
    {
        //validasi input user
        $data = $request->validate([
            'name' => 'string|unique:abdimas_types,name',
        ]);

        //mencari data tipe abdimas berdasarkan id
        $abdimas_type = AbdimasType::findOrFail($id);

        $abdimas_type->name = $data['name'];
        
        //mengubah data tipe abdimas baru
        $abdimas_type->save();

        return redirect('/abdimas_type/manage')->with('success', 'Successfully update data');
    }

    public function destroy($id)
    {
        //mencari data tipe abdimas berdasarkan id
        $abdimas_type = AbdimasType::find($id);
        //menghapus data tipe abdimas berdasarkan id
        $abdimas_type->delete();

        return redirect('/abdimas_type/manage')->with('success', 'Successfully delete data');
    }
}
