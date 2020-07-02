<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

use App\Team;
use App\TeamMember;
class Org extends Model
{
    //
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'abbr', 'name', 'active'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [ ];    

    public function teams() {
        return $this->hasMany('App\Team');
    }

    public function members() {
        return $this->hasManyThrough('App\TeamMember', 'App\Team');
    }

    
}
