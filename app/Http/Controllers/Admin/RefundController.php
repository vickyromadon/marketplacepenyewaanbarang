<?php

namespace App\Http\Controllers\Admin;

use App\Models\Refund;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class RefundController extends Controller
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
                "created_at",
                "status"
            ];

            $total = DB::table('refunds')
                        ->join('transactions', 'refunds.transaction_id', '=', 'transactions.id')
                        ->join('bookings', 'transactions.booking_id', '=', 'bookings.id')
                        ->join('products', 'bookings.product_id', '=', 'products.id')
                        ->join('users', 'products.user_id', '=', 'users.id')
                        ->where('refunds.status', '<>', Refund::STATUS_PENDING)
                        ->where( function($q) use ($search) {
                            $q->where("bookings.code", 'LIKE', "%$search%")
                            ->orWhere("products.name", 'LIKE', "%$search%");
                        })
                        ->count();

            $data = DB::table('refunds')
                        ->join('transactions', 'refunds.transaction_id', '=', 'transactions.id')
                        ->join('bookings', 'transactions.booking_id', '=', 'bookings.id')
                        ->join('products', 'bookings.product_id', '=', 'products.id')
                        ->join('users', 'products.user_id', '=', 'users.id')
                        ->select(   "refunds.id AS id",
                                    "bookings.code AS code_booking",
                                    "products.name AS product_name",
                                    "users.name AS owner_name",
                                    "refunds.created_at AS created_at",
                                    "refunds.status AS status"
                        )
                        ->where('refunds.status', '<>', Refund::STATUS_PENDING)
                        ->where( function($q) use ($search) {
                            $q->where("bookings.code", 'LIKE', "%$search%")
                            ->orWhere("products.name", 'LIKE', "%$search%");
                        })
                        ->orderBy('refunds.created_at', 'desc')
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
    	return $this->view(['data' => Refund::find($id)]);
    }

    public function finished(Request $request)
    {
        $refund             = Refund::find($request->id);
        $refund->status     = Refund::STATUS_FINISHED;
        $refund->save();

        return response()->json([
            'success'   => true,
            'message'   => 'Refund Finished Successfully'
        ]);
    }
}
