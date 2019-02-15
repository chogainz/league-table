<?php

use Illuminate\Database\Seeder;
use App\User;

class GamesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = removeDuplicates(permutations(User::all()));
        setData($users, 'player_', 'id', User::all());
    }
}








