<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Match extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'team_1','team_2','emplacement','beginning','start','cote_team_1','cote_team_2','cote_match_n',
    ];
}
