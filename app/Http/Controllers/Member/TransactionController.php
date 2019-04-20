<?php

namespace App\Http\Controllers\Member;

use App\Models\Bank;
use App\Models\User;
use App\Models\File;
use App\Models\Rating;
use App\Models\Product;
use App\Models\Guaranty;
use App\Models\Delivery;
use App\Models\Document;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TransactionController extends Controller
{
    public function index()
    {
    	$transaction = DB::table('transactions')
                        ->join('bookings', 'transactions.booking_id', '=', 'bookings.id')
                        ->where('bookings.user_id', Auth::user()->id)
                        ->select(   "transactions.id AS id",
                                    "bookings.code AS code",
                                    "transactions.payment_method AS payment_method",
                                    "transactions.created_at AS created_at",
                                    "transactions.status")
                        ->orderBy('transactions.created_at', 'desc')
                        ->paginate(10);

        return $this->view(['data' => $transaction]);
    }

    public function store(Request $request)
    {
    	$validator = $request->validate([
    		'optradio'	=> 'in:cod,rekber',
    	]);

    	$transaction 					= new Transaction();
    	$transaction->payment_method 	= $request->optradio;
    	$transaction->booking_id 		= $request->booking_id;
    	$transaction->status 			= Transaction::STATUS_PENDING;
        $transaction->price             = $request->price;
        $transaction->time_periode      = $request->time_periode;
        $transaction->total_periode     = $request->total_periode;
        $transaction->deposite          = $request->deposite;
        $transaction->grand_total       = $request->grand_total;
    	$transaction->save();

    	return response()->json([
            'success'   => true,
            'message'   => 'Pemilihan Metode Pembayaran Berhasil, Silakan Lihat Menu Transaksi.'
        ]);

    }

    public function show(Request $request, $id)
    {   
        $transaction = DB::table('transactions')
                        ->join('bookings', 'transactions.booking_id', 'bookings.id')
                        ->where('transactions.status', '=', 'pending')
                        ->whereDate("bookings.start_rent", '<', date('Y-m-d'))
                        ->select(   'transactions.id AS id',
                                    'transactions.status AS status')
                        ->get();
        dd($transaction);

        $bank   = Bank::where('admin_id', '<>', null)->where('status', '=', 'publish')->get();

        return $this->view([
                            'data' => Transaction::find($id),
                            'banks' => $bank
                        ]);
    }

    public function getPdf(Request $request, $id)
    {
        $transaction = Transaction::find($id);

        if ( $transaction->status == Transaction::STATUS_REJECTED ) {
            $transaction->status = Transaction::STATUS_PENDING;
            $transaction->save();
        }
        
        if( $request->isMethod('post') ){
            $validator = $request->validate([
                'upload_pdf'       => 'required|mimes:jpeg,jpg,png,pdf|max:5000',
            ]);

            $document       = new Document();
            if( $request->upload_pdf != null ){
                $filename  = $request->file('upload_pdf')->getClientOriginalName();
                $path      = $request->file('upload_pdf')->store('Transaction/' . Auth::user()->id . '/Agreement Letter/');
                $extension = $request->file('upload_pdf')->getClientOriginalExtension();
                $size      = $request->file('upload_pdf')->getClientSize();

                $file            = new File();
                $file->filename  = time() . '_Agreement Letter.' . $extension;
                $file->title     = 'Agreement Letter_' . Auth::user()->name;
                $file->path      = $path;
                $file->extension = $extension;
                $file->size      = $size;
                $file->save();

                $document->file()->associate($file);
            }
            
            $document->transaction()->associate($transaction);
            $document->save();

            return response()->json([
                'success'   => true,
                'message'   => 'Surat Perjanjian Berhasil Dikirim'
            ]);
        }

        view()->share('transaction', $transaction);

        $pdf = PDF::loadView('member.transaction.getPdf');
        return $pdf->download('Agreement Letter Product '. $transaction->booking->product->name .'.pdf');

        return $this->view();
    }

    public function payment_confirmation(Request $request, $id)
    {
        $validator = $request->validate([
            'transfer_date'     => 'required|date',
            'bank_name'         => 'required|string',
            'account_name'      => 'required|string',
            'account_number'    => 'required|numeric',
            'receive_bank'      => 'required',
            'proof_image'       => 'required|mimes:jpeg,jpg,png|max:5000',
        ]);

        $bank                                   = Bank::find($request->receive_bank);
        
        $transaction                            = Transaction::find($id);
        $transaction->account_name_of_sender    = $request->account_name;
        $transaction->account_number_of_sender  = $request->account_number;
        $transaction->bank_name_of_sender       = $request->bank_name;
        $transaction->transfer_date             = $request->transfer_date;
        $transaction->status_payment            = Transaction::STATUS_PAYMENT_PENDING;
        $transaction->bank()->associate($bank);

        if ( $transaction->status == Transaction::STATUS_REJECTED ) {
            $transaction->status = Transaction::STATUS_PENDING;
        }

        if( $request->proof_image != null ){
            $filename  = $request->file('proof_image')->getClientOriginalName();
            $path      = $request->file('proof_image')->store('Transaction/' . Auth::user()->id . '/Proof Image/');
            $extension = $request->file('proof_image')->getClientOriginalExtension();
            $size      = $request->file('proof_image')->getClientSize();

            $file            = new File();
            $file->filename  = time() . '_Proof Image.' . $extension;
            $file->title     = 'Proof Image_' . Auth::user()->name;
            $file->path      = $path;
            $file->extension = $extension;
            $file->size      = $size;
            $file->save();

            $transaction->file()->associate($file);
        }

        $transaction->save();

        return response()->json([
            'success'   => true,
            'message'   => 'Konfirmasi Pembayaran Berhasil Dikirim.'
        ]);
    }

    public function guaranty(Request $request, $id)
    {
        $validator = $request->validate([
            'type_file'     => 'required|in:KTP,KARTU KELUARGA,SIM,PASSPORT',
            'upload_file'   => 'required|mimes:jpeg,jpg,png|max:5000',
            'number_file'   => 'required|string',
        ]);

        $transaction = Transaction::find($id);

        if ( $transaction->status == Transaction::STATUS_REJECTED ) {
            $transaction->status = Transaction::STATUS_PENDING;
            $transaction->save();
        }

        $guaranty = new Guaranty();
        $guaranty->number   = $request->number_file;
        $guaranty->type     = $request->type_file;

        if( $request->upload_file != null ){
            $filename  = $request->file('upload_file')->getClientOriginalName();
            $path      = $request->file('upload_file')->store('Transaction/' . Auth::user()->id . '/Guaranty/');
            $extension = $request->file('upload_file')->getClientOriginalExtension();
            $size      = $request->file('upload_file')->getClientSize();

            $file            = new File();
            $file->filename  = time() . '_Guaranty_' . $request->type_file . '.' . $extension;
            $file->title     = 'Guaranty_' . $request->type_file . '_' . Auth::user()->name;
            $file->path      = $path;
            $file->extension = $extension;
            $file->size      = $size;
            $file->save();

            $guaranty->file()->associate($file);
        }

        $guaranty->transaction()->associate($transaction);
        $guaranty->save();

        return response()->json([
            'success'   => true,
            'message'   => 'Unggah Surat Jaminan '. $request->type_file .' Berhasil dikirim.'
        ]);
    }

    public function confirm_address(Request $request)
    {
        $validator = $request->validate([
            'address'   => 'required|string',
            'name'      => 'required|string',
            'phone'     => ['required', 'string', 'phone:ID'],
        ]);

        $transaction        = Transaction::find($request->transaction_id);
        $transaction->note  = 'Terima kasih telah melakukan konfirmasi pengiriman, barang akan segera dikirim ke alamat tujuan.';
        $transaction->save();

        $delivery                   = new Delivery();
        $delivery->address          = $request->address;
        $delivery->name   = $request->name;
        $delivery->phone  = $request->phone;
        $delivery->transaction()->associate($transaction);

        $delivery->save();

        return response()->json([
            'success'   => true,
            'message'   => 'Konfirmasi Permintaan Pengiriman Barang Berhasil Dikirim.'
        ]);
    }

    public function rating(Request $request)
    {
        $validator = $request->validate([
            'rate'      => ['required', Rule::in(['1', '2', '3', '4', '5'])],
            'note'      => 'nullable|string',
        ]);

        $user       = User::find($request->user_id);
        $product    = Product::find($request->product_id);

        $rating = new Rating();
        $rating->rate = $request->rate;
        $rating->note = $request->note;
        $rating->user()->associate($user);
        $rating->product()->associate($product);
        $rating->save();

        $transaction = Transaction::find($request->transaction_id);
        $transaction->status    = Transaction::STATUS_APPROVED;
        $transaction->note      = 'Transaksi Selesai, Terima Kasih';
        $transaction->save();

        return response()->json([
            'success'   => true,
            'message'   => 'Rating Berhasil Dikirim'
        ]);
    }
}
