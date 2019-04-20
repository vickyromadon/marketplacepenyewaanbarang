<?php

namespace App\Http\Controllers\API\v1;

use App\Models\User;
use App\Models\Rating;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class RatingController extends ApiController
{
    public function store(Request $request)
    {
	    $validator = Validator::make($request->all(), 
            [
                'rate'			    => ['required', Rule::in(['1', '2', '3', '4', '5'])],
		        'note' 			    => 'required|string',
		        'user_id' 		    => 'required',
		        'product_id' 	    => 'required',
                'transaction_id'    => 'required', 
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
        }
        else{
        	$user 		= User::find($request->user_id);
		    $product 	= Product::find($request->product_id);

		    $rating = new Rating();
		    $rating->rate = $request->rate;
		    $rating->note = $request->note;
		    $rating->user()->associate($user);
		    $rating->product()->associate($product);
		    $rating->save();

            $transaction = Transaction::find($request->transaction_id);
            $transaction->status    = Transaction::STATUS_APPROVED;
            $transaction->note      = 'Transaksi Selesai, Terima Kasih';
            $transaction->save();
		    
		    $this->code = 201;
        	$this->response->message = "Rating Berhasil";
        }

        return response()->json($this->response, $this->code);
    }
}
