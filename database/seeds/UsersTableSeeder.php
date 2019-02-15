<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
		public function run()
	{
	  // factory(App\User::class, 10)->create();

	$users = User::all();
    $names = 
    [
        "Rob Adams","Mark Adams","Scott Insley","Diane Barley","James Tierney",
        "Sharon Daws","Rob Milward","Steve Cooke","John Borthwick",
        "Lucy Cousins","Laura Carr","Mike Santopietro","Ian Walker",
        "Jason Williams","Andrew Gibson","Chloe Santopietro",
        "Rob Allport", "Karen Sutton","Adam Jones","Joe Townsend",
        "Ellie Hammond","Hayley Harrison","Kerry Maidwell",
        "Steve Shields","Joe Wadsworth","Matthew Barlow","James Lovatt","Daryl Tavernor"           
    ];

    foreach($names as $key => $name)
    {
        $user = new User([ 'name' => $name ]);
        $user->save();
    }

	}
}
