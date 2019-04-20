<?php

namespace App\Http\Controllers\Member;

use App\Models\File;
use App\Models\Reversion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ReversionController extends Controller
{
    public function index()
    {
    	$reversion 	= DB::table('reversions')
    					->join('deliveries', 'reversions.delivery_id', '=', 'deliveries.id')
    					->join('transactions', 'deliveries.transaction_id', '=', 'transactions.id')
    					->join('bookings', 'transactions.booking_id', '=', 'bookings.id')
    					->join('users', 'bookings.user_id', '=', 'users.id')
    					->join('products', 'bookings.product_id', '=', 'products.id')
    					->select(   "reversions.id AS id",
                                    "bookings.code AS code_booking",
                                    "products.name AS product_name",
                                    "bookings.end_rent AS end_rent",
                                    "reversions.status AS status"
                        )
    					->where('users.id', '=', Auth::user()->id)
                        ->orderBy('reversions.created_at', 'desc')
    					->paginate(10);

    	return $this->view(['data' => $reversion]);
    }

    public function show($id)
    {
        return $this->view(['data' => Reversion::find($id)]);
    }

    public function reversion(Request $request)
    {
        $validator = $request->validate([
            'delivery_date'     => 'required|date',
            'arrive_date'       => 'required|date',
            'proof_delivery'    => 'bail|required|mimes:jpeg,jpg,png|max:6000',
        ]);

        $reversion                   = Reversion::find($request->id);
        $reversion->arrive_date      = $request->arrive_date;
        $reversion->delivery_date    = $request->delivery_date;
        $reversion->status           = Reversion::STATUS_DELIVERED;

        if( $request->proof_delivery != null ){
            $filename  = $request->file('proof_delivery')->getClientOriginalName();
            $path      = $request->file('proof_delivery')->store('Transaction/' . Auth::user()->id . '/Proof Reversion/');
            $extension = $request->file('proof_delivery')->getClientOriginalExtension();
            $size      = $request->file('proof_delivery')->getClientSize();

            $file            = new File();
            $file->filename  = time() . '_Proof Reversion.' . $extension;
            $file->title     = 'Proof Reversion_' . Auth::user()->name;
            $file->path      = $path;
            $file->extension = $extension;
            $file->size      = $size;
            $file->save();

            $reversion->file()->associate($file);
        }

        $reversion->save();

        return response()->json([
            'success'   => true,
            'message'   => 'Pengembalian Berhasil Dikirim'
        ]);
    }
}
