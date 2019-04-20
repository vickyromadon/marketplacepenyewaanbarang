<?php

namespace App\Http\Controllers\Member;

use App\Models\User;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    public function index($id)
    {
    	$product 		= Product::find($id);
    	$product->view += 1;
    	$product->save();
    	
    	return $this->view(['data' => $product]);
    }

    public function owner($id)
    {
    	$owner = User::find($id);

        $product = Product::where('user_id', $id)->paginate(6);

    	return $this->view([
            'data' => $owner,
            'products' => $product
        ]);
    }
}
