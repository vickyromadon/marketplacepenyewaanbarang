<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class SubCategoryController extends Controller
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
            	"booking_number",
            	"fee",
                "created_at",
            ];

            $total = SubCategory::with([ 'category' ])
                    ->where("name", 'LIKE', "%$search%")
                    ->count();

            $data = SubCategory::with([ 'category' ])
                    ->where("name", 'LIKE', "%$search%")
                    ->orderBy($column[$request->order[0]['column'] - 1], $request->order[0]['dir'])
                    ->skip($start)
                    ->take($length)
                    ->get();

            $response = [
                'data'  =>  $data,
                'draw' => intval($request->draw),
                'recordsTotal' => $total,
                'recordsFiltered' => $total
            ];

            return response()->json($response);
    	}

    	return $this->view(['categories' => Category::all()]);
    }

 	public function store(Request $request)
    {
    	$validator = $request->validate([
    		'name'			=> 'required|string',
    		'category'		=> 'required',
    	]);

    	$subCategory 				= new SubCategory();
    	$subCategory->name 			= $request->name;
    	$subCategory->category_id 	= $request->category;

    	if( $subCategory->save() ){
	    	return response()->json([
	            'success'   => true,
	            'message'   => 'Sub Category Successfully Added'
	        ]);
    	}
    	else{
    		return response()->json([
	            'success'   => false,
	            'message'   => 'Sub Category Not Successfully Added'
	        ]);
    	}		
    }

    public function update(Request $request, $id)
    {
    	$validator = $request->validate([
    		'name'		=> 'required|string',
    		'category'	=> 'required',
    	]);

    	$category 			       = SubCategory::find($id);
    	$category->name 	       = $request->name;
    	$category->category_id     = $request->category;
     	
     	if( $category->save() ){
	    	return response()->json([
	            'success'	=> true,
	            'message'	=> 'SubCategory Successfully Updated'
	        ]);
     	}
     	else{
     		return response()->json([
	            'success'	=> false,
	            'message'	=> 'SubCategory Not Successfully Updated'
	        ]);	
     	}
    }

    public function destroy($id)
    {
        $checkProduct = DB::table('sub_categories')
                        ->join('products', 'sub_categories.id', '=', 'products.sub_category_id')
                        ->where('sub_categories.id', '=', $id)
                        ->select('*')
                        ->get();
        
        if( count($checkProduct) == 0 ){
        	$subCategory = SubCategory::find($id);
        	if( $subCategory->delete() ){
    	    	return response()->json([
    	            'success'	=> true,
    	            'message'	=> 'SubCategory Successfully Deleted'
    	        ]);
        	}
        	else{
        		return response()->json([
    	            'success'	=> false,
    	            'message'	=> 'SubCategory Not Successfully Deleted'
    	        ]);	
        	}
        }
        else{
            return response()->json([
                'success'   => false,
                'message'   => 'SubCategory Not Successfully Deleted, because it is still in use'
            ]); 
        }
    }
}
