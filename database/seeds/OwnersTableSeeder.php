<?php

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class OwnersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(User::where('email','owner1@gmail.com')->first() === null){
            $user 				= new User();
            $user->name 	 	= 'Owner 1';
            $user->email    	= 'owner1@gmail.com';
            $user->password 	= Hash::make('password');
            $user->privilege 	= '1';
            $user->status 		= 'confirm';
            $user->save();
        }

        if(User::where('email','owner2@gmail.com')->first() === null){
            $user 				= new User();
            $user->name 	 	= 'Owner 2';
            $user->email    	= 'owner2@gmail.com';
            $user->password 	= Hash::make('password');
            $user->privilege 	= '1';
            $user->status 		= 'confirm';
            $user->save();
        }

        if(User::where('email','owner3@gmail.com')->first() === null){
            $user 				= new User();
            $user->name 	 	= 'Owner 3';
            $user->email    	= 'owner3@gmail.com';
            $user->password 	= Hash::make('password');
            $user->privilege 	= '1';
            $user->status 		= 'not active';
            $user->save();
        }

        if(User::where('email','owner4@gmail.com')->first() === null){
            $user 				= new User();
            $user->name 	 	= 'Owner 4';
            $user->email    	= 'owner4@gmail.com';
            $user->password 	= Hash::make('password');
            $user->privilege 	= '1';
            $user->status 		= 'not active';
            $user->save();
        }

        if(User::where('email','owner5@gmail.com')->first() === null){
            $user 				= new User();
            $user->name 	 	= 'Owner 5';
            $user->email    	= 'owner5@gmail.com';
            $user->password 	= Hash::make('password');
            $user->privilege 	= '1';
            $user->status 		= 'confirm';
            $user->save();
        }

        if(User::where('email','owner6@gmail.com')->first() === null){
            $user 				= new User();
            $user->name 	 	= 'Owner 6';
            $user->email    	= 'owner6@gmail.com';
            $user->password 	= Hash::make('password');
            $user->privilege 	= '1';
            $user->status 		= 'confirm';
            $user->save();
        }

        if(User::where('email','owner7@gmail.com')->first() === null){
            $user 				= new User();
            $user->name 	 	= 'Owner 7';
            $user->email    	= 'owner7@gmail.com';
            $user->password 	= Hash::make('password');
            $user->privilege 	= '1';
            $user->status 		= 'unconfirm';
            $user->save();
        }

        if(User::where('email','owner8@gmail.com')->first() === null){
            $user 				= new User();
            $user->name 	 	= 'Owner 8';
            $user->email    	= 'owner8@gmail.com';
            $user->password 	= Hash::make('password');
            $user->privilege 	= '1';
            $user->status 		= 'unconfirm';
            $user->save();
        }
    }
}
