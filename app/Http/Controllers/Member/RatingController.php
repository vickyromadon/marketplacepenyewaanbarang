<?php

namespace App\Http\Controllers\Member;

use App\Models\User;
use App\Models\Rating;
use App\Models\Product;
use App\Models\Reversion;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;

class RatingController extends Controller
{
    public function store(Request $request)
    {
    	$validator = $request->validate([
	        'rate'		=> ['required', Rule::in(['1', '2', '3', '4', '5'])],
	        'note' 		=> 'nullable|string',
	    ]);

	    $user 		= User::find($request->user_id);
	    $product 	= Product::find($request->product_id);

	    $rating = new Rating();
	    $rating->rate = $request->rate;
	    $rating->note = $request->note;
	    $rating->user()->associate($user);
	    $rating->product()->associate($product);
	    $rating->save();

	    $reversion = Reversion::find($request->reversion_id);
	    $reversion->status = Reversion::STATUS_PENDING;
	    $reversion->save();

	    return response()->json([
	        'success'   => true,
	        'message'   => 'Rating Berhasil Dikirim.'
	    ]);
    }
}
