<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TeamMember extends Model
{
    //
    protected $fillable = [
        'team_id', 'first', 'last', 'number', 'email', 'position', 'player', 'user_id'
    ];    

    public function isPlayer() {
        return $this->player == 0;
    }

    public function isNonPlayer() {
        return $this->player == 1;
    }


    public function isStaff() {
        return $this->player == 1;
    }

    public function user() {
        if ($this->user_id == null) {
            //TODO: THROW NOT FOUND
            return null;
        }
        else {
            return $this->belongsTo('App\User');
        }
    }
    
}
