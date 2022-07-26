<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        //validasi user telah login
        if (Auth::check() == TRUE) {
            //validasi user yang login adalah admin
            if (Auth::user()->role == 'admin') {
                $user = User::all();

                return view('admin.manage_user', ['user' => $user]);
            }
        } 

        return view('auth.unauthorized');
    }
    
    public function update(Request $request, $id)
    {
        //validasi input user
        $data = $request->validate([
            'code' => 'string',
        ]);

        //mencari user berdasarkan id
        $user = User::findOrFail($id);

        $user->code = $data['code'];
        $user->role = $request->role;
        
        //menyimpan data user
        $user->save();

        return redirect('/user/manage')->with('success', 'Successfully update data');
    }

    public function destroy($id)
    {
        //mencari data user berdasarkan id
        $user = User::find($id);
        //menghapus data user
        $user->delete();

        return redirect('/user/manage')->with('success', 'Successfully delete user data');
    }
}
