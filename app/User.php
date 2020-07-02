<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Silber\Bouncer\Database\HasRolesAndAbilities;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;
    use HasRolesAndAbilities;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getOrgs () {
        return  $this->getAbilities()
            ->where('name','login')
            ->where('entity_type','App\Org')
            ->pluck('entity_id');
        #return null;        
    }

    public function getTeams () {
        return  $this->getAbilities()
            ->where('name','member')
            ->where('entity_type','App\Team')
            ->pluck('entity_id');
        #return null;        
    }

    public function isAdmin () {
        $count =  $this->getAbilities()
            ->where('name','admin')
            ->count();
        return $count > 0;
        #return null;        
    }

    public function isMember () {
        $count =  $this->getAbilities()
            ->where('name','member')
            ->count();
        return $count > 0;
        #return null;        
    }
    

    public function isManager () {
        $count =  $this->getAbilities()
            ->where('name','manage')
            ->count();
        return $count > 0;
        #return null;        
    }


    public function role () {
        
        if ($this->isAdmin()) {
            $role = "Admin";
        }
        elseif($this->isManager()) {
            if (strpos($this->email,"coach") > 0 ) {
                $role = "Coach";
            }
            else {
                $role = "Manager";
            }
            
        }
        elseif($this->isMember() ) {
            $role = "Member";
        }
        else {
            $role = "Unknown";
        }

        return $role;        
    }


    
}
