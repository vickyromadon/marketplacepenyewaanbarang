<?php

namespace App\Http\Controllers\Member;

use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class StoryController extends Controller
{
    public function index(){
    	$rating = Rating::where('user_id', Auth::user()->id)
    				->paginate(8);

    	// dd($rating);

    	return $this->view(['data' => $rating]);
    }
}
