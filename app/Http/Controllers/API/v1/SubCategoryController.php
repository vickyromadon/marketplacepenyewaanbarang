<?php

namespace App\Http\Controllers\API\v1;

use App\Models\SubCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\SubCategoryResource;

class SubCategoryController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subcategory =  SubCategory::with(['category'])->get();

        if ($subcategory->count()) {
            $this->response->data = SubCategoryResource::collection($subcategory);
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
    public function show($id)
    {
        $subcategory = SubCategory::with(['category'])->where('category_id', '=', $id)->get();

        if ($subcategory) {
            $this->response->data = SubCategoryResource::collection($subcategory);
        } else {
            $this->code = 404;
            $this->response->success = false;
            $this->response->message = "Data Not Found";
        }

        return response()->json($this->response, $this->code);
    }
}
