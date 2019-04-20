<?php

namespace App\Http\Controllers\API\v1;

use JWTAuth;
use App\Models\User;
use App\Helpers\MailFailure;
use Illuminate\Http\Request;
use App\Mail\UserConfirmation;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends ApiController
{
	public function register(Request $request){
		$validator = Validator::make($request->all(), 
            [
                'name' => 'required|string|max:255',
	            'email' => 'required|string|email|max:255|unique:users',
	            'password' => 'required|string|min:6|confirmed',
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

            return response()->json($this->response, $this->code);
        }
        else{
        	$user = User::create([
        		'email'		=> $request->json('email'),
        		'name'		=> $request->json('name'),
        		'password' 	=> Hash::make($request->json('password')),
        		'privilege' => "0",
        	]);

            try{
                Mail::send(new UserConfirmation($user));
                if (Mail::failures()) {
                    $body   = (new UserConfirmation( $user ))->render();

                    MailFailure::mail_failure($user->email, $user->name, 'Email Confirmation', $body);
                }
            }catch (\Exception $e){
                Log::error($e->getTraceAsString());
            }

            return $user;
        }
	}

    public function login(Request $request){
    	$validator = Validator::make($request->all(), 
            [
                'email' => 'required',
    			'password' => 'required',
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

            return response()->json($this->response, $this->code);
        }
        else{
            $user = User::where('email', $request->json('email'))->first();

            if ( $user->privilege != 0 ) {
                $this->code = 403;
                $this->response->message = "Forbiden Error";
                return response()->json($this->response, $this->code);
            }

	        $credentials = $request->only('email', 'password');
	        
            try {
	            if (! $token = JWTAuth::attempt($credentials)) {
	                $this->code = 401;
                    $this->response->success = false;
                    $this->response->message = 'Email dan Password Anda Salah';

                    return response()->json($this->response, $this->code);
	            }
	        } catch (JWTException $e) {
	            return response()->json(['error' => 'could_not_create_token'], 500);
	        }

	        return response()->json([
                'access_token'  => $token,
                'token_type'    => 'bearer',
                'user_id'       => $user->id,
            ]);
        }
    }

    /**
     * Change Password.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), 
            [
                'user_id'       => 'required',
                'old_password'  => 'required|string|min:6|max:191',
                'new_password'  => 'required|string|min:6|max:191|confirmed',
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
            $user   = User::find($request->user_id);
            if( !(Hash::check($request->old_password, $user->password)) ){
                return response()->json([
                    'success' => false,
                    'message' => 'Your current password does not matches with the password you provided. Please try again.',
                ]);
            }

            $user->password = Hash::make($request->new_password);
            $user->save();

            $this->code = 201;
            $this->response->message = "Password Berhasil di Ubah";
        }

        return response()->json($this->response, $this->code);
    }
}
