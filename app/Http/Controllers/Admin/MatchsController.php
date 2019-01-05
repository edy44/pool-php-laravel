<?php

namespace App\Http\Controllers\Admin;

use App\Bet;
use App\Http\Controllers\Controller;
use App\Match;
use App\StatTeam;
use App\Teams;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class MatchsController extends Controller
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
        $matches = Match::select('matches.id AS id', 'matches.emplacement AS emplacement',
            'matches.beginning AS beginning', 'matches.cote_team_1 AS cote_team_1',
            'matches.cote_team_2 AS cote_team_2', 'matches.cote_match_n AS cote_match_n',
            'matches.score AS score', 'matches.team_1 AS team_id_1', 'matches.team_2  AS team_id_2',
            'teams1.name AS team_1', 'teams2.name AS team_2', 'matches.winner AS winner')
            ->join('teams AS teams1', 'teams1.id', '=', 'matches.team_1')
            ->join('teams AS teams2', 'teams2.id', '=', 'matches.team_2')
            ->orderBy('beginning')
            ->get();
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
        return view("admin.matches.index", compact('matches'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $teams = Teams::where('id', '!=', 1)->get();
        return view("admin.matches.create", compact('teams'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'emplacement' => 'bail|required|max:255',
            'date' => 'bail|required',
            'time' => 'bail|required',
            'cote_team_1' => 'bail|required|numeric',
            'cote_team_2' => 'bail|required|numeric',
            'cote_match_n' => 'bail|required|numeric',
        ]);
        $beginning = $request->get('date').' '.$request->get('time').':00';
        $match= new Match;
        $match->team_1= $request->get('team_1');
        $match->team_2= $request->get('team_2');
        $match->emplacement= $request->get('emplacement');
        $match->beginning= $beginning;
        $match->cote_team_1=$request->get('cote_team_1');
        $match->cote_team_2=$request->get('cote_team_2');
        $match->cote_match_n=$request->get('cote_match_n');
        $match->start = 0;
        $match->save();
        return redirect('/admin/matches')->with('success','Nouveau match ajoutée');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function stats($id)
    {
        $match = Match::find($id);
        return view('admin.matches.stats', compact('match'));
    }

    public function update_stats(Request $request, $id)
    {
        $match = Match::find($id);
        $match->weather= $request->get('weather');
        $match->faults= $request->get('faults');
        $match->actions= $request->get('actions');
        $match->save();
        return redirect('admin/matches/')->with('success','Stats du Match modifié');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $match = Match::find($id);
        $match->date = substr($match->beginning, 0, 10);
        $match->time = substr($match->beginning, 11, 5);
        $teams = Teams::where('id', '!=', 1)->get();
        return view('admin.matches.edit', compact('match', 'teams'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'emplacement' => 'bail|required|max:255',
            'date' => 'bail|required',
            'time' => 'bail|required',
            'cote_team_1' => 'bail|required|numeric',
            'cote_team_2' => 'bail|required|numeric',
            'cote_match_n' => 'bail|required|numeric',
            'winner' => 'bail|sometimes|nullable',
            'score' => 'bail|sometimes|nullable',
        ]);
        $beginning = $request->get('date').' '.$request->get('time').':00';
        $match = Match::find($id);
        $match->team_1= $request->get('team_1');
        $match->team_2= $request->get('team_2');
        $match->emplacement= $request->get('emplacement');
        $match->beginning= $beginning;
        $match->cote_team_1=$request->get('cote_team_1');
        $match->cote_team_2=$request->get('cote_team_2');
        $match->cote_match_n=$request->get('cote_match_n');
        $match->winner=$request->get('winner');
        $match->score=$request->get('score');
        if (date('Y-m-d H:i:s') > $match->beginning)
        {
            $match->start = 1;
        }
        $match->save();
        if ($request->get('winner'))
        {
            $this->actualizeBets($id);
            $this->actualizeStatTeams($match);
        }
        return redirect('admin/matches/')->with('success','Match modifié');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $match = Match::find($id);
        $bets=Bet::where('match_id', $id )->get();
        foreach($bets as $key =>$bet)
        {
            $bets[$key]->delete();
            $user = User::find($bet->user_id);
            $user->balance += $bet->mise;
            $user->save();
        }
        $match->delete($id);
        return redirect('/admin/matches')->with('danger','Match supprimé');
    }

    /**
     * @param $match_id
     */
    private function actualizeBets($match_id)
    {
        $bets = Bet::select('bets.id AS id', 'bets.user_id AS user_id', 'matches.winner AS match_winner',
            'bets.mise AS mise', 'bets.cote_bets AS cote_bets', 'bets.match_id AS match_id',
            'bets.win_bets AS win_bets', 'bets.gain AS gain', 'bets.updated_at AS updated_at',
            'bets.bet_winner AS bet_winner')
            ->join('matches', 'matches.id', '=', 'bets.match_id')
            ->where('bets.match_id', $match_id)
            ->get();
        foreach ($bets as $key => $bet)
        {
            $gain = 0;
            if ($bet->bet_winner == $bet->match_winner)
            {
                $bets[$key]->win_bets = 1;
                $bets[$key]->gain = $bets[$key]->cote_bets * $bets[$key]->mise;
                $gain += $bets[$key]->gain;
                $user = User::find($bet->user_id);
                if ($user->balance)
                {
                    $balance = $user->balance;
                }
                else
                {
                    $balance = 0;
                }
                $user->balance = $balance + $gain;
                $user->save();
            }
            else
            {
                $bets[$key]->win_bets = 0;
                $bets[$key]->gain = 0;
            }
            $bets[$key]->save();
        }
    }


    private function actualizeStatTeams($match)
    {
        $stat_team1 = StatTeam::where('team_id', $match->team_1)->get();
        $stat_team2 = StatTeam::where('team_id', $match->team_2)->get();
        $stat_team1 = $stat_team1[0];
        $stat_team1 = $stat_team1[0];
        $stat_team1->matches += 1;
        $stat_team2->matches += 1;
        if ($match->winner == 0)
        {
            $stat_team1->matches += 1;
            $stat_team2->matches += 1;
        }
        elseif ($match->winner == $match->team_1)
        {
            $stat_team1->win += 1;
            $stat_team2->loose += 1;
        }
        else
        {
            $stat_team2->win += 1;
            $stat_team1->loose += 1;
        }
        $stat_team1->save();
        $stat_team2->save();
    }
}
