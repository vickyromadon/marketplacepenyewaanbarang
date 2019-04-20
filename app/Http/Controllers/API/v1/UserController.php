<?php

namespace App\Http\Controllers\API\v1;

use App\Models\User;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Http\Resources\ProductResource;
use Illuminate\Support\Facades\Validator;

class UserController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user =  User::with('file')->get();

        if ($user->count()) {
            $this->response->data = UserResource::collection($user);
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
        $user = User::with(['file'])->find($id);

        if ($user) {
            $this->response->data = new UserResource($user);
        } else {
            $this->code = 404;
            $this->response->success = false;
            $this->response->message = "Data Not Found";
        }

        return response()->json($this->response, $this->code);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function product($id)
    {
        $product =  Product::with(['file', 'user', 'sub_category', 'location'])
                    ->where('status', '=', Product::STATUS_PUBLISH)
                    ->where('user_id', '=', $id)
                    ->get();

        if ($product->count()) {
            $this->response->data = ProductResource::collection($product);
        } else {
            $this->response->message = "Data Empty";
        }

        return response()->json($this->response, $this->code);
    }

    public function update(Request $request, $id)
    {   
        $validator = Validator::make($request->all(), 
            [
                'name'          => 'nullable|string|max:191',
                'phone'         => ['nullable', 'string', 'phone:ID', Rule::unique('users')->ignore($id)],
                'address'       => 'nullable|string',
                'birthplace'    => 'nullable|string',
                'birthdate'     => 'nullable|date',
                'gender'        => 'nullable|in:Male,Female',
                // 'religion'      => 'nullable|in:Islam,Kristen Protestan,Katolik,Hindu,Buddha,Kong Hu Cu',
            ]
        );

        if ($validator->fails()) {
        
            $errors = [];
            foreach ($validator->errors()->getMessages() as $field => $message) {
                $errors[] = [
                    'field' => $field,
                    'message' => $message[0],
                ];
            }
            
            $this->code = 422;
            $this->response->success = false;
            $this->response->error = $errors;
        } else {
            $user               = User::find($id);
            $user->name         = $request->json('name');
            $user->phone        = $request->json('phone');
            $user->address      = $request->json('address');
            $user->birthplace   = $request->json('birthplace');
            $user->birthdate    = $request->json('birthdate');
            $user->gender       = $request->json('gender');
            // $user->religion     = $request->json('religion');
            $user->age          = (getdate()['year']) - substr($request->birthdate, 0, 4);
            $user->save();

            $this->code = 201;
            $this->response->message = "Profile Berhasil di Update";
        }
        return response()->json($this->response, $this->code);
    }
}
