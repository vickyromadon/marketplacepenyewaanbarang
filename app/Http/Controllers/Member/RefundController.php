<?php

namespace App\Http\Controllers\Member;

use App\Models\Refund;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class RefundController extends Controller
{
    public function index()
    {
    	$refund = DB::table('refunds')
                    ->join('transactions', 'refunds.transaction_id', '=', 'transactions.id')
                    ->join('bookings', 'transactions.booking_id', '=', 'bookings.id')
                    ->join('products', 'bookings.product_id', '=', 'products.id')
                    ->join('users', 'bookings.user_id', '=', 'users.id')
                    ->select(	"refunds.id AS id",
                    			"bookings.code AS code_booking",
                    			"products.name AS product_name",
                    			"refunds.created_at AS created_at",
                    			"refunds.status AS status"
                    )
                    ->where('users.id', '=', Auth::user()->id)
                    ->orderBy('refunds.created_at', 'desc')
                    ->paginate(10);

    	return $this->view(['data' => $refund]);
    }

    public function show($id)
    {
        return $this->view(['data' => Refund::find($id)]);
    }
}
