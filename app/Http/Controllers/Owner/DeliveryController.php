<?php

namespace App\Http\Controllers\Owner;

use App\Models\File;
use App\Models\User;
use App\Models\Delivery;
use App\Models\Reversion;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class DeliveryController extends Controller
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
                "delivery_date",
                "arrive_date",
                "product_name",
                "member_name"
            ];

            $total = DB::table('deliveries')
            		->join('transactions', 'deliveries.transaction_id', '=', 'transactions.id')
            		->join('bookings', 'transactions.booking_id', '=', 'bookings.id')
            		->join('products', 'bookings.product_id', '=', 'products.id')
            		->join('users', 'products.user_id', '=', 'users.id')
            		->where('users.id', '=', Auth::user()->id)
                    ->where( function($q) use ($search) {
                        $q->where("bookings.code", 'LIKE', "%$search%")
                        ->orWhere("products.name", 'LIKE', "%$search%");
                    })
            		->count();

            $data = DB::table('deliveries')
            		->join('transactions', 'deliveries.transaction_id', '=', 'transactions.id')
            		->join('bookings', 'transactions.booking_id', '=', 'bookings.id')
            		->join('products', 'bookings.product_id', '=', 'products.id')
            		->join('users', 'products.user_id', '=', 'users.id')
            		->select(	"deliveries.id AS id",
            					"bookings.code AS code_booking",
            					"deliveries.delivery_date AS delivery_date",
            					"deliveries.arrive_date AS arrive_date",
            					"products.name AS product_name",
            					"deliveries.status AS status"

            		)
            		->where('users.id', '=', Auth::user()->id)
                    ->where( function($q) use ($search) {
                        $q->where("bookings.code", 'LIKE', "%$search%")
                        ->orWhere("products.name", 'LIKE', "%$search%");
                    })
            		->orderBy('deliveries.created_at', 'desc')
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
        $profile = User::find(Auth::user()->id);

        return $this->view([
            'data'      => Delivery::find($id),
            'profile'   => $profile,
        ]);
    }

    public function delivery(Request $request)
    {
        $validator = $request->validate([
            'delivery_date'     => 'required|date',
            'arrive_date'       => 'required|date',
            'proof_delivery'    => 'bail|required|mimes:jpeg,jpg,png|max:6000',
            'address'           => 'required|string',
            'name'              => 'required|string',
            'phone'             => ['required', 'string', 'phone:ID'],
        ]);

        $delivery                   = Delivery::find($request->id);
        $delivery->arrive_date      = $request->arrive_date;
        $delivery->delivery_date    = $request->delivery_date;
        $delivery->status           = Delivery::STATUS_DELIVERED;

        if( $request->proof_delivery != null ){
            $filename  = $request->file('proof_delivery')->getClientOriginalName();
            $path      = $request->file('proof_delivery')->store('Transaction/' . Auth::user()->id . '/Proof Delivery/');
            $extension = $request->file('proof_delivery')->getClientOriginalExtension();
            $size      = $request->file('proof_delivery')->getClientSize();

            $file            = new File();
            $file->filename  = time() . '_Proof Delivery.' . $extension;
            $file->title     = 'Proof Delivery_' . Auth::user()->name;
            $file->path      = $path;
            $file->extension = $extension;
            $file->size      = $size;
            $file->save();

            $delivery->file()->associate($file);
        }

        $delivery->save();

        $transaction        = Transaction::find($delivery->transaction_id);
        $transaction->note  = 'Product Telah di Kirim ke Alamat Tujuan';
        $transaction->save();

        $reversion          = new Reversion();
        $reversion->name    = $request->name;
        $reversion->phone   = $request->phone;
        $reversion->address = $request->address;
        $reversion->delivery()->associate($delivery);
        $reversion->save();

        return response()->json([
            'success'   => true,
            'message'   => 'Delivery Successfully Sent'
        ]);
    }
}
