<?php

namespace App\Http\Controllers\Member;

use App\Models\Booking;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class HistoryController extends Controller
{
    public function index()
    {
    	$booking = Booking::where('user_id', Auth::user()->id)->orderBy('created_at', 'desc')->paginate(10);
        // dd($booking);
    	return $this->view(['data' => $booking]);
    }

    public function show($id)
    {
    	return $this->view(['data' => Booking::find($id)]);
    }

    public function request(Request $request)
    {
        $validator = $request->validate([
            'start_date'    => 'required|date',
            'time_periode'  => 'required',
            'quantity'      => 'required',
        ]);

        $end_date = str_replace("/", "-", substr($request->time_periode, 13, 10));

    	$booking 		= Booking::find($request->id);
    	$time_periode	= $booking->product->time_periode;

		$booking->start_rent 	= $request->start_date;
		$booking->end_rent 		= $end_date;
		$booking->status 		= Booking::STATUS_PENDING;
        $booking->quantity      = $request->quantity;
		$booking->save();

		return response()->json([
            'success'   => true,
            'message'   => 'Permintaan Sewa Berhasil Dikirim, Harap hubungi pemilik produk untuk persetujuan.'
        ]);
    }

    public function cancel(Request $request)
    {
        $booking = Booking::find($request->booking_id);
        $booking->status = Booking::STATUS_CANCELED;
        $booking->save();

        return response()->json([
            'success'   => true,
            'message'   => 'Batalkan Penyewaan Berhasil.'
        ]);
    }
}
