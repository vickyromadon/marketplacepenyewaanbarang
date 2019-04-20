<?php

namespace App\Http\Controllers\Member;

use App\Models\User;
use App\Models\Booking;
use App\Models\Product;
use App\Models\IdentityCard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class BookingController extends Controller
{
    public function store(Request $request)
    {
        $checkUser = User::find(Auth::user()->id);

        if( $checkUser->phone       == null ||
            $checkUser->address     == null ||
            $checkUser->gender      == null ||
            $checkUser->birthdate   == null ||
            $checkUser->birthplace  == null ||
            $checkUser->privilege   == null ||
            $checkUser->file        == null ||
            $checkUser->banks       == null 
        ){
            return response()->json([
                'success'   => false,
                'message'   => 'Pemesanan Gagal Karena Profil Anda Tidak Lengkap, Silakan Lengkapi Profil Anda.'
            ]);
        }
        else{
            if ( $checkUser->identity_card_id == null ) {
                return response()->json([
                    'success'   => false,
                    'message'   => 'Pemesanan Gagal Karena Anda Belum Mengunggah Kartu Identitas Anda, Silakan Mengunggah Kartu Identitas Anda.'
                ]);
            }
            else{
                if( $checkUser->identity_card->status != IdentityCard::STATUS_APPROVED ){
                    return response()->json([
                        'success'   => false,
                        'message'   => 'Pemesanan Gagal Karena Kartu Identitas Anda Belum Disetujui oleh Admin, Harap Tunggu Tanggapan dari Admin.'
                    ]);
                }
                else{
                    $checkRental = Booking::where('user_id', '=', $request->user_id)
                                    ->where('product_id', '=', $request->product_id)
                                    ->where( function($q) {
                                        $q->where('status', 'empty')
                                          ->orWhere('status', 'pending');
                                    })
                                    ->get();

                    if ( count( $checkRental ) > 0 ) {
                        return response()->json([
                            'success'   => false,
                            'message'   => 'Anda telah melakukan proses pemesanan pada produk ini, silakan lanjutkan pada menu pemesanan.'
                        ]);
                    }
                    else{
                    	$check 	= Booking::select('code')->latest()->first(); 

                        if( $check != null ){
                            $checkCode = $check;
                            $date       = substr($checkCode->code, 4, 8);
                            $queue      = substr($checkCode->code, 12, 4);
                        }
                        else{
                            $checkCode = 'BOOK000000000000';
                            $date       = substr($checkCode, 4, 8);
                            $queue      = substr($checkCode, 12, 4);
                        }

                        $dateNow    = date('dmY');

                        $newCode = '';

                        if ( $date == $dateNow ) {
                            if( $queue < 9 )
                                $newCode = $dateNow . '000' . $queue+=1;
                            else if( $queue < 99 )
                                $newCode = $dateNow . '00' . $queue+=1;
                            else if( $queue < 999 )
                                $newCode = $dateNow . '0' . $queue+=1;
                            else
                                $newCode = $dateNow . $queue+=1;
                        }
                        else
                            $newCode = $dateNow . '0001';

                    	$validator = $request->validate([
                	        'user_id' 		=> 'required',
                	        'product_id' 	=> 'required',	
                	    ]);

                    	$user 			    = User::find($request->user_id);
                    	$product 		    = Product::find($request->product_id);

                    	$booking 		    = new Booking();
                    	$booking->code      = 'BOOK' . $newCode;
                        $booking->status    = Booking::STATUS_EMPTY;

                        $booking->user()->associate($user);
                        $booking->product()->associate($product);
                    	$booking->save();

                    	return response()->json([
                	        'success'   => true,
                	        'message'   => 'Produk berhasil dipesan, silakan lihat menu pemesanan untuk melanjutkan proses penyewaan produk.'
                	    ]);
                    }  
                }
            } 
        }
    }
}
