<?php

namespace App\Http\Controllers\Admin;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class RekberController extends Controller
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
            ];

            $total = DB::table('transactions')->join('bookings', 'transactions.booking_id', '=', 'bookings.id')
            			->join('products', 'bookings.product_id', '=', 'products.id')
            			->join('users', 'bookings.user_id', '=', 'users.id')
                        ->where('transactions.payment_method', '=', Transaction::METHODE_PAYMENT_REKBER)
	            		->where( function($q) use ($search) {
                            $q->where("bookings.code", 'LIKE', "%$search%")
                            ->orWhere("products.name", 'LIKE', "%$search%");
                        })
                        ->count();

	        $data = DB::table('transactions')->join('bookings', 'transactions.booking_id', '=', 'bookings.id')
            			->join('products', 'bookings.product_id', '=', 'products.id')
            			->join('users', 'bookings.user_id', '=', 'users.id')
            			->select(	"transactions.id AS id",
            						"bookings.code AS code_booking",
            						"bookings.start_rent AS start_rent",
            						"bookings.end_rent AS end_rent",
            						"products.name AS product_name"
                                )
                        ->where('transactions.payment_method', '=', Transaction::METHODE_PAYMENT_REKBER)
                        ->where( function($q) use ($search) {
                            $q->where("bookings.code", 'LIKE', "%$search%")
                            ->orWhere("products.name", 'LIKE', "%$search%");
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
}
