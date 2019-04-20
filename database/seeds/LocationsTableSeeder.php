<?php

use App\Models\Location;
use Illuminate\Database\Seeder;

class LocationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $location = Location::firstOrCreate(
        	[
        		'title' => 'STMIK - STIE Mikroskil, Jl. MH Thamrin, Pusat Pasar, Medan City, North Sumatra, Indonesia'
        	],
        	[
        		'latitude' => 3.587524,
        		'longitude' => 98.69066010000006
        	]
        );
    }
}
