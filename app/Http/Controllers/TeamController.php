<?php

namespace App\Http\Controllers;

use App\Http\Requests\TeamsRequest;
use App\Team;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {
        return Team::all();
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function store(TeamsRequest $request)
    {
        return Team::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     */
    public function show($id)
    {
        return Team::find($id)->with('users')->get()->toArray();
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     */
    public function update(TeamsRequest $request, $id)
    {
        $team = Team::findOrFail($id);
        $team->update($request->all());

        return $team;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     */
    public function destroy($id)
    {
        $team = Team::findOrFail($id);
        $team->delete();

        return 204;
    }
}
