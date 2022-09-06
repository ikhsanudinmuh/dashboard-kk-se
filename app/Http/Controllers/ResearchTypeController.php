<?php

namespace App\Http\Controllers;

use App\Models\ResearchType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ResearchTypeController extends Controller
{
    public function index()
    {
        //validasi user telah login
        if (Auth::check() == TRUE) {
            //validasi user yang login adalah admin
            if (Auth::user()->role == 'admin') {
                //menampilkan data tipe penelitian
                $research_type = ResearchType::all();
    
                return view('admin.manage_research_type', ['research_type' => $research_type]);
            }
        } 
    
        return view('auth.unauthorized');
    }

    public function store(Request $request)
    {
        //validasi input user
        $data = $request->validate([
            'name' => 'string|unique:research_types,name',
        ]);

        //membuat data tipe penelitian baru
        $research_type = new ResearchType;

        $research_type->name = $data['name'];
        
        //menyimpan data tipe penelitian
        $research_type->save();

        return redirect('/research_type/manage')->with('success', 'Successfully add data');
    }

    public function update(Request $request, $id)
    {
        //validasi input user
        $data = $request->validate([
            'name' => 'string|unique:research_types,name',
        ]);

        //mencari data tipe penelitian berdasarkan id
        $research_type = ResearchType::findOrFail($id);

        $research_type->name = $data['name'];
    
        //menyimpan data tipe penelitian
        $research_type->save();

        return redirect('/research_type/manage')->with('success', 'Successfully update data');
    }

    public function destroy($id)
    {
        //mencari data tipe penelitian berdasarkan id
        $research_type = ResearchType::find($id);
        //menghapus data tipe penelitian
        $research_type->delete();

        return redirect('/research_type/manage')->with('success', 'Successfully delete data');
    }
}
