<?php

use App\Models\Location;
use App\Models\CompanyProfile;
use Illuminate\Database\Seeder;

class CompanyProfilesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$companyProfile = CompanyProfile::firstOrCreate(
    		[ 
    			'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Qui enim voluptatem veniam consequuntur doloribus, ullam maxime dicta totam neque ad eligendi eaque consectetur illo tempore expedita accusamus assumenda, commodi labore?'
    		],
    		[ 
                'phone' => '085261538606',

                'email' => 'mail@rentoncome.com',

    			'terms_of_use' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Qui enim voluptatem veniam consequuntur doloribus, ullam maxime dicta totam neque ad eligendi eaque consectetur illo tempore expedita accusamus assumenda, commodi labore?Lorem ipsum dolor sit amet, consectetur adipisicing elit. Qui enim voluptatem veniam consequuntur doloribus, ullam maxime dicta totam neque ad eligendi eaque consectetur illo tempore expedita accusamus assumenda, commodi labore?Lorem ipsum dolor sit amet, consectetur adipisicing elit. Qui enim voluptatem veniam consequuntur doloribus, ullam maxime dicta totam neque ad eligendi eaque consectetur illo tempore expedita accusamus assumenda, commodi labore?',

    			'privacy_policy' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Qui enim voluptatem veniam consequuntur doloribus, ullam maxime dicta totam neque ad eligendi eaque consectetur illo tempore expedita accusamus assumenda, commodi labore?Lorem ipsum dolor sit amet, consectetur adipisicing elit. Qui enim voluptatem veniam consequuntur doloribus, ullam maxime dicta totam neque ad eligendi eaque consectetur illo tempore expedita accusamus assumenda, commodi labore?Lorem ipsum dolor sit amet, consectetur adipisicing elit. Qui enim voluptatem veniam consequuntur doloribus, ullam maxime dicta totam neque ad eligendi eaque consectetur illo tempore expedita accusamus assumenda, commodi labore?' 
    		]
    	);

        // location attach
        $location = Location::where('title', 'STMIK - STIE Mikroskil, Jl. MH Thamrin, Pusat Pasar, Medan City, North Sumatra, Indonesia')->first();
        $companyProfile->location()->associate($location);
        $companyProfile->save();
    }
}
