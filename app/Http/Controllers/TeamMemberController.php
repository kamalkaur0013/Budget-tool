<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Team;
use App\TeamMember;

class TeamMemberController extends Controller
{
    //
    #public function index(Team $team)
    public function index($id)
    {
        //
        $team= Team::findorfail($id);
        $members =$team->players;
        #return $members;
        return view('team/members', compact('team','members'));
    }

}
