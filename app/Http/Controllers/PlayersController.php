<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Game;
use App\Score;
use App\Helpers;

class PlayersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
   
        $results = getUserStatistics();
        $users_not_played = getUsersNotPlayed();

        return view('players.index', compact('results', 'users_not_played'));     
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('players.create');      
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        addNewPlayerToLeague($request->all()['name']);
        $user = new User($request->all());
        $user->save();
        flash($request->all()['name'] . ' ' . 'Successfully Added'  , 'Success');
        return redirect()->action('PlayersController@index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $current_player = User::first()
        ->where('id', $id)
        ->first();
        $users = [];
        $num = 0 ;
        
        $results = [];
 
        $a = Game::select('player_2 as id', 'status', 'winner')
        ->where('player_1', $id)
        ->get()
        ->toArray();
        $b = Game::select('player_1 as id', 'status', 'winner')
        ->where('player_2', $id)
        ->get()
        ->toArray();

        $merged = array_merge($a, $b);

        foreach($merged as $key => $user)
        {

            $results[$key] = (object)[];
            $results[$key]->id = $user['id'];
            $results[$key]->status = $user['status'];
            $results[$key]->winner = $user['winner'];
            
            if($user['winner']!== null)
            {
                $results[$key]->winner = User::first()
                ->where('id', $user['winner'])
                ->first()->name; 
            
            }

            $results[$key]->name = User::first()
            ->where('id', $user['id'])
            ->first()->name;
            
        }

        uasort($results, function($a, $b) {
        return $a->id - $b->id;
        });

        $results = array_values($results);
        return view('players.show', compact('results','current_player'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
 
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
        $input = $request->all();
        $loser_id = 'id';

        if($input['winner'] ==="")
        {
            flash('Nothing selected', 'Warning');
        
        } else {

        $game = Game::whereIn('player_1', [$input['a'],  $input['b']])
        ->whereIn('player_2',  [$input['a'], $input['b']])->first();

        if($input['winner'] === $input['a'])
        {
            $loser_id = $input['b'];

        } else {

            $loser_id = $input['a'];
        }

        $winner = Score::all()
        ->where('user_id', $input['winner']);

        $loser = Score::all()
        ->where('user_id', $loser_id);

        if($winner->isEmpty())
        {
            $new_winner = new Score();
            $new_winner->fill(
            
            [       
                'user_id' => $input['winner'],
                'points' => 1
            ]);

            $new_winner->save();

        } else {

            $winner->first()->points ++;
            $winner->first()->save();
        }

        if($loser->isEmpty())
        {
            $new_loser = new Score();
            $new_loser->fill(
            
            [       
                'user_id' => $loser_id,
                'points' => 0
            ]);

            $new_loser->save();

            } else {

            $loser->first()->points +0;
            $loser->first()->save();

            }
        
        $game->status = 1;
        $game->winner = $input['winner'];
        $game->save();
        flash('Successfully Updated', 'Success');

        }
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}




  // dd( Score::all()
  //       ->where('user_id', $input['winner']), $input['winner']);


  //       if(empty($winner))
  //       {
  //           $winner = new Score();
  //           $winner->fill(
            
  //           [       
  //               'user_id' => $input['winner'],
  //               'points' => 1
  //           ]);

  //           $loser = new Score();
  //           $loser->fill(
            
  //           [       
  //               'user_id' => $loser_id,
  //               'points' => 0
  //           ]);

  //           $winner->save();
  //           $loser->save();
        
  //       } else {

  //           $loser = Score::all()
  //           ->where('user_id', $loser_id);
  //           dd($loser);

  //           if($loser->isEmpty())
  //           {
  //               $loser = new Score();
  //               $loser->fill(
            
  //           [       
  //               'user_id' => $loser_id,
  //               'points' => 0
  //           ]);

  //           } else{

  //               $loser = $loser->first();
  //           }
        
  //           $winner->points ++;
  //           $loser->points + 0;
  //           $winner->save();
  //           $loser->save();
  //       }

  //       $game->status = 1;
  //       $game->winner = $input['winner'];
  //       $game->save();
  //       flash('Successfully Updated', 'Success');
        
  //       }
