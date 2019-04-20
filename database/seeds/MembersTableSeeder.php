<?php

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class MembersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(User::where('email','member1@gmail.com')->first() === null){
            $user 				= new User();
            $user->name 	 	= 'Member 1';
            $user->email    	= 'member1@gmail.com';
            $user->password 	= Hash::make('password');
            $user->privilege 	= '0';
            $user->status 		= 'confirm';
            $user->save();
        }

        if(User::where('email','member2@gmail.com')->first() === null){
            $user 				= new User();
            $user->name 	 	= 'Member 2';
            $user->email    	= 'member2@gmail.com';
            $user->password 	= Hash::make('password');
            $user->privilege 	= '0';
            $user->status 		= 'confirm';
            $user->save();
        }

        if(User::where('email','member3@gmail.com')->first() === null){
            $user 				= new User();
            $user->name 	 	= 'Member 3';
            $user->email    	= 'member3@gmail.com';
            $user->password 	= Hash::make('password');
            $user->privilege 	= '0';
            $user->status 		= 'not active';
            $user->save();
        }

        if(User::where('email','member4@gmail.com')->first() === null){
            $user 				= new User();
            $user->name 	 	= 'Member 4';
            $user->email    	= 'member4@gmail.com';
            $user->password 	= Hash::make('password');
            $user->privilege 	= '0';
            $user->status 		= 'not active';
            $user->save();
        }

        if(User::where('email','member5@gmail.com')->first() === null){
            $user 				= new User();
            $user->name 	 	= 'Member 5';
            $user->email    	= 'member5@gmail.com';
            $user->password 	= Hash::make('password');
            $user->privilege 	= '0';
            $user->status 		= 'confirm';
            $user->save();
        }

        if(User::where('email','member6@gmail.com')->first() === null){
            $user 				= new User();
            $user->name 	 	= 'Member 6';
            $user->email    	= 'member6@gmail.com';
            $user->password 	= Hash::make('password');
            $user->privilege 	= '0';
            $user->status 		= 'confirm';
            $user->save();
        }

        if(User::where('email','member7@gmail.com')->first() === null){
            $user 				= new User();
            $user->name 	 	= 'Member 7';
            $user->email    	= 'member7@gmail.com';
            $user->password 	= Hash::make('password');
            $user->privilege 	= '0';
            $user->status 		= 'unconfirm';
            $user->save();
        }

        if(User::where('email','member8@gmail.com')->first() === null){
            $user 				= new User();
            $user->name 	 	= 'Member 8';
            $user->email    	= 'member8@gmail.com';
            $user->password 	= Hash::make('password');
            $user->privilege 	= '0';
            $user->status 		= 'unconfirm';
            $user->save();
        }
    }
}
