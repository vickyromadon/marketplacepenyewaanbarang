<?php

namespace App\Http\Controllers\Owner;

use App\Models\User;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
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
                "start_rent",
                "end_rent",
                "user_name",
                "booking_date"
            ];

            $total = DB::table('bookings')->join('products', 'bookings.product_id', '=', 'products.id')
            			->join('users', 'bookings.user_id', '=', 'users.id')
            			->where('products.user_id', '=', Auth::user()->id)
                        ->where('bookings.status', '=', Booking::STATUS_PENDING)
                        ->where( function($q) use ($search) {
                            $q->where("bookings.code", 'LIKE', "%$search%")
                            ->orWhere("products.name", 'LIKE', "%$search%");
                        })
	            		->count();

	        $data = DB::table('bookings')->join('products', 'bookings.product_id', '=', 'products.id')
            			->join('users', 'bookings.user_id', '=', 'users.id')
            			->select(	"bookings.id AS id",
            						"bookings.code AS code_booking",
            						"products.name AS product_name",
            						"bookings.start_rent AS start_rent",
            						"bookings.end_rent AS end_rent",
            						"users.name AS user_name",
            						"bookings.created_at AS booking_date",
            						"bookings.status AS status")
            			->where('products.user_id', '=', Auth::user()->id)
	            		->where('bookings.status', '=', Booking::STATUS_PENDING)
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
        return $this->view(['data' => Booking::find($id)]);
    }

    public function approve(Request $request)
    {
        $booking            = Booking::find($request->approve_id);
        $booking->status    = Booking::STATUS_APPROVED;
        $booking->save();

        return response()->json([
            'success'  => true,
            'message'  => 'Booking Successfully Approved'
        ]);
    }

    public function reject(Request $request)
    {
        $booking            = Booking::find($request->reject_id);
        $booking->status    = Booking::STATUS_REJECTED;
        $booking->reason    = $request->reason;
        $booking->save();

        return response()->json([
            'success'  => true,
            'message'  => 'Booking Successfully Rejected'
        ]);
    }
}
