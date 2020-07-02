<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Org;
use App\Team;

class TeamController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    protected function redirectTo($request)
    {
        return route('login');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        #$orgs = Org::all();

        if (auth()->user()->isAdmin()) {
            $list = auth()->user()->getOrgs();
            $teams = Team::whereIn('org_id', $list)->get();
        }
        else {
            // Not an admin return the list of teams they belong too
            $list = auth()->user()->getTeams();
            $teams = Team::whereIn('id', $list)->get();
        }
        return view('team/index', compact('teams'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'name'=> 'required',
            'division'=> 'required',
            'level' => 'required',
        ]);


        $org = Org::find($request->id);
        
        abort_if($org == null, 404, 'Organization was not found');
        abort_if(auth()->user()->cant('admin',$org), 403, 'User is not authorized for this action');
       
        $team = new Team([
            'name'=> $request->name,
            'org_id'=> $org->id,
            'division'=> $request->division,
            'level' => $request->level,
        ]);
        $team->save();
        
        return json_encode(['status' => 1]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\org  $org
     * @return \Illuminate\Http\Response
     */
    public function show(org $org)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\org  $org
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //

        
        
        $team = Team::findOrFail($id);
        abort_if($team == null, 404, 'Team was not found');
        $authorized = auth()->user()->can('manage',$team);
        if ($authorized == false) {
            $authorized = auth()->user()->can('admin',$team->org);
        }
        
        abort_unless($authorized, 403, 'User is not authorized for this action');       

        return json_encode(['status' => 1, 'data' => $team]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\org  $org
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $request->validate([
            'name'=> 'required',
            'division'=> 'required',
            'level' => 'required',
        ]);

        $team = Team::find($request->id);        
        abort_if($team == null, 404, 'Team was not found');
        $authorized = auth()->user()->can('manage',$team);
        if ($authorized == false) {
            $authorized = auth()->user()->can('admin',$team->org);
        }        
        abort_unless($authorized, 403, 'User is not authorized for this action');  

        $team->name = $request->name;
        $team->division = $request->division;
        $team->level = $request->level;
        $team->save();
        return json_encode(['status' => 1]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\org  $org
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //

        $team = Team::find($id);

        abort_if($team == null, 404, 'Team was not found');
        abort_if(auth()->user()->cant('admin',$team->org), 403, 'User is not authorized for this action');
       
        return json_encode(['status' => 1]);
    }
}
