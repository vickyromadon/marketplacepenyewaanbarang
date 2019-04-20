<?php

namespace App\Http\Controllers\API\v1;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;

class CategoryController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $category =  Category::get();

        if ($category->count()) {
            $this->response->data = CategoryResource::collection($category);
        } else {
            $this->response->message = "Data Empty";
        }

        return response()->json($this->response, $this->code);
    }
}
