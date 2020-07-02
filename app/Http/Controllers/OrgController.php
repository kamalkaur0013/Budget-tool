<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Org;
use App\User;

class OrgController extends Controller
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
        $list = auth()->user()->getOrgs();
        $orgs = Org::whereIn('id', $list)->get();
        return view('org/index', compact('orgs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
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
            'website'=> 'required|url',
            'abbr' => 'required',
            'active' => 'required|boolean'
        ]);

        $org = new org([
            'name'=> $request->name,
            'website'=> $request->website,
            'abbr' => $request->abbr,
            'active' => $request->active
        ]);
        $org->save();
        
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
        $org = org::findOrFail($id);

        return json_encode(['status' => 1, 'data' => $org]);
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
            'website'=> 'required|url',
            'active' => 'required|boolean',
            'abbr' => 'required'
        ]);

        $org = org::findOrFail($id);

        $org->name = $request->name;
        $org->website = $request->website;
        $org->active = $request->active;
        $org->abbr = $request->abbr;
        $org->save();
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
        $org = org::findOrFail($id);
        $org->delete();
        return json_encode(['status' => 1]);
    }
}
