<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
	protected $fillable = ['player_1', 'player_2', 'status', 'winner'];

	public function user()
    {

    	return $this->belongsTo(User::class);

    }
}
