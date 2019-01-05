<?php

namespace App\Http\Controllers;

use App\Player;
use App\StatTeam;
use App\Teams;
use Illuminate\Http\Request;

class TeamsController extends Controller
{

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $teams = Teams::where('id', '!=', 1)->where('delete', '!=', 1)->get();
        $players = Player::all();
        return view('teams.index', compact('teams', 'players'));
    }

    public function show($id)
    {
        $players = Player::select('players.id AS id', 'players.name AS name',
            'teams.flag AS flag', 'teams.name AS team', 'teams.country AS country'
            , 'players.birthdate AS birthdate',
            'players.goal AS goal', 'players.role AS role')
            ->join('teams', 'teams.id', '=', 'players.team_id')
            ->where('team_id', $id)
            ->get();
        $stat_team = StatTeam::where('team_id', $id)->get();
        $stat_team = $stat_team[0];
        return view('teams.show', compact('players', 'stat_team'));
    }

}
