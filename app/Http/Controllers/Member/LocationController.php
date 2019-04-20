<?php

namespace App\Http\Controllers\Member;

use App\Models\Product;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class LocationController extends Controller
{
    public function index(Request $request)
    {
        if( $request->isMethod('post') ){
            // return $request;
    		$lat = $request->latitude;
    		$lng = $request->longitude;
    		$radius = $request->radius != null ? $request->radius : 0;
            
            $location = DB::table('locations')
                        ->join('products', 'locations.id', '=', 'products.location_id')
                        ->join('files', 'products.file_id', '=', 'files.id')
                        ->join('users', 'products.user_id', '=', 'users.id')
                        ->selectRaw(" 
                                        (locations.latitude * radians(1)) AS lat1, 
                                        (locations.longitude * radians(1)) AS lng1, 
                                        ({$lat} * radians(1)) AS lat2, 
                                        ({$lng} * radians(1)) AS lng2, 
                                        (({$lng} * radians(1)) - (locations.longitude * radians(1))) * cos(((locations.latitude * radians(1)) + ({$lat} * radians(1)))/2) AS tempX,
                                        ({$lat} * radians(1)) - (locations.latitude * radians(1)) AS tempY,
                                        SQRT( ( ((({$lng} * radians(1)) - (locations.longitude * radians(1))) * cos(((locations.latitude * radians(1)) + ({$lat} * radians(1)))/2)) * ((({$lng} * radians(1)) - (locations.longitude * radians(1))) * cos(((locations.latitude * radians(1)) + ({$lat} * radians(1)))/2)) ) + ( (({$lat} * radians(1)) - (locations.latitude * radians(1))) * (({$lat} * radians(1)) - (locations.latitude * radians(1))) ) ) * 6371 AS distance, 
                                        users.name AS owner_name, 
                                        products.id AS product_id, 
                                        products.name AS product_name, 
                                        products.price AS product_price, 
                                        locations.title AS product_address, 
                                        files.path AS path
                                    ")
                        ->having( 'distance', '<', $radius)
                        ->where('products.sub_category_id', '=', $request->sub_category)
                        ->orderBy( 'distance', 'asc' )
                        // ->limit(5)
                        ->get();      

    		// dd($location);

    		$data           = Product::get();
            $categories     = Category::all();
            $subCategories  = SubCategory::all();

    		return view('member.location.index', compact('location', 'data', 'categories', 'subCategories'));
    	}

    	return $this->view([
                                'data'          => Product::get(),
                                'categories'    => Category::all(),
                                'subCategories' => SubCategory::all(),
                            ]);
    }
}
