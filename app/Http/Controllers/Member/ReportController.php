<?php

namespace App\Http\Controllers\Member;

use App\Models\User;
use App\Models\Report;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;

class ReportController extends Controller
{
    public function store(Request $request)
    {
    	$checkReport = Report::where('user_id', $request->id_user)->where('product_id', $request->id_product)->get();

    	if ( count($checkReport) == 0 ) {
			$validator = $request->validate([
		        'content'		=> ['required', Rule::in(['option1', 'option2', 'option3', 'option4'])],
		        'id_user' 		=> 'required',
		        'id_product' 	=> 'required',	
		    ]);

			if ( $request->content == 'option1' )
				$contentReport = Report::CONTENT_OPTION_1;
			else if( $request->content == 'option2' )
				$contentReport = Report::CONTENT_OPTION_2;
			else if( $request->content == 'option3' )
				$contentReport = Report::CONTENT_OPTION_3;
			else
				$contentReport = Report::CONTENT_OPTION_4;

			$user 					= User::find($request->id_user);
			$product 				= Product::find($request->id_product);
			$product->total_report += 1;
			$product->save();

			$report 				= new Report();
			$report->content 		= $contentReport;
			$report->user()->associate($user);
			$report->product()->associate($product);
			$report->save();

			return response()->json([
		        'success'   => true,
		        'message'   => 'Laporan Berhasil Dikirim.'
		    ]);
    	}
    	else{
    		return response()->json([
		        'success'   => false,
		        'message'   => 'Anda telah melaporkan produk ini.'
		    ]);	
    	}

    }
}
