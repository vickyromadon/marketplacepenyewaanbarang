<?php

namespace App\Http\Controllers\Owner;

use App\Models\Booking;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
    	if( $request->isMethod('post') ){
    		$search;
            $start = $request->start;
            $length = $request->length;

            if( !empty($request->search) )
                $search = $request->search['value'];
            else
                $search = null;

            $column = [
                "code_booking",
                "payment_method",
                "product_name",
                "start_rent",
                "end_rent",
                "user_name",
            ];

            $total = DB::table('transactions')->join('bookings', 'transactions.booking_id', '=', 'bookings.id')
            			->join('products', 'bookings.product_id', '=', 'products.id')
            			->join('users', 'bookings.user_id', '=', 'users.id')
                        // ->where( function($q) use ($search){
                        //     $q->where('transactions.status', '=', Transaction::STATUS_PENDING)
                        //     ->orWhere('transactions.status', '=', Transaction::STATUS_VERIFIED);
                        // })
                        ->where( function($q) use ($search) {
                            $q->where("bookings.code", 'LIKE', "%$search%")
                            ->orWhere("products.name", 'LIKE', "%$search%");
                        })
                        // ->where('transactions.status_payment', '<>', Transaction::STATUS_VERIFIED)
                        ->where('transactions.payment_method', '=', Transaction::METHODE_PAYMENT_REKBER)
                        ->where('products.user_id', '=', Auth::user()->id)
                        ->orderBy('transactions.created_at', 'desc')
	            		->count();

	        $data = DB::table('transactions')->join('bookings', 'transactions.booking_id', '=', 'bookings.id')
            			->join('products', 'bookings.product_id', '=', 'products.id')
            			->join('users', 'bookings.user_id', '=', 'users.id')
            			->select(	"transactions.id AS id",
            						"transactions.payment_method AS payment_method",
            						"transactions.status AS status",
            						"bookings.code AS code_booking",
            						"bookings.start_rent AS start_rent",
            						"bookings.end_rent AS end_rent",
            						"products.name AS product_name",
            						"users.name AS user_name",
                                    "transactions.status_payment AS status_payment"
                                )
                        // ->where( function($q) use ($search){
                        //     $q->where('transactions.status', '=', Transaction::STATUS_PENDING)
                        //     ->orWhere('transactions.status', '=', Transaction::STATUS_VERIFIED);
                        // })
                        ->where( function($q) use ($search) {
                            $q->where("bookings.code", 'LIKE', "%$search%")
                            ->orWhere("products.name", 'LIKE', "%$search%");
                        })
                        // ->where('transactions.status_payment', '<>', Transaction::STATUS_VERIFIED)
                        ->where('transactions.payment_method', '=', Transaction::METHODE_PAYMENT_REKBER)
                        ->where('products.user_id', '=', Auth::user()->id)
                        ->orderBy('transactions.created_at', 'desc')
                        ->orderBy($column[$request->order[0]['column'] - 1], $request->order[0]['dir'])
	                    ->skip($start)
	                    ->take($length)
	                    ->get();

	        $response = [
                'data' => $data,
                'draw' => intval($request->draw),
                'recordsTotal' => $total,
                'recordsFiltered' => $total
            ];

           return response()->json($response);
    	}

    	return $this->view();
    }

    public function show($id)
    {
        return $this->view(['data' => Transaction::find($id)]);
    }

    public function verify(Request $request)
    {
        $transaction                    = Transaction::find($request->verify_id);
        $transaction->status            = Transaction::STATUS_VERIFIED;
        $transaction->status_payment    = Transaction::STATUS_PAYMENT_EMPTY;
        $transaction->note              = $request->note;
        $transaction->save();

        return response()->json([
            'success'  => true,
            'message'  => 'REKBER Successfully Verified'
        ]);
    }

    public function reject(Request $request)
    {
        $transaction            = Transaction::find($request->reject_id);
        $transaction->status    = Transaction::STATUS_REJECTED;
        $transaction->note      = $request->note;
        $transaction->save();

        return response()->json([
            'success'  => true,
            'message'  => 'REKBER Successfully Rejected'
        ]);
    }

    public function cancel(Request $request)
    {
        $transaction            = Transaction::find($request->cancel_id);
        $transaction->status    = Transaction::STATUS_CANCELED;
        $transaction->note      = $request->note;
        $transaction->save();

        return response()->json([
            'success'  => true,
            'message'  => 'REKBER Successfully Canceled'
        ]);
    }
}
