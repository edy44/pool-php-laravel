<?php

namespace App\Http\Controllers;

use App\Player;
use Illuminate\Http\Request;

class PlayersController extends Controller
{

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $players = Player::select('players.id AS id', 'players.name AS name',
            'teams.flag AS flag', 'teams.name AS team'
            , 'players.birthdate AS birthdate',
            'players.goal AS goal', 'players.role AS role')
            ->join('teams', 'teams.id', '=', 'players.team_id')
            ->where('players.team_id', '!=', 1)
            ->get();
        return view('players.index', compact('players'));
    }

}
