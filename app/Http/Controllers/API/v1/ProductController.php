<?php

namespace App\Http\Controllers\API\v1;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;

class ProductController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $product =  Product::with(['file', 'user', 'sub_category', 'location'])
                    ->where('status', '=', Product::STATUS_PUBLISH)
                    ->get();

        if ($product->count()) {
            $this->response->data = ProductResource::collection($product);
        } else {
            $this->response->message = "Data Empty";
        }

        return response()->json($this->response, $this->code);
    }

    public function low()
    {
        $product =  Product::with(['file', 'user', 'sub_category', 'location'])
                    ->where('status', '=', Product::STATUS_PUBLISH)
                    ->get();

        if ($product != null) {
            $temp = ProductResource::collection($product);

            $temp = array_values(array_sort($temp, function ($value) {
              return $value['price'];
            }));

            $this->response->data = $temp;
        } else {
            $this->response->message = "Data Empty";
        }

        return response()->json($this->response, $this->code);
    }

    public function high()
    {
        $product =  Product::with(['file', 'user', 'sub_category', 'location'])
                    ->where('status', '=', Product::STATUS_PUBLISH)
                    ->get();

        if ($product->count()) {
            $temp = ProductResource::collection($product);

            $temp = array_reverse(array_sort($temp, function ($value) {
                return $value['price'];
            }));
            
            $this->response->data = $temp;
        } else {
            $this->response->message = "Data Empty";
        }

        return response()->json($this->response, $this->code);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function subcategory($id)
    {
        $product =  Product::with(['file', 'user', 'sub_category', 'location', 'ratings'])
                    ->where('sub_category_id', '=', $id)
                    ->where('status', '=', Product::STATUS_PUBLISH)
                    ->get();

        if ($product->count()) {
            $this->response->data = ProductResource::collection($product);
        } else {
            $this->response->message = "Data Empty";
        }

        return response()->json($this->response, $this->code);
    }

    public function subcategory_low($id)
    {
        $product =  Product::with(['file', 'user', 'sub_category', 'location', 'ratings'])
                    ->where('sub_category_id', '=', $id)
                    ->where('status', '=', Product::STATUS_PUBLISH)
                    ->get();

        if ($product->count()) {
            $temp = ProductResource::collection($product);

            $temp = array_values(array_sort($temp, function ($value) {
              return $value['price'];
            }));

            $this->response->data = $temp;
        } else {
            $this->response->message = "Data Empty";
        }

        return response()->json($this->response, $this->code);
    }

    public function subcategory_high($id)
    {
        $product =  Product::with(['file', 'user', 'sub_category', 'location', 'ratings'])
                    ->where('sub_category_id', '=', $id)
                    ->where('status', '=', Product::STATUS_PUBLISH)
                    ->get();

        if ($product->count()) {
            $temp = ProductResource::collection($product);

            $temp = array_reverse(array_sort($temp, function ($value) {
                return $value['price'];
            }));
            
            $this->response->data = $temp;
        } else {
            $this->response->message = "Data Empty";
        }

        return response()->json($this->response, $this->code);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::with(['file', 'user', 'sub_category', 'location', 'ratings' => function($q){
            $q->with(['user' => function($q){
                $q->with(['file']);
            }]);
        }])->find($id);
        $product->view += 1;
        $product->save();

        if ($product) {
            $this->response->data = $product;
        } else {
            $this->code = 404;
            $this->response->success = false;
            $this->response->message = "Data Not Found";
        }

        return response()->json($this->response, $this->code);
    }
}
