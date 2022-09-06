<?php

namespace App\Http\Controllers;

use App\Models\Abdimas;
use App\Models\AbdimasType;
use App\Models\Lab;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AbdimasController extends Controller
{
    public function index()
    {
        //ambil data anggota abdimas
        $member = User::where('role', 'lecturer')
            ->where('code', '!=', null)
            ->orderBy('name')
            ->get();
        
        //ambil data jenis abdimas
        $abdimas_type = AbdimasType::all();

        //ambil data lab
        $lab = Lab::all();

        //ambil data abdimas
        $abdimas = DB::table('abdimas')
            ->leftJoin('users as l', 'abdimas.leader_id', 'l.id')
            ->leftJoin('users as m1', 'abdimas.member_1_id', 'm1.id')
            ->leftJoin('users as m2', 'abdimas.member_2_id', 'm2.id')
            ->leftJoin('users as m3', 'abdimas.member_3_id', 'm3.id')
            ->leftJoin('users as m4', 'abdimas.member_4_id', 'm4.id')
            ->leftJoin('users as m5', 'abdimas.member_5_id', 'm5.id')
            ->leftJoin('abdimas_types', 'abdimas.abdimas_type_id', 'abdimas_types.id')
            ->leftJoin('labs', 'abdimas.lab_id' , '=', 'labs.id')
            ->select(
                'abdimas.*',
                'l.name as leader',
                'm1.name as member1',
                'm2.name as member2',
                'm3.name as member3',
                'm4.name as member4',
                'm5.name as member5',
                'abdimas_types.name as abdimas_type',
                'labs.name as lab_name',
            )
            ->get();

        return view('abdimas.index', [
            'member' => $member, 
            'abdimas' => $abdimas,
            'abdimas_type' => $abdimas_type,
            'lab' => $lab,
        ]);
    }

    public function store(Request $request)
    {
        //validasi input user
        $request->validate([
            'year' => 'required|numeric',
            'abdimas_type_id' => 'required|numeric',
            'title' => 'required|string',
            'status' => 'required|string',
            'leader_id' => 'required|numeric',
            'lab_id' => 'required|numeric',
            'abdimas_file' => 'mimes:pdf',
        ]);

        //membuat data abdimas baru berdasarkan input user
        $abdimas = new Abdimas();
        $abdimas->year = $request->year;
        $abdimas->abdimas_type_id = $request->abdimas_type_id;
        $abdimas->activity_name = $request->activity_name;
        $abdimas->title = $request->title;
        $abdimas->status = $request->status;
        $abdimas->leader_id = $request->leader_id;
        $abdimas->member_1_id = $request->member_1_id != '' ? $request->member_1_id : null;
        $abdimas->member_2_id = $request->member_2_id != '' ? $request->member_2_id : null;
        $abdimas->member_3_id = $request->member_3_id != '' ? $request->member_3_id : null;
        $abdimas->member_4_id = $request->member_4_id != '' ? $request->member_4_id : null;
        $abdimas->member_5_id = $request->member_5_id != '' ? $request->member_5_id : null;
        $abdimas->partner = $request->partner != '' ? $request->partner : null;
        $abdimas->partner_address = $request->partner_address != '' ? $request->partner_address : null;
        $abdimas->lab_id = $request->lab_id;

        //memindahkan file yang diupload oleh user ke folder public
        if ($request->hasFile('abdimas_file')) {
            $file = 'abdimas_' . time() . '.' . $request->file('abdimas_file')->extension();

            $request->abdimas_file->move(public_path('abdimas_file'), $file);
            $abdimas->abdimas_file = $file;
        } else {
            $abdimas->abdimas_file = null;
        }

        //menyimpan data abdimas
        $abdimas->save();

        return redirect('/abdimas')->with('success', 'Successfully added abdimas data');
    }

    public function manage()
    {
        //validasi user telah login
        if (Auth::check() == TRUE) {
            //validasi user yang login adalah admin
            if (Auth::user()->role == 'admin') {
                //ambil data anggota abdimas
                $member = User::where('role', 'lecturer')
                ->where('code', '!=', null)
                ->orderBy('name')
                ->get();
    
                //ambil data jenis abdimas
                $abdimas_type = AbdimasType::all();

                //ambil data lab
                $lab = Lab::all();

                //ambil data abdimas
                $abdimas = DB::table('abdimas')
                    ->leftJoin('users as l', 'abdimas.leader_id', 'l.id')
                    ->leftJoin('users as m1', 'abdimas.member_1_id', 'm1.id')
                    ->leftJoin('users as m2', 'abdimas.member_2_id', 'm2.id')
                    ->leftJoin('users as m3', 'abdimas.member_3_id', 'm3.id')
                    ->leftJoin('users as m4', 'abdimas.member_4_id', 'm4.id')
                    ->leftJoin('users as m5', 'abdimas.member_5_id', 'm5.id')
                    ->leftJoin('abdimas_types', 'abdimas.abdimas_type_id', 'abdimas_types.id')
                    ->leftJoin('labs', 'abdimas.lab_id' , '=', 'labs.id')
                    ->select(
                        'abdimas.*',
                        'l.name as leader',
                        'm1.name as member1',
                        'm2.name as member2',
                        'm3.name as member3',
                        'm4.name as member4',
                        'm5.name as member5',
                        'abdimas_types.name as abdimas_type',
                        'labs.name as lab_name',
                    )
                    ->get();

                return view('abdimas.manage', [
                    'member' => $member, 
                    'abdimas' => $abdimas,
                    'abdimas_type' => $abdimas_type,
                    'lab' => $lab,
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
            'abdimas_type_id' => 'required|numeric',
            'title' => 'required|string',
            'status' => 'required|string',
            'leader_id' => 'required|numeric',
            'lab_id' => 'required|numeric',
            'abdimas_file' => 'mimes:pdf',
        ]);

        //mencari data abdimas berdasarkan id, lalu mengambil data yang baru berdasarkan input user
        $abdimas = Abdimas::findOrFail($id);
        $abdimas->year = $request->year;
        $abdimas->abdimas_type_id = $request->abdimas_type_id;
        $abdimas->activity_name = $request->activity_name;
        $abdimas->title = $request->title;
        $abdimas->status = $request->status;
        $abdimas->leader_id = $request->leader_id;
        $abdimas->member_1_id = $request->member_1_id != '' ? $request->member_1_id : null;
        $abdimas->member_2_id = $request->member_2_id != '' ? $request->member_2_id : null;
        $abdimas->member_3_id = $request->member_3_id != '' ? $request->member_3_id : null;
        $abdimas->member_4_id = $request->member_4_id != '' ? $request->member_4_id : null;
        $abdimas->member_5_id = $request->member_5_id != '' ? $request->member_5_id : null;
        $abdimas->partner = $request->partner != '' ? $request->partner : null;
        $abdimas->partner_address = $request->partner_address != '' ? $request->partner_address : null;
        $abdimas->lab_id = $request->lab_id;

        //validasi adanya file baru
        if ($request->hasFile('abdimas_file')) {
            $file = 'abdimas_' . time() . '.' . $request->file('abdimas_file')->extension();

            $request->abdimas_file->move(public_path('abdimas_file'), $file);
            $abdimas->abdimas_file = $file;
        } 

        //menyimpan data abdimas
        $abdimas->save();

        return redirect('/abdimas')->with('success', 'Successfully edit abdimas data');
    }

    public function destroy($id)
    {
        //mencari data abdimas berdasarkan id
        $abdimas = Abdimas::find($id);
        //menghapus data abdimas
        $abdimas->delete();

        return redirect('/abdimas/manage')->with('success', 'Successfully delete abdimas data');
    }

    public function abdimasPerYear()
    {
        //menampilkan banyaknya data abdimas berdasarkan tahun
        $data = DB::table('abdimas')
            ->select('year', DB::raw('count(*) as total'))
            ->groupBy('year')
            ->get();

        return response()->json($data);
    }

    public function abdimasPerMember()
    {
        //mencari user yang memiliki role lecturer
        $lecturer = User::where('role', 'lecturer')
            ->get();

        //membuat variabel bernama response
        $response = [];

        //menghitung banyaknya data abdimas yang dibuat setiap member berdasarkan tahun
        foreach ($lecturer as $member) {
            $count = DB::table('abdimas')
                ->where('abdimas.leader_id', $member->id)
                ->orWhere('abdimas.member_1_id', $member->id)
                ->orWhere('abdimas.member_2_id', $member->id)
                ->orWhere('abdimas.member_3_id', $member->id)
                ->orWhere('abdimas.member_4_id', $member->id)
                ->orWhere('abdimas.member_5_id', $member->id)
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

    public function abdimasPerMemberPerYear($id)
    {
        //mencari data user berdasarkan id
        $lecturer = User::where('id', $id)
            ->get();

        //membuat variabel bernama response
        $response = [];

        //menghitung banyaknya data abdimas yang telah dibuat oleh member berdasarkan id
        foreach ($lecturer as $member) {
            $data = DB::table('abdimas')
                ->where('abdimas.leader_id', $member->id)
                ->orWhere('abdimas.member_1_id', $member->id)
                ->orWhere('abdimas.member_2_id', $member->id)
                ->orWhere('abdimas.member_3_id', $member->id)
                ->orWhere('abdimas.member_4_id', $member->id)
                ->orWhere('abdimas.member_5_id', $member->id)
                ->select(
                    'year',
                    DB::raw('count(*) as total')
                )
                ->groupBy('year')
                ->get();
                
            array_push($response, [
                'code' => $member->code, 
                'abdimas' => $data,
            ]);
        }
        
        return response()->json($response);
    }

    public function abdimasType() 
    {
        //menampilkan banyaknya data abdimas berdasarkan tipe abdimas
        $data = DB::table('abdimas')
            ->leftJoin('abdimas_types', 'abdimas.abdimas_type_id', '=', 'abdimas_types.id')
            ->select('abdimas_types.name as at_name', DB::raw('count(*) as total'))
            ->groupBy('abdimas_types.name')
            ->get();

        return response()->json($data);
    }

    public function stats($view) 
    {
        //menampilkan halaman statistik berdasarkan view
        if ($view == 'per_year') {
            return view('abdimas.stats_per_year');
        } else if($view == 'per_abdimas_type') {
            return view('abdimas.stats_per_abdimas_type');
        } else if($view == 'per_member') {
            return view('abdimas.stats_per_member');         
        } else if($view == 'per_member_per_year') {
            $member = User::where('role', 'lecturer')
                ->get();
            return view('abdimas.stats_per_member_per_year', ['member' => $member]);           
        }
    }

}
