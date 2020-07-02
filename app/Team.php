<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    //
    protected $fillable = [
        'org_id', 'name', 'division', 'level'
    ];


    public function org () {
        return  $this->belongsTo('App\Org');
    }    

    public function members () {
        return  $this->hasMany('App\TeamMember');
    }    

    public function players () {
        return  $this->hasMany('App\TeamMember')->where('player',0);
    }    

    public function staff () {
        return  $this->hasMany('App\TeamMember')->where('player',1);
    }    

}
