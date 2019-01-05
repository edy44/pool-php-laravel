<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Player;
use App\StatTeam;
use App\Teams;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TeamsController extends Controller
{

    /**
     * TeamsController constructor.
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
        $teams=Teams::where('id', '!=', 1)->where('delete', '!=', 1)->get();
        return view("admin.teams.index", compact('teams'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("admin.teams.create");
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
            'name' => 'bail|required|unique:teams|max:255',
            'flag' => 'bail|required',
            'country' => 'bail|required',
        ]);
        if($request->hasFile('flag'))
        {
            $file = $request->file('flag');
            $name=time().$file->getClientOriginalName();
            $file->move(public_path().'/images/',$name);
        }
        $team= new Teams();
        $team->name=$request->get('name');
        $team->flag=$name;
        $team->delete=0;
        $team->created_at=Carbon::now();
        $team->updated_at=Carbon::now();
        $team->save();
        $stat_team = new StatTeam();
        $stat_team->team_id = $team->id;
        $stat_team->save();
        return redirect('/admin/teams')->with('success','Nouvelle équipe ajoutée');

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
        $stat_team = StatTeam::where('team_id', $id)->get();
        $stat_team = $stat_team[0];
        return view('admin.teams.show', compact('players', 'stat_team'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $team = Teams::find($id);
        return view('admin.teams.edit', compact('team'));
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
        $team = Teams::find($id);
        $request->validate([
            'name' => [
                'bail',
                'required',
                Rule::unique('players')->ignore($team->id),
                'max:255'
            ],
            'country' => 'bail|required',
        ]);
        if($request->hasfile('flag'))
        {
            unlink(public_path().'/images/'.$team->flag);
            $file = $request->file('flag');
            $name=time().$file->getClientOriginalName();
            $file->move(public_path().'/images/',$name);
        }
        $team->name= $request->get('name');
        if(isset($name))
        {
            $team->flag=$name;
        }
        $team->updated_at = Carbon::now();
        $team->save();
        return redirect('/admin/teams')->with('success','Équipe modifiée');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $team = Teams::find($id);
        unlink(public_path().'/images/'.$team->flag);
        $players = Player::where('team_id', $id)->get();
        foreach ($players as $key => $player)
        {
            $players[$key]->team_id = 1;
            $players[$key]->save();
        }
        $team->delete = 1;
        $team->save();
        return redirect('/admin/teams')->with('danger','Équipe supprimée');
    }
}
