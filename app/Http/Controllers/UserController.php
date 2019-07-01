<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\UserTeam;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {
        return User::all();
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function store(Request $request)
    {
        return User::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     */
    public function show($id)
    {
        return User::find($id)->with('teams')->get()->toArray();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->update($request->all());

        return $user;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return 204;
    }

    public function add_to_team(Request $request)
    {
        return UserTeam::create($request->all());
    }

    public function remove_from_team(Request $request)
    {
        $params = $request->all();
        $userTeam = UserTeam::where('user_id', $params['user_id'])->where('team_id', $params['team_id'])->firstOrFail();
        $userTeam->delete();

        return 204;
    }

}
