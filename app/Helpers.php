<?php 

use App\User;
use App\Game;
use App\Score;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

function flash($message, $level = 'info')
{
	Session()->flash('flash_message', $message);
	Session()->flash('flash_message_level', $level);
}

function permutations($obj){

    $combinations = []; 
    $users = [];

    foreach($obj as $key => $user)
    {
        $users[$key] = $user->id;
    }

    foreach($users as $a)
    {
        foreach($users as $b)
        {
            if($a !== $b)
            {
                array_push($combinations, [$a, $b]); 
            }       
        }       
    }
    return $combinations;
}


function removeDuplicates($array)
{
    for($i = count($array)-1; $i >= 0 ; $i--) 
    {
        $j = $i-1; 
        while ($j >= 0)
        { 
            if (count(array_intersect($array[$i],$array[$j])) == count($array[$i]))
            { 
                unset($array[$i]); break; 
            
            } else $j--;
        }
    }
    return array_values ($array);
}


function setData($array, $fill_key, $query_key, $table)
{
    foreach($array as $key => $item)
    {
        $conditions = count($item);
        $game = new Game();

        for($i = 0; $i < $conditions; $i ++)
        {
            $data[$fill_key . ($i+1)] = $table->where($query_key, $item[$i])->first()->id;
        } 
        $game->fill($data)->save();
    }
}


function getUserStatistics()
{
    if(Score::all()->isEmpty())
    {

        $results = (object)[];

    } else {

    $results = Score::select('user_id','points')
        ->orderBy('points','dec')
        ->get();

    $position = 1;
    $temp_score = $results[0]->points;
    $temp = 0;
    $all = [];
    $arr = [];
    $temp_arr = [];

    foreach($results as $key => $score)
    {

        $score->name = User::all()
        ->where('id', $score->user_id)
        ->first()->name;

        $score->played = Game::select('player_1', 'player_2', 'status')
        ->where('player_1', $score->user_id)->where('status', 1)
        ->orWhere('player_2' , $score->user_id)
        ->where('status', 1)
        ->get()->count() ;

        $score->won = Game::select('player_1', 'player_2', 'status')
        ->where('player_1', $score->user_id)->where('winner', $score->user_id)
        ->orWhere('player_2' , $score->user_id)
        ->where('winner', $score->user_id)
        ->get()->count() ;

        $score->lost = Game::select('player_1', 'player_2', 'status')
        ->where('player_1', $score->user_id)->whereNotIn('winner', [$score->user_id])
        ->orWhere('player_2' , $score->user_id)
        ->whereNotIn('winner', [$score->user_id])
        ->get()->count() ;

        if($score->points < $temp_score)
        {
            $position ++;
            $temp_score = $score->points;
        } 

        $score->position = $position;
    }

    foreach($results as $key => $value)
    {    
        if($value->position !== $temp)
        {
            $temp = $value->position; 
            array_push($arr, $temp);     
        } 
    }

    for($i = 0; $i < count($arr); $i ++)
    {
        foreach($results as $key => $value)
        {
            if($value->position === $arr[$i])
            {
                $value->difference = round((1 - $value->lost / $value->played ) * 100,2);
                array_push($temp_arr,$value);                   
            }
        } 

        uasort($temp_arr, function($a, $b) 
        {
            return $a->difference + $b->difference;
        });

        $all = array_merge ($all , $temp_arr);
        $temp_arr = [];
        }
        $results = Collection::make($all);  
    }
    return $results;                                              
}


function getUsersNotPlayed()
{
    return User::select('name', 'id')->whereNotIn('id', Score::select('user_id')
        ->get()->
        pluck('user_id')
        ->toArray())->get();
}

function addNewPlayerToLeague($new_player)
{
    $users = User::all();
    $new_user_id = $users[$users->count()-1]->id +1;

    foreach($users as $key => $user)
    {
        $game = new Game([

            'player_1' => $new_user_id,
            'player_2' => $user->id
        ]);
  
        $game->save();
    }
}