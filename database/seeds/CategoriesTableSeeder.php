<?php

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $category = Category::firstOrCreate(
    		[ 
    			'name' => 'Musical Instruments'
    		]
    	);

    	$category = Category::firstOrCreate(
    		[ 
    			'name' => 'Electronics & Appliances'
    		]
    	);

    	$category = Category::firstOrCreate(
    		[ 
    			'name' => 'Vehicles'
    		]
    	);

    	$category = Category::firstOrCreate(
    		[ 
    			'name' => 'Property'
    		]
    	);

    	$category = Category::firstOrCreate(
    		[ 
    			'name' => 'Furnitures'
    		]
    	);

    	$category = Category::firstOrCreate(
    		[ 
    			'name' => 'Audio Visual Equipment'
    		]
    	);

    	$category = Category::firstOrCreate(
    		[ 
    			'name' => 'Office Furniture'
    		]
    	);

    	$category = Category::firstOrCreate(
    		[ 
    			'name' => 'Costumes, Dresses and Accessories'
    		]
    	);

    	$category = Category::firstOrCreate(
    		[ 
    			'name' => 'Baby Accessories and Toys'
    		]
    	);

    	$category = Category::firstOrCreate(
    		[ 
    			'name' => 'Event and Wedding Supplies'
    		]
    	);

    	$category = Category::firstOrCreate(
    		[ 
    			'name' => 'Adventure Gear'
    		]
    	);

    	$category = Category::firstOrCreate(
    		[ 
    			'name' => 'Medical Supplies'
    		]
    	);
    }
}
