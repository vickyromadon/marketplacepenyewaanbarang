<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
    	if( $request->isMethod('post') ){
            $search;
            $start = $request->start;
            $length = $request->length;

            if( !empty($request->search) )
                $search = $request->search['value'];
            else
                $search = null;

            $column = [
                "name",
                "description",
                "created_at",
            ];

            $total = Category::where("name", 'LIKE', "%$search%")
            		->orWhere("description", 'LIKE', "%$search%")
            		->count();

            $data = Category::where("name", 'LIKE', "%$search%")
            		->orWhere("description", 'LIKE', "%$search%")
                    ->orderBy($column[$request->order[0]['column'] - 1], $request->order[0]['dir'])
                    ->skip($start)
                    ->take($length)
                    ->get();

            $response = [
                'data' => $data,
                'draw' => intval($request->draw),
                'recordsTotal' => $total,
                'recordsFiltered' => $total
            ];

           return response()->json($response);
    	}
    	return $this->view();
    }

    public function store(Request $request)
    {
    	$validator = $request->validate([
    		'name'			=> 'required|string',
    		'description'	=> 'nullable|string',
    	]);

    	$category 				= new Category();
    	$category->name 		= $request->name;
    	$category->description 	= $request->description;

    	if( $category->save() ){
	    	return response()->json([
	            'success'   => true,
	            'message'   => 'Category Successfully Added'
	        ]);
    	}
    	else{
    		return response()->json([
	            'success'   => false,
	            'message'   => 'Category Not Successfully Added'
	        ]);
    	}		
    }

    public function update(Request $request, $id)
    {
    	$validator = $request->validate([
    		'name'	=> 'required|string',
    		'description'	=> 'required|string',
    	]);

    	$category 			= Category::find($id);
    	$category->name 	= $request->name;
    	$category->description 	= $request->description;
     	
     	if( $category->save() ){
	    	return response()->json([
	            'success'	=> true,
	            'message'	=> 'Category Successfully Updated'
	        ]);
     	}
     	else{
     		return response()->json([
	            'success'	=> false,
	            'message'	=> 'Category Not Successfully Updated'
	        ]);	
     	}
    }

    public function destroy($id)
    {
        $checkProduct = DB::table('categories')
                        ->join('products', 'categories.id', '=', 'products.category_id')
                        ->where('categories.id', '=', $id)
                        ->select('*')
                        ->get();
        
        if( count($checkProduct) == 0 ){
        	$category = Category::find($id);
        	if( $category->delete() ){
    	    	return response()->json([
    	            'success'	=> true,
    	            'message'	=> 'Category Successfully Deleted'
    	        ]);
        	}
        	else{
        		return response()->json([
    	            'success'	=> false,
    	            'message'	=> 'Category Not Successfully Deleted'
    	        ]);	
        	}
        }
        else{
            return response()->json([
                'success'   => false,
                'message'   => 'Category Not Successfully Deleted, because it is still in use'
            ]); 
        }
    }
}
