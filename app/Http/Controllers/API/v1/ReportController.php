<?php

namespace App\Http\Controllers\api\v1;

use App\Models\User;
use App\Models\Report;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ReportController extends ApiController
{
    public function store(Request $request)
    {
    	$checkReport = Report::where('user_id', $request->user_id)->where('product_id', $request->product_id)->get();

    	if ( count($checkReport) == 0 ) {
    		$validator = Validator::make($request->all(), 
	            [
	                'content'		=> ['required', Rule::in(['option1', 'option2', 'option3', 'option4'])],
			        'user_id' 		=> 'required',
			        'product_id' 	=> 'required',
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
	        	if ( $request->content == 'option1' )
					$contentReport = Report::CONTENT_OPTION_1;
				else if( $request->content == 'option2' )
					$contentReport = Report::CONTENT_OPTION_2;
				else if( $request->content == 'option3' )
					$contentReport = Report::CONTENT_OPTION_3;
				else
					$contentReport = Report::CONTENT_OPTION_4;

				$user 					= User::find($request->user_id);
				$product 				= Product::find($request->product_id);
				$product->total_report += 1;
				$product->save();

				$report 				= new Report();
				$report->content 		= $contentReport;
				$report->user()->associate($user);
				$report->product()->associate($product);
				$report->save();

				$this->code = 201;
            	$this->response->message = "Report Successfully Sent";
	        }
    	}
    	else{
    		$this->code = 201;
            $this->response->message = "You have already reported this product";
    	}

    	return response()->json($this->response, $this->code);
    }
}
