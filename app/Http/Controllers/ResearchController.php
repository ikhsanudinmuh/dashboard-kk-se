<?php

namespace App\Http\Controllers;

use App\Models\Lab;
use App\Models\Research;
use App\Models\ResearchType;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ResearchController extends Controller
{
    public function index()
    {
        //ambil data anggota penelitian
        $member = User::where('role', 'lecturer')
            ->where('code', '!=', null)
            ->orderBy('name')
            ->get();
        
        //ambil data jenis penelitian
        $research_type = ResearchType::all();

        //ambil data lab
        $lab = Lab::all();

        //ambil data penelitian
        $research = DB::table('researchs')
            ->leftJoin('users as l', 'researchs.leader_id', 'l.id')
            ->leftJoin('users as m1', 'researchs.member_1_id', 'm1.id')
            ->leftJoin('users as m2', 'researchs.member_2_id', 'm2.id')
            ->leftJoin('users as m3', 'researchs.member_3_id', 'm3.id')
            ->leftJoin('research_types', 'researchs.research_type_id', 'research_types.id')
            ->leftJoin('labs', 'researchs.lab_id' , '=', 'labs.id')
            ->select(
                'researchs.*',
                'l.name as leader',
                'm1.name as member1',
                'm2.name as member2',
                'm3.name as member3',
                'research_types.name as research_type',
                'labs.name as lab_name',
            )
            ->get();

        return view('research.index', [
            'member' => $member, 
            'research' => $research,
            'research_type' => $research_type,
            'lab' => $lab,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'year' => 'required|numeric',
            'research_type_id' => 'required|numeric',
            'title' => 'required|string',
            'status' => 'required|string',
            'leader_id' => 'required|numeric',
            'lab_id' => 'required|numeric',
            'research_file' => 'mimes:pdf',
        ]);

        $research = new Research();
        $research->year = $request->year;
        $research->research_type_id = $request->research_type_id;
        $research->activity_name = $request->activity_name;
        $research->title = $request->title;
        $research->status = $request->status;
        $research->leader_id = $request->leader_id;
        $research->member_1_id = $request->member_1_id != '' ? $request->member_1_id : null;
        $research->member_2_id = $request->member_2_id != '' ? $request->member_2_id : null;
        $research->member_3_id = $request->member_3_id != '' ? $request->member_3_id : null;
        $research->partner = $request->partner != '' ? $request->partner : null;
        $research->lab_id = $request->lab_id;

        if ($request->hasFile('research_file')) {
            $file = 'research_' . time() . '.' . $request->file('research_file')->extension();

            $request->research_file->move(public_path('research_file'), $file);
            $research->research_file = $file;
        } else {
            $research->research_file = null;
        }

        $research->save();

        return redirect('/research')->with('success', 'Successfully added research data');
    }

    public function manage()
    {
        if (Auth::check() == TRUE) {
            if (Auth::user()->role == 'admin') {
                //ambil data anggota penelitian
                $member = User::where('role', 'lecturer')
                ->where('code', '!=', null)
                ->orderBy('name')
                ->get();
    
                //ambil data jenis penelitian
                $research_type = ResearchType::all();

                //ambil data lab
                $lab = Lab::all();

                //ambil data penelitian
                $research = DB::table('researchs')
                    ->leftJoin('users as l', 'researchs.leader_id', 'l.id')
                    ->leftJoin('users as m1', 'researchs.member_1_id', 'm1.id')
                    ->leftJoin('users as m2', 'researchs.member_2_id', 'm2.id')
                    ->leftJoin('users as m3', 'researchs.member_3_id', 'm3.id')
                    ->leftJoin('research_types', 'researchs.research_type_id', 'research_types.id')
                    ->leftJoin('labs', 'researchs.lab_id' , '=', 'labs.id')
                    ->select(
                        'researchs.*',
                        'l.name as leader',
                        'm1.name as member1',
                        'm2.name as member2',
                        'm3.name as member3',
                        'research_types.name as research_type',
                        'labs.name as lab_name',
                    )
                    ->get();

                return view('research.manage', [
                    'member' => $member, 
                    'research' => $research,
                    'research_type' => $research_type,
                    'lab' => $lab,
                ]);
            }
        } 

        return view('auth.unauthorized');   
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'year' => 'required|numeric',
            'research_type_id' => 'required|numeric',
            'title' => 'required|string',
            'status' => 'required|string',
            'leader_id' => 'required|numeric',
            'lab_id' => 'required|numeric',
            'research_file' => 'mimes:pdf',
        ]);

        $research = Research::findOrFail($id);
        $research->year = $request->year;
        $research->research_type_id = $request->research_type_id;
        $research->activity_name = $request->activity_name;
        $research->title = $request->title;
        $research->status = $request->status;
        $research->leader_id = $request->leader_id;
        $research->member_1_id = $request->member_1_id != '' ? $request->member_1_id : null;
        $research->member_2_id = $request->member_2_id != '' ? $request->member_2_id : null;
        $research->member_3_id = $request->member_3_id != '' ? $request->member_3_id : null;
        $research->partner = $request->partner != '' ? $request->partner : null;
        $research->lab_id = $request->lab_id;

        if ($request->hasFile('research_file')) {
            $file = 'research_' . time() . '.' . $request->file('research_file')->extension();

            $request->research_file->move(public_path('research_file'), $file);
            $research->research_file = $file;
        } 

        $research->save();

        return redirect('/research/manage')->with('success', 'Successfully updated research data');
    }

    public function destroy($id)
    {
        $research = Research::find($id);
        $research->delete();

        return redirect('/research/manage')->with('success', 'Successfully delete research data');
    }

    public function researchPerYear()
    {
        $data = DB::table('researchs')
            ->select('year', DB::raw('count(*) as total'))
            ->groupBy('year')
            ->get();

        return response()->json($data);
    }

    public function researchPerMember()
    {
        $lecturer = User::where('role', 'lecturer')
            ->get();

        $response = [];

        foreach ($lecturer as $member) {
            $count = DB::table('researchs')
                ->where('researchs.leader_id', $member->id)
                ->orWhere('researchs.member_1_id', $member->id)
                ->orWhere('researchs.member_2_id', $member->id)
                ->orWhere('researchs.member_3_id', $member->id)
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

    public function researchPerMemberPerYear($id)
    {
        $lecturer = User::where('id', $id)
            ->get();

        $response = [];

        foreach ($lecturer as $member) {
            $data = DB::table('researchs')
                ->where('researchs.leader_id', $member->id)
                ->orWhere('researchs.member_1_id', $member->id)
                ->orWhere('researchs.member_2_id', $member->id)
                ->orWhere('researchs.member_3_id', $member->id)
                ->select(
                    'year',
                    DB::raw('count(*) as total')
                )
                ->groupBy('year')
                ->get();
                
            array_push($response, [
                'code' => $member->code, 
                'researchs' => $data,
            ]);
        }
        
        return response()->json($response);
    }

    public function researchType() 
    {
        $data = DB::table('researchs')
            ->leftJoin('research_types', 'researchs.research_type_id', '=', 'research_types.id')
            ->select('research_types.name as rt_name', DB::raw('count(*) as total'))
            ->groupBy('research_types.name')
            ->get();

        return response()->json($data);
    }

    public function stats($view) 
    {
        if ($view == 'per_year') {
            return view('research.stats_per_year');
        } else if($view == 'per_research_type') {
            return view('research.stats_per_research_type');
        } else if($view == 'per_member') {
            return view('research.stats_per_member');         
        } else if($view == 'per_member_per_year') {
            $member = User::where('role', 'lecturer')
                ->get();
            return view('research.stats_per_member_per_year', ['member' => $member]);           
        }
    }
}
