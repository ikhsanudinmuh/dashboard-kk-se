<?php

namespace App\Http\Controllers;

use App\Models\PublicationType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PublicationTypeController extends Controller
{
    public function index()
    {
        //validasi user telah login
        if (Auth::check() == TRUE) {
            //validasi user yang login adalah admin
            if (Auth::user()->role == 'admin') {
                //menampilkan data tipe publikasi
                $publication_type = PublicationType::all();
    
                return view('admin.manage_publication_type', ['publication_type' => $publication_type]);
            }
        } 
    
        return view('auth.unauthorized');
    }

    public function store(Request $request)
    {
        //validasi input user
        $data = $request->validate([
            'name' => 'string|unique:publication_types,name',
        ]);

        //membuat data tipe publikasi baru
        $publication_type = new PublicationType;

        $publication_type->name = $data['name'];
        
        //menyimpan data tipe publikasi
        $publication_type->save();

        return redirect('/publication_type/manage')->with('success', 'Successfully add data');
    }

    public function update(Request $request, $id)
    {
        //validasi input user
        $data = $request->validate([
            'name' => 'string|unique:publication_types,name',
        ]);

        //mencari data tipe publikasi berdasarkan id
        $publication_type = PublicationType::findOrFail($id);

        $publication_type->name = $data['name'];
        
        //menyimpan data tipe publikasi
        $publication_type->save();

        return redirect('/publication_type/manage')->with('success', 'Successfully update data');
    }

    public function destroy($id)
    {
        //mencari data tipe publikasi berdasarkan id
        $publication_type = PublicationType::find($id);
        //menghapus data tipe publikasi
        $publication_type->delete();

        return redirect('/publication_type/manage')->with('success', 'Successfully delete data');
    }
}
