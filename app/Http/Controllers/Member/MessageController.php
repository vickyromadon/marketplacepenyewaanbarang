<?php

namespace App\Http\Controllers\Member;

use App\Models\Message;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MessageController extends Controller
{
    public function index(Request $request)
    {
    	if( $request->isMethod('post') ){
    		$validator = $request->validate([
	    		'name'			=> 'required|string|max:191',
	    		'email' 		=> 'required|email',
	    		'phone' 		=> 'required|string',
	    		'content' 		=> 'required|string',
	    	]);

	    	$message 			= new Message();
	    	$message->name 		= $request->name;
	    	$message->email 	= $request->email;
	    	$message->phone 	= $request->phone;
	    	$message->content 	= $request->content;

	    	if ( $message->save() ) {
	    		return response()->json([
                    'success'   => true,
                    'message'   => 'Pesan berhasil terkirim.'
                ]);
	    	}
	    	else{
	    		return response()->json([
                    'success'   => false,
                    'message'   => 'Pesan gagal terkirim'
                ]);
	    	}
    	}
    	return $this->view();
    }
}
