<?php

namespace App\Http\Controllers\Member;

use App\Models\Delivery;
use App\Models\Reversion;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class DeliveryController extends Controller
{
    public function index()
    {
    	$delivery = DB::table('deliveries')
    				->join('transactions', 'deliveries.transaction_id', '=', 'transactions.id')
    				->join('bookings', 'transactions.booking_id', '=', 'bookings.id')
    				->join('products', 'bookings.product_id', '=', 'products.id')
    				->join('users', 'bookings.user_id', '=', 'users.id')
    				->select(	"deliveries.id AS id",
    							"bookings.code AS code_booking",
    							"products.name AS product_name",
    							"deliveries.delivery_date AS delivery_date",
    							"deliveries.arrive_date AS arrive_date",
    							"deliveries.status AS status"
    				)
    				->where('users.id', '=', Auth::user()->id)
                    ->orderBy('deliveries.created_at', 'desc')
    				->paginate(10);
    	
    	return $this->view(['data' => $delivery]);
    }

    public function show($id)
    {
    	return $this->view(['data' => Delivery::find($id)]);
    }

    public function arrived(Request $request)
    {
    	$delivery           = Delivery::find($request->arrived_id);
        $delivery->status   = Delivery::STATUS_ARRIVED;
    	$delivery->save();

        $transaction        = Transaction::find($delivery->transaction_id);
        $transaction->note  = 'Product Sudah di Terima Oleh Penyewa Barang';
        $transaction->save();

    	return response()->json([
            'success'   => true,
            'message'   => 'Tiba Berhasil Dikirim.'
        ]);
    }
}
