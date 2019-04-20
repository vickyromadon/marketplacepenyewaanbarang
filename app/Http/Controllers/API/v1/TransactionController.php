<?php

namespace App\Http\Controllers\API\v1;

use App\Models\Booking;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class TransactionController extends ApiController
{
    public function index($id)
    {
        $transaction = DB::table('transactions')
                        ->join('bookings', 'transactions.booking_id', '=', 'bookings.id')
                        ->join('products', 'bookings.product_id', '=', 'products.id')
                        ->join('files', 'products.file_id', '=', 'files.id')
                        ->where('bookings.user_id', $id)
                        ->select(   "transactions.id AS id",
                                    "products.name AS product_name",
                                    "transactions.price AS price",
                                    "transactions.status AS status",
                                    "transactions.payment_method AS payment_method",
                                    "files.path AS path")
                        ->orderBy('transactions.created_at', 'desc')
                        ->get();

        if ($transaction) {
            $this->response->data = $transaction;
        } else {
            $this->code = 404;
            $this->response->success = false;
            $this->response->message = "Data Not Found";
        }

        return response()->json($this->response, $this->code);
    }

    public function getPdf($id)
    {	
    	$transaction = Transaction::find($id);
        view()->share('transaction', $transaction);

        $pdf = PDF::loadView('member.transaction.getPdf');
        return $pdf->download('Agreement Letter Product '. $transaction->booking->product->name .'.pdf');
    }

    public function store(Request $request)
    {
    	$validator = Validator::make($request->all(), 
            [
                'booking_id' 		=> 'required',
                'total_periode' 	=> 'required|numeric',
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
        	$booking = Booking::find($request->booking_id);

        	$transaction = new Transaction();
        	$transaction->booking_id 		= $request->booking_id;
        	$transaction->payment_method 	= 'cod';
        	$transaction->price 			= $booking->product->price;
        	$transaction->time_periode 		= $booking->product->time_periode;
        	$transaction->total_periode 	= $request->total_periode;
        	$transaction->deposite 			= $booking->product->deposite;
        	$transaction->grand_total 		= ($booking->product->price * $request->total_periode) + $booking->product->deposite;
        	$transaction->save();

        	$this->code = 201;
        	$this->response->message = "Transaction Successfully Sent";
        }

        return response()->json($this->response, $this->code);
    }

    public function show($id)
    {
        $transaction = Transaction::with(['booking' => function($q){
        	$q->with(['product' => function($q){
        		$q->with(['user']);
        	}]);
        }])->find($id);

        if ($transaction) {
            $this->response->data = $transaction;
        } else {
            $this->code = 404;
            $this->response->success = false;
            $this->response->message = "Data Not Found";
        }

        return response()->json($this->response, $this->code);
    }
}
