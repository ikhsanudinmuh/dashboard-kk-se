<?php

namespace App\Http\Controllers;

use App\Models\Hki;
use App\Models\PatentType;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HkiController extends Controller
{
    public function index()
    {
        //ambil data anggota hki
        $member = User::where('role', 'lecturer')
            ->where('code', '!=', null)
            ->orderBy('name')
            ->get();
        
        //ambil data jenis paten
        $patent_type = PatentType::all();

        //ambil data hki
        $hki = DB::table('hkis')
            ->leftJoin('users as l', 'hkis.leader_id', 'l.id')
            ->leftJoin('users as m1', 'hkis.member_1_id', 'm1.id')
            ->leftJoin('users as m2', 'hkis.member_2_id', 'm2.id')
            ->leftJoin('users as m3', 'hkis.member_3_id', 'm3.id')
            ->leftJoin('patent_types', 'hkis.patent_type_id', 'patent_types.id')
            ->select(
                'hkis.*',
                'l.name as leader',
                'm1.name as member1',
                'm2.name as member2',
                'm3.name as member3',
                'patent_types.name as patent_type',
            )
            ->get();

        return view('hki.index', [
            'member' => $member, 
            'hki' => $hki,
            'patent_type' => $patent_type,
        ]);
    }

    public function store(Request $request)
    {
        //validasi input user
        $request->validate([
            'year' => 'required|numeric',
            'leader_id' => 'required|numeric',
            'patent_type_id' => 'required|numeric',
            'title' => 'required|string',
            'hki_file' => 'mimes:pdf',
        ]);

        //membuat data Hki baru, dan mengisi data berdasarkan input user
        $hki = new Hki();
        $hki->year = $request->year;
        $hki->leader_id = $request->leader_id;
        $hki->member_1_id = $request->member_1_id != '' ? $request->member_1_id : null;
        $hki->member_2_id = $request->member_2_id != '' ? $request->member_2_id : null;
        $hki->member_3_id = $request->member_3_id != '' ? $request->member_3_id : null;
        $hki->patent_type_id = $request->patent_type_id;
        $hki->creation_type = $request->creation_type != '' ? $request->creation_type : null;
        $hki->title = $request->title;
        $hki->description = $request->description != '' ? $request->description : null;
        $hki->registration_number = $request->registration_number != '' ? $request->registration_number : null;
        $hki->sertification_number = $request->sertification_number != '' ? $request->sertification_number : null;

        //validasi jika ada file yang diupload, lalu memindahkannya ke folder public
        if ($request->hasFile('hki_file')) {
            $file = 'hki_' . time() . '.' . $request->file('hki_file')->extension();

            $request->hki_file->move(public_path('hki_file'), $file);
            $hki->hki_file = $file;
        } else {
            $hki->hki_file = null;
        }

        //menyimpan data hki
        $hki->save();

        return redirect('/hki')->with('success', 'Successfully added hki data');
    }

    public function manage()
    {
        //validasi user telah login
        if (Auth::check() == TRUE) {
            //validasi user yang login adalah admin
            if (Auth::user()->role == 'admin') {
                //ambil data anggota hki
                $member = User::where('role', 'lecturer')
                ->where('code', '!=', null)
                ->orderBy('name')
                ->get();
                
                //ambil data jenis paten
                $patent_type = PatentType::all();

                //ambil data hki
                $hki = DB::table('hkis')
                    ->leftJoin('users as l', 'hkis.leader_id', 'l.id')
                    ->leftJoin('users as m1', 'hkis.member_1_id', 'm1.id')
                    ->leftJoin('users as m2', 'hkis.member_2_id', 'm2.id')
                    ->leftJoin('users as m3', 'hkis.member_3_id', 'm3.id')
                    ->leftJoin('patent_types', 'hkis.patent_type_id', 'patent_types.id')
                    ->select(
                        'hkis.*',
                        'l.name as leader',
                        'm1.name as member1',
                        'm2.name as member2',
                        'm3.name as member3',
                        'patent_types.name as patent_type',
                    )
                    ->get();

                return view('hki.manage', [
                    'member' => $member, 
                    'hki' => $hki,
                    'patent_type' => $patent_type,
                ]);
            }
        } 

        return view('auth.unauthorized');   
    }

    public function update(Request $request, $id)
    {
        //validasi input user
        $request->validate([
            'year' => 'required|numeric',
            'leader_id' => 'required|numeric',
            'patent_type_id' => 'required|numeric',
            'title' => 'required|string',
            'hki_file' => 'mimes:pdf',
        ]);

        //mencari data hki berdasarkan id, lalu mengubah datanya berdasarkan input user
        $hki = Hki::findOrFail($id);
        $hki->year = $request->year;
        $hki->leader_id = $request->leader_id;
        $hki->member_1_id = $request->member_1_id != '' ? $request->member_1_id : null;
        $hki->member_2_id = $request->member_2_id != '' ? $request->member_2_id : null;
        $hki->member_3_id = $request->member_3_id != '' ? $request->member_3_id : null;
        $hki->patent_type_id = $request->patent_type_id;
        $hki->creation_type = $request->creation_type != '' ? $request->creation_type : null;
        $hki->title = $request->title;
        $hki->description = $request->description != '' ? $request->description : null;
        $hki->registration_number = $request->registration_number != '' ? $request->registration_number : null;
        $hki->sertification_number = $request->sertification_number != '' ? $request->sertification_number : null;

        //validasi jika ada file yang baru
        if ($request->hasFile('hki_file')) {
            $file = 'hki_' . time() . '.' . $request->file('hki_file')->extension();

            $request->hki_file->move(public_path('hki_file'), $file);
            $hki->hki_file = $file;
        }

        //menyimpan data hki
        $hki->save();

        return redirect('/hki/manage')->with('success', 'Successfully updated hki data');
    }

    public function destroy($id)
    {
        //mencari data hki berdasarkan id
        $hki = Hki::find($id);
        //menghapus data hki berdasarkan id
        $hki->delete();

        return redirect('/hki/manage')->with('success', 'Successfully delete hki data');
    }

    public function hkiPerYear()
    {
        //menampilkan banyaknya data hki berdasarkan tahun
        $data = DB::table('hkis')
            ->select('year', DB::raw('count(*) as total'))
            ->groupBy('year')
            ->get();

        return response()->json($data);
    }

    public function hkiPerMember()
    {
        //mencari data user yang memiliki role lecturer
        $lecturer = User::where('role', 'lecturer')
            ->get();

        //membuat variabel bernama response
        $response = [];

        //menghitung banyaknya data hki berdasarkan member
        foreach ($lecturer as $member) {
            $count = DB::table('hkis')
                ->where('hkis.leader_id', $member->id)
                ->orWhere('hkis.member_1_id', $member->id)
                ->orWhere('hkis.member_2_id', $member->id)
                ->orWhere('hkis.member_3_id', $member->id)
                ->select(
                    DB::raw('count(*) as total')
                )
                ->get();
                
            array_push($response, [
                'code' => $member->code, 
                'total' => $count[0]->total,
            ]);
        }
        
        return response()->json($response);
    }

    public function hkiPerMemberPerYear($id)
    {
        //mencari data user berdasarkan id
        $lecturer = User::where('id', $id)
            ->get();

        //membuat variabel baru bernama response
        $response = [];

        //menghitung banyaknya data hki berdasarkan member dan tahun
        foreach ($lecturer as $member) {
            $data = DB::table('hkis')
                ->where('hkis.leader_id', $member->id)
                ->orWhere('hkis.member_1_id', $member->id)
                ->orWhere('hkis.member_2_id', $member->id)
                ->orWhere('hkis.member_3_id', $member->id)
                ->select(
                    'year',
                    DB::raw('count(*) as total')
                )
                ->groupBy('year')
                ->get();
                
            array_push($response, [
                'code' => $member->code, 
                'hkis' => $data,
            ]);
        }
        
        return response()->json($response);
    }

    public function patentType() 
    {
        //menampilkan banyaknya data hki berdasarkan jenis paten
        $data = DB::table('hkis')
            ->leftJoin('patent_types', 'hkis.patent_type_id', '=', 'patent_types.id')
            ->select('patent_types.name as pt_name', DB::raw('count(*) as total'))
            ->groupBy('patent_types.name')
            ->get();

        return response()->json($data);
    }

    public function stats($view) 
    {
        //menampilkan halaman statistik berdasarkan view
        if ($view == 'per_year') {
            return view('hki.stats_per_year');
        } else if($view == 'per_patent_type') {
            return view('hki.stats_per_patent_type');
        } else if($view == 'per_member') {
            return view('hki.stats_per_member');         
        } else if($view == 'per_member_per_year') {
            $member = User::where('role', 'lecturer')
                ->get();
            return view('hki.stats_per_member_per_year', ['member' => $member]);           
        }
    }
}
