<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $fillable = [
        'title', 'owner_id'
    ];

    protected $hidden = [
        'pivot',
    ];

    public function userteams()
    {
        return $this->hasMany(UserTeam::class);
    }

    function users()
    {
        return $this->belongsToMany(User::class, 'user_teams');
    }
}
