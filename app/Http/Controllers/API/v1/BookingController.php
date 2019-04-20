<?php

namespace App\Http\Controllers\API\v1;

use App\Models\Booking;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\FileResource;
use App\Http\Resources\UserResource;
use App\Http\Resources\BookingResource;
use Illuminate\Support\Facades\Validator;

class BookingController extends ApiController
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
                'user_id'   	=> 'required|numeric',
                'product_id'   	=> 'required|numeric',
                'start_rent' 	=> 'required|date',
                'total_day'     => 'required|numeric',
                'quantity'      => 'required',
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
        	$checkRental = Booking::where('user_id', '=', $request->user_id)
	                        ->where('product_id', '=', $request->product_id)
	                        ->where( function($q) {
	                            $q->where('status', 'empty')
	                              ->orWhere('status', 'pending');
	                        })
	                        ->get();

	        if ( count( $checkRental ) > 0 ) {
	            $this->code = 400;
	            $this->response->success = false;
	            $this->response->message = 'You have alredy done the ordering process on this product';

	            return response()->json($this->response, $this->code);
	        }
	        else{
	        	$check 	= Booking::select('code')->latest()->first(); 

	            if( $check != null ){
	                $checkCode = $check;
	                $date       = substr($checkCode->code, 4, 8);
	                $queue      = substr($checkCode->code, 12, 4);
	            }
	            else{
	                $checkCode = 'BOOK000000000000';
	                $date       = substr($checkCode, 4, 8);
	                $queue      = substr($checkCode, 12, 4);
	            }

	            $dateNow    = date('dmY');

	            $newCode = '';

	            if ( $date == $dateNow ) {
	                if( $queue < 9 )
	                    $newCode = $dateNow . '000' . $queue+=1;
	                else if( $queue < 99 )
	                    $newCode = $dateNow . '00' . $queue+=1;
	                else if( $queue < 999 )
	                    $newCode = $dateNow . '0' . $queue+=1;
	                else
	                    $newCode = $dateNow . $queue+=1;
	            }
	            else
	                $newCode = $dateNow . '0001';

                $dateAdd = date('Y-m-d', strtotime("+{$request->total_day} days", strtotime($request->start_rent)));

                $booking = Booking::create([
                    'code'          => 'BOOK' . $newCode,
                    'start_rent'    => $request->json('start_rent'),
                    'end_rent'      => $dateAdd,
                    'user_id'       => $request->json('user_id'),
                    'product_id'    => $request->json('product_id'),
                    'quantity'      => $request->json('quantity'),
                    'status'        => Booking::STATUS_PENDING,
                ]);

                $this->code = 201;
                $this->response->message = "Booking Product Telah Berhasil";
	        }
        }

        return response()->json($this->response, $this->code);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $booking = Booking::with(['product' => function($q){
                    $q->with(['file']);
        }])
        ->where('user_id', '=', $id)
        ->orderBy('created_at', 'desc')
        ->get();

        if ($booking) {
            $this->response->data = BookingResource::collection($booking);
        } else {
            $this->code = 404;
            $this->response->success = false;
            $this->response->message = "Data Not Found";
        }

        return response()->json($this->response, $this->code);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function detail($id)
    {
        $booking = Booking::with([  'product' =>    function($q){
            $q->with(['file', 'user']);
        }])->where('id', '=', $id)->get();

        if ($booking) {
            $this->response->data = $booking;
        } else {
            $this->code = 404;
            $this->response->success = false;
            $this->response->message = "Data Not Found";
        }

        return response()->json($this->response, $this->code);
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function cancel(Request $request)
    {
        $validator = Validator::make($request->all(), 
            [
                'booking_id'    => 'required',
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
            $booking            = Booking::find($request->json('booking_id'));
            $booking->status    = Booking::STATUS_CANCELED;
            $booking->save();

            $this->code = 201;
            $this->response->message = "Booking Product Telah Berhasil di Cancel";
        }

        return response()->json($this->response, $this->code);
    }
}
