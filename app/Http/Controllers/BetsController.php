<?php

namespace App\Http\Controllers;

use App\Bet;
use App\Match;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use function PhpParser\filesInDir;

class BetsController extends Controller
{

    /**
     * BetsController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user_id = Auth::id();
        $bets = Bet::select('bets.id AS id','users.name AS user_id','bets.match_id AS match_id',
            'bets.cote_bets AS cote_bets','bets.mise AS mise','bets.win_bets AS win_bets','bets.gain AS gain',
            'bets.created_at AS created_at', 'matches.beginning AS beginning', 'bets.bet_winner AS bet_winner',
            'teams1.name AS team1', 'teams2.name AS team2', 'teams1.flag AS flag1', 'teams2.flag AS flag2',
            'matches.team_1 AS team_id_1', 'matches.team_2 AS team_id_2', 'matches.score AS score')
            ->join('users', 'users.id','=', 'bets.user_id')
            ->join('matches', 'matches.id','=', 'bets.match_id')
            ->join('teams AS teams1', 'teams1.id','=', 'matches.team_1')
            ->join('teams AS teams2', 'teams2.id','=', 'matches.team_2')
            ->where('bets.user_id', $user_id)
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
        return view('bets.index', compact('bets', 'user_id'));
    }

    /**
     * @param $match_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create($match_id)
    {
        $user_id = Auth::id();
        $match = Match::select('matches.id AS id', 'matches.emplacement AS emplacement',
            'matches.beginning AS beginning', 'matches.cote_team_1 AS cote_team_1',
            'matches.cote_team_2 AS cote_team_2', 'matches.cote_match_n AS cote_match_n',
            'teams1.name AS team_1', 'teams2.name AS team_2', 'teams1.flag AS flag_1',
            'teams1.flag AS flag_2')
            ->join('teams AS teams1', 'teams1.id', '=', 'matches.team_1')
            ->join('teams AS teams2', 'teams2.id', '=', 'matches.team_2')
            ->where('matches.id', $match_id)
            ->get();
        $match = $match[0];
        $match->date = substr($match->beginning, 0, 10);
        $match->time = substr($match->beginning, 11, 5);
        return view('bets.create', compact('match', 'user_id'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $this->actualizeMatches();
        $match = Match::find($request->get('match_id'));
        if ($match->start == 1)
        {
            return redirect(route('matches'))
                ->with('danger','Le match n\'est plus disponible pour les paris');
        }

        $request->validate([
            'mise' => 'bail|required|numeric',
            'cote_bets' => 'required',
        ]);

        $user_id = Auth::id();
        $user = User::find($user_id);
        if ($request->get('mise') > $user->balance)
        {
            return redirect(route('new-bet', $request->get('match_id')))
                ->with('danger','Solde insuffisant sur le compte !');
        }
        $user->balance -= $request->get('mise');
        $user->save();

        $match = Match::find($request->get('match_id'));

        $bet = new Bet();
        $bet->user_id = $request->get('user_id');
        $bet->match_id = $request->get('match_id');
        $bet->mise = $request->get('mise');
        $bet->cote_bets = $request->get('cote_bets');
        if ($match->cote_team_1 == $bet->cote_bets)
        {
            $bet->bet_winner = $match->team_1;
        }
        else if ($match->cote_team_2 == $bet->cote_bets)
        {
            $bet->bet_winner = $match->team_2;
        }
        else
        {
            $bet->bet_winner = 0;
        }
        $bet->created_at = Carbon::now();
        $bet->updated_at = Carbon::now();
        $bet->save();
        return redirect(route('root'))->with('success','Nouveau pari enregistré');
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
