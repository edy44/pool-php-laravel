<?php

namespace App\Http\Controllers;

use App\Match;
use Illuminate\Http\Request;

class MatchsController extends Controller
{

    /**
     * MatchsController constructor.
     */
    public function __construct()
    {
        $this->actualizeMatches();
    }

    /**
     * @param null $status
     * @param null $team_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index($status = NULL, $team_id = NULL)
    {
        $matches = Match::select('matches.id AS id', 'matches.emplacement AS emplacement',
            'matches.beginning AS beginning', 'matches.cote_team_1 AS cote_team_1',
            'matches.cote_team_2 AS cote_team_2', 'matches.cote_match_n AS cote_match_n',
            'matches.score AS score', 'matches.team_1 AS team_id_1', 'matches.team_2  AS team_id_2',
            'teams1.name AS team_1', 'teams2.name AS team_2', 'matches.winner AS winner',
            'teams1.flag AS flag_1', 'teams2.flag AS flag_2')
            ->join('teams AS teams1', 'teams1.id', '=', 'matches.team_1')
            ->join('teams AS teams2', 'teams2.id', '=', 'matches.team_2');
        if ($status == 'finish')
        {
            $matches = $matches->where('matches.start', 1);
        }
        else
        {
            $matches = $matches->where('matches.start', 0);
        }
        if ($team_id)
        {
            $matches = $matches->where(function($q) use ($team_id){
                    $q->where('team_1', $team_id)
                        ->orWhere('team_2', $team_id);
                });
        }
        $matches = $matches->orderBy('beginning')->get();
        foreach ($matches as $key => $match)
        {
            $matches[$key]->date = substr($match->beginning, 0, 10);
            $matches[$key]->time = substr($match->beginning, 11, 5);
            if ($match->team_id_1 == $match->winner)
            {
                $matches[$key]->winner = $match->team_1;
            }
            elseif ($match->team_id_2 == $match->winner)
            {
                $matches[$key]->winner = $match->team_2;
            }
            else
            {
                $matches[$key]->winner = 'Match Nul';
            }
        }
        return view('matches.index', compact('matches', 'status'));
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        $match = Match::select('matches.id AS id', 'matches.emplacement AS emplacement',
            'matches.beginning AS beginning', 'matches.cote_team_1 AS cote_team_1',
            'matches.cote_team_2 AS cote_team_2', 'matches.cote_match_n AS cote_match_n',
            'matches.score AS score', 'matches.team_1 AS team_id_1', 'matches.team_2  AS team_id_2',
            'teams1.name AS team_1', 'teams2.name AS team_2', 'matches.winner AS winner',
            'matches.weather AS weather', 'matches.faults AS faults', 'matches.actions AS actions',
            'teams1.flag AS flag_1', 'teams2.flag AS flag_2')
            ->join('teams AS teams1', 'teams1.id', '=', 'matches.team_1')
            ->join('teams AS teams2', 'teams2.id', '=', 'matches.team_2')
            ->where('matches.id', $id)
            ->get();
        $match = $match[0];
        if ($match->team_id_1 == $match->winner)
        {
            $match->winner = $match->team_1;
        }
        elseif ($match->team_id_2 == $match->winner)
        {
            $match->winner = $match->team_2;
        }
        else
        {
            $match->winner = 'Match Nul';
        }
        $match->date = substr($match->beginning, 0, 10);
        $match->time = substr($match->beginning, 11, 5);
        return view('matches.show', compact('match'));
    }

    /**
     * Dès qu'une page de paris est chargée, on actualise en fonction des horaires des matchs
     */
    private function actualizeMatches()
    {
        $matches = Match::where('start', 0)->get();
        foreach ($matches as $key => $match)
        {
            if (date('Y-m-d H:i:s') > $match->beginning)
            {
                $matches[$key]->start = 1;
            }
            $matches[$key]->save();
        }
    }

}
