<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserTeamsRequest;
use App\User;
use App\UserTeam;

class UserTeamsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {
        return User::all();
    }

    public function add_to_team(UserTeamsRequest $request)
    {
        return UserTeam::create($request->all());
    }

    public function remove_from_team(UserTeamsRequest $request)
    {
        $params = $request->all();
        $userTeam = UserTeam::where('user_id', $params['user_id'])->where('team_id', $params['team_id'])->firstOrFail();
        $userTeam->delete();

        return 200;
    }

}
