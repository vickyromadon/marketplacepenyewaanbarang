<?php

namespace App\Http\Controllers\API\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use JWTAuth;
use Exception;

class ApiController extends Controller
{
    public $response;
    public $code;

	/**
     * Create a new instance.
     *
     * @return void
     */
    public function __construct()
    {
    	// $this->middleware('jwt.auth', ['except' => ['login', 'register',]]);

        $this->response = new \stdClass();
        $this->response->success = true;
        $this->response->error = [];
        $this->response->data = [];
        $this->response->message = '';
        $this->code = 200;
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\Guard
     */
    public function guard()
    {
        return Auth::guard('api');
    }

    
}
