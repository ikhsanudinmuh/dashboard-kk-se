<?php

namespace App\Http\Controllers;

use App\Models\PatentType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PatentTypeController extends Controller
{
    public function index()
    {
        //validasi user telah login
        if (Auth::check() == TRUE) {
            //validasi user yang login adalah admin
            if (Auth::user()->role == 'admin') {
                //menampilkan data jenis paten
                $patent_type = PatentType::all();
    
                return view('admin.manage_patent_type', ['patent_type' => $patent_type]);
            }
        } 
    
        return view('auth.unauthorized');
    }

    public function store(Request $request)
    {
        //validasi input user
        $data = $request->validate([
            'name' => 'string|unique:patent_types,name',
        ]);

        //membuat data jenis paten baru
        $patent_type = new PatentType;

        $patent_type->name = $data['name'];
        
        //menyimpan data jenis paten
        $patent_type->save();

        return redirect('/patent_type/manage')->with('success', 'Successfully add data');
    }

    public function update(Request $request, $id)
    {
        //validasi input user
        $data = $request->validate([
            'name' => 'string|unique:patent_types,name',
        ]);

        //mencari data jenis paten berdasarkan id
        $patent_type = PatentType::findOrFail($id);

        $patent_type->name = $data['name'];
        
        //menyimpan data jenis paten
        $patent_type->save();

        return redirect('/patent_type/manage')->with('success', 'Successfully update data');
    }

    public function destroy($id)
    {
        //mencari data jenis paten berdasarkan id
        $patent_type = PatentType::find($id);
        //menghapus data jenis paten
        $patent_type->delete();

        return redirect('/patent_type/manage')->with('success', 'Successfully delete data');
    }
}
