<?php

namespace App\Http\Controllers\API\v1;

use App\Models\Message;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class MessageController extends ApiController
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), 
            [
                'name'			=> 'required|string|max:191',
	    		'email' 		=> 'required|email',
	    		'phone' 		=> 'required|string',
	    		'content' 		=> 'required|string',
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
        	$message = Message::create([
        		'name' 		=> $request->json('name'),
        		'email' 	=> $request->json('email'),
        		'phone' 	=> $request->json('phone'),
        		'content' 	=> $request->json('content'),
        	]);

            $this->code = 201;
            $this->response->message = "Message Berhasil di Kirim";
        }

        return response()->json($this->response, $this->code);
    }
}
