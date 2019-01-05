<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Bet;

class BetsController extends Controller
{
    /**
     * MatchsController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bets = Bet::select('bets.id AS id','users.name AS user_id','bets.match_id AS match_id',
            'bets.cote_bets AS cote_bets','bets.mise AS mise','bets.win_bets AS win_bets','bets.gain AS gain',
            'bets.created_at AS created_at', 'matches.beginning AS beginning', 'bets.bet_winner AS bet_winner',
            'teams1.name AS team1', 'teams2.name AS team2', 'teams1.flag AS flag1', 'teams2.flag AS flag2',
            'matches.team_1 AS team_id_1', 'matches.team_2 AS team_id_2', 'matches.score AS score')
            ->join('users', 'users.id','=', 'bets.user_id')
            ->join('matches', 'matches.id','=', 'bets.match_id')
            ->join('teams AS teams1', 'teams1.id','=', 'matches.team_1')
            ->join('teams AS teams2', 'teams2.id','=', 'matches.team_2')
            ->get();
        foreach ($bets as $key => $bet)
        {
            $bets[$key]->bet_date = substr($bet->created_at, 0, 10);
            $bets[$key]->bet_time = substr($bet->created_at, 11, 5);
            $bets[$key]->match_date = substr($bet->beginning, 0, 10);
            $bets[$key]->match_time = substr($bet->beginning, 11, 5);
            if ($bet->team_id_1 == $bet->bet_winner)
            {
                $bets[$key]->bet_winner = $bet->team1;
            }
            elseif ($bet->team_id_2 == $bet->bet_winner)
            {
                $bets[$key]->bet_winner = $bet->team2;
            }
            else
            {
                $bets[$key]->bet_winner = 'Match Nul';
            }
        }
        return view('admin.bets.index', compact('bets'));
    }

}
