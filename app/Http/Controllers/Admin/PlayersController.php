<?php

namespace App\Http\Controllers\Admin;

use App\Player;
use App\StatTeam;
use App\Teams;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;

class PlayersController extends Controller
{

    /**
     * PlayersController constructor.
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
        $players = Player::select('players.id AS id', 'players.name AS name',
            'players.team_id AS team_id', 'teams.name AS team', 'players.birthdate AS birthdate',
            'players.goal AS goal', 'players.role AS role')
            ->join('teams', 'teams.id', '=', 'players.team_id')
            ->orderBy('players.team_id')
            ->get();
        return view('admin.players.index', compact('players'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $teams = Teams::all();
        return view('admin.players.create', compact('teams'));
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
            'name' => 'bail|required|unique:players|max:255',
            'team_id' => 'bail|required',
        ]);
        $player = new Player();
        $player->name = $request->get('name');
        $player->team_id = $request->get('team_id');
        $player->created_at = Carbon::now();
        $player->updated_at = Carbon::now();
        $player->save();
        $stat_team = StatTeam::find($player->team_id);
        $stat_team->players += 1;
        $stat_team->save();
        return redirect(route('players.index'))->with('success','Nouveau joueur ajouté');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $players = Player::select('players.id AS id', 'players.name AS name',
            'teams.flag AS flag', 'teams.name AS team', 'teams.country AS country'
            , 'players.birthdate AS birthdate',
            'players.goal AS goal', 'players.role AS role')
            ->join('teams', 'teams.id', '=', 'players.team_id')
            ->where('team_id', $id)
            ->get();
        return view('admin.players.show', compact('players'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $player = Player::find($id);
        $teams = Teams::all();
        return view('admin.players.edit', compact('player', 'teams'));
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
        $player = Player::find($id);
        $request->validate([
            'name' => [
                'bail',
                'required',
                Rule::unique('players')->ignore($player->id),
                'max:255'
            ],
            'team_id' => 'bail|required',
        ]);
        $stat_team = StatTeam::find($player->team_id);
        $stat_team->players -= 1;
        $stat_team->save();
        $stat_team = StatTeam::find($request->get('team_id'));
        $stat_team->players += 1;
        $stat_team->save();
        $player->name = $request->get('name');
        $player->team_id = $request->get('team_id');
        if ($request->get('role'))
        {
            $player->role = $request->get('role');
        }
        if ($request->get('goal')) {
            $player->goal = $request->get('goal');
        }
        if ($request->get('birthdate')) {
            $player->birthdate = $request->get('birthdate');
        }
        $player->updated_at = Carbon::now();
        $player->save();
        return redirect(route('players.index'))->with('success','Nouveau joueur modifié');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $player = Player::find($id);
        $count = Player::select('id')->where('team_id', $player->team_id)->count();
        if ($count > 1)
        {
            $player->delete();
            return redirect(route('players.index'))->with('danger','Joueur supprimé');
        }
        else
        {
            return redirect(route('players.index'))->with('warning','Vous ne pouvez pas supprimer le dernier 
            joueur d\'une équipe !');
        }
    }
}
