<?php

namespace App\Http\Controllers\Admin;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class PaymentConfirmationController extends Controller
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
                "product_name",
                "member_name",
                "transfer_date",
                "status_payment"
            ];

            $total = DB::table('transactions')->join('bookings', 'transactions.booking_id', '=', 'bookings.id')
             			->join('products', 'bookings.product_id', '=', 'products.id')
             			->join('users', 'bookings.user_id', '=', 'users.id')
             			->where( function($q) use ($search){
	                        $q->where("bookings.code", 'LIKE', "%$search%")
	                        ->orWhere("products.name", 'LIKE', "%$search%")
	                        ->orWhere("users.name", 'LIKE', "%$search%");
	                    })
                        ->where( function($q) use ($search){
                            $q->where('transactions.status_payment', '=', Transaction::STATUS_PAYMENT_PENDING)
                            ->orWhere('transactions.status_payment', '=', Transaction::STATUS_PAYMENT_VERIFIED);
                        })
	            		->count();

	        $data = DB::table('transactions')->join('bookings', 'transactions.booking_id', '=', 'bookings.id')
             			->join('products', 'bookings.product_id', '=', 'products.id')
             			->join('users', 'bookings.user_id', '=', 'users.id')
             			->select(	"transactions.id AS id",
             						"bookings.code AS code_booking",
             						"products.name AS product_name",
             						"users.name AS member_name",
             						"transactions.transfer_date AS transfer_date",
                                    "transactions.status_payment AS status_payment"
             			)
                        ->where( function($q) use ($search){
	                        $q->where("bookings.code", 'LIKE', "%$search%")
	                        ->orWhere("products.name", 'LIKE', "%$search%")
	                        ->orWhere("users.name", 'LIKE', "%$search%");
	                    })
             			->where( function($q) use ($search){
                            $q->where('transactions.status_payment', '=', Transaction::STATUS_PAYMENT_PENDING)
                            ->orWhere('transactions.status_payment', '=', Transaction::STATUS_PAYMENT_VERIFIED);
                        })
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
        $transaction->status            = Transaction::STATUS_APPROVED;
        $transaction->status_payment    = Transaction::STATUS_PAYMENT_APPROVED;
        $transaction->note              = 'Terima kasih, uang ada sudah masuk ke rekening bersama RentOnCome silahkan konfirmasi alamat untuk proses pengiriman barang';
        $transaction->save();

        return response()->json([
            'success'  => true,
            'message'  => 'Transaction Successfully Approved'
        ]);
    }

    public function reject(Request $request)
    {
        $transaction                    = Transaction::find($request->reject_id);
        $transaction->status_payment    = Transaction::STATUS_PAYMENT_REJECTED;
        $transaction->note              = $request->note;
        $transaction->save();

        return response()->json([
            'success'  => true,
            'message'  => 'Transaction Successfully Rejected'
        ]);
    }
}
