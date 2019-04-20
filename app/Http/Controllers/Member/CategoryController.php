<?php

namespace App\Http\Controllers\Member;

use App\Models\Product;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    public function index($id)
    {
    	$product = Product::where('sub_category_id', '=', $id)
    				->where('status', '=', Product::STATUS_PUBLISH)
    				// ->orderBy('price', 'desc')
    				->orderBy('created_at', 'desc')
    				->paginate(6);

    	return $this->view([
    		'data' => SubCategory::find($id),
    		'products' => $product,
    		'all_products' => Product::orderBy('created_at', 'desc')->take(5)->get(),
    	]);
    }

    public function search(Request $request)
    {
        if( $request->isMethod('post') ){
            // $product = Product::where("name", 'LIKE', "%$request->search%")->paginate(6);
            $product = DB::table('products')
                        ->join('files', 'products.file_id', 'files.id')
                        ->join('sub_categories', 'products.sub_category_id', 'sub_categories.id')
                        ->join('categories', 'sub_categories.category_id', 'categories.id')
                        ->select(   'products.id AS id',
                                    'products.name AS name',
                                    'products.price AS price',
                                    'products.view AS view',
                                    'files.path AS path',
                                    'sub_categories.name AS sub_category_name',
                                    'categories.name AS category_name'
                        )
                        ->where("products.name", 'LIKE', "%$request->search%")
                        ->get();
            return $this->view([
                'products' => $product,
                'search' => $request->search,
                'categories' => Category::all(),
            ]);
        }
    }
}
