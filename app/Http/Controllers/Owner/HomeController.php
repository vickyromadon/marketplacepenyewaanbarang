<?php

namespace App\Http\Controllers\Owner;

use App\Models\File;
use App\Models\User;
use App\Models\IdentityCard;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


use App\Models\Booking;
use App\Models\Product;
use App\Models\Transaction;
use App\Mail\UserConfirmation;
use App\Mail\BookingProductToOwner;
use Illuminate\Support\Facades\Mail;
use App\Mail\PaymentConfirmationRequest;
use App\Mail\TransactionSendAggrementLetter;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:owner');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $product = Product::where('user_id', Auth::user()->id)->get();

        $rekber = DB::table('transactions')
                    ->join('bookings', 'transactions.booking_id', 'bookings.id')
                    ->join('products', 'bookings.product_id', 'products.id')
                    ->where('products.user_id', Auth::user()->id)
                    ->where('transactions.payment_method', 'rekber')
                    ->get();

        $cod = DB::table('transactions')
                    ->join('bookings', 'transactions.booking_id', 'bookings.id')
                    ->join('products', 'bookings.product_id', 'products.id')
                    ->where('products.user_id', Auth::user()->id)
                    ->where('transactions.payment_method', 'cod')
                    ->get();

        // dd($rekber);
        return view('owner.home')
                ->with('product', $product)
                ->with('rekber', $rekber)
                ->with('cod', $cod);
    }

    public function profile($id)
    {
        return  view('owner.profile')
                ->with('data', User::find($id));
    }

    public function setting(Request $request, $id)
    {
        $validator = $request->validate([
            'name'          => 'nullable|string|max:191',
            'phone'         => ['nullable', 'string', 'phone:ID', Rule::unique('users')->ignore($id)],
            'address'       => 'nullable|string',
            // 'age'           => 'nullable|numeric',
            'birthplace'    => 'nullable|string',
            'birthdate'     => 'nullable|date',
            'gender'        => 'nullable|in:Male,Female',
            // 'religion'      => 'nullable|in:Islam,Kristen Protestan,Katolik,Hindu,Buddha,Kong Hu Cu',
        ]);

        $user = User::find($id);
        $user->name         = $request->name;   
        $user->phone        = $request->phone;
        $user->address      = $request->address;
        $user->age          = (getdate()['year']) - substr($request->birthdate, 0, 4);
        $user->birthplace   = $request->birthplace;
        $user->birthdate    = $request->birthdate;
        $user->gender       = $request->gender;
        // $user->religion     = $request->religion;

        if( $user->save() ){
            return response()->json([
                'success' => true,
                'message' => 'Data Setting successfully saved',
            ]);
        }
        else{
            return response()->json([
                'success' => true,
                'message' => 'Data Settings failed to save',
            ]);
        }
    }

    public function password(Request $request, $id)
    {
        $user = User::find($id);

        if( !(Hash::check($request->current_password, $user->password)) ){
            return response()->json([
                'success' => false,
                'message' => 'Your current password does not matches with the password you provided. Please try again.',
            ]);
        }

        $validator = $request->validate([
            'new_password'         => 'required|min:6',
            'new_password_confirm' => 'required_with:new_password|same:new_password|min:6',
        ]);

        $user->password = Hash::make($request->new_password);
        
        if( $user->save() ){
            return response()->json([
                'success' => true,
                'message' => 'Data Password successfully saved',
            ]);
        }
        else{
            return response()->json([
                'success' => true,
                'message' => 'Data Passwords failed to save',
            ]);
        }
    }

    public function avatar(Request $request, $id)
    {
        $validator = $request->validate([
            'file_id'   => 'required|mimes:jpeg,jpg,png|max:5000',
        ]);

        $user = User::find($id);

        if( $request->file_id != null ){
            if( $request->hasFile('file_id') != null ){
                if( $user->file_id != null ){
                    $picture = File::find(intval($user->file_id));
                    Storage::delete($picture->path);
                    $picture->delete();
                }
            }

            $filename  = $request->file('file_id')->getClientOriginalName();
            $path      = $request->file('file_id')->store('owner');
            $extension = $request->file('file_id')->getClientOriginalExtension();
            $size      = $request->file('file_id')->getClientSize();
            
            $file            = new File();
            $file->filename  = time() . '_' . $filename;
            $file->title     = $request->name;
            $file->path      = $path;
            $file->extension = $extension;
            $file->size      = $size;
            $file->save();

            $user->file()->associate($file);
        }

        $user->save();

        if( !$user->save() ){
            if ( $request->hasFile('file_id') ) {
               $fileDelete = File::where('path', '=', $file->path)->first();
               Storage::delete($fileDelete->path);
               $fileDelete->delete(); 
            }

            return response()->json([
                'success'   => false,
                'message'   => 'Foto Profile Not Successfully Edited'
            ]);
        }
        else{
            return response()->json([
                'success'  => true,
                'message'  => 'Foto Profile Successfully Edited'
            ]);
        }
    }

    public function identity_card(Request $request, $id)
    {
        $user = User::find($id);

        if( $user->identity_card_id == null ){
            $validator = $request->validate([
                'file_identity_card'    => 'nullable|mimes:jpeg,jpg,png|max:5000',
                'number'                => 'required|numeric',
            ]);
            
            $identity_card = new IdentityCard();
            $identity_card->number  = $request->number;

            if( $request->file_identity_card != null ){
                if( $request->hasFile('file_identity_card') != null ){
                    if( $identity_card->file_id != null ){
                        $picture = File::find(intval($identity_card->file_id));
                        Storage::delete($picture->path);
                        $picture->delete();
                    }
                }

                $filename  = $request->file('file_identity_card')->getClientOriginalName();
                $path      = $request->file('file_identity_card')->store('owner/' . Auth::user()->id . '/');
                $extension = $request->file('file_identity_card')->getClientOriginalExtension();
                $size      = $request->file('file_identity_card')->getClientSize();
                
                $file            = new File();
                $file->filename  = time() . '_' . $filename;
                $file->title     = $request->name;
                $file->path      = $path;
                $file->extension = $extension;
                $file->size      = $size;
                $file->save();

                $identity_card->file()->associate($file);
            }

            $identity_card->save();
            $user->identity_card()->associate($identity_card);
            $user->save();

            if( !$identity_card->save() ){
                if ( $request->hasFile('file_identity_card') ) {
                   $fileDelete = File::where('path', '=', $file->path)->first();
                   Storage::delete($fileDelete->path);
                   $fileDelete->delete(); 
                }

                return response()->json([
                    'success'   => false,
                    'message'   => 'Identity Card Not Successfully Saved'
                ]);
            }
            else{
                return response()->json([
                    'success'  => true,
                    'message'  => 'Identity Card Successfully Saved'
                ]);
            }
        }
        else{
            $validator = $request->validate([
                'file_identity_card'    => 'nullable|mimes:jpeg,jpg,png|max:5000',
                'number'                => ['required', 'numeric'],
            ]);

            $identity_card = IdentityCard::find($request->identity_card_id);
            $identity_card->number  = $request->number;
            $identity_card->status  = IdentityCard::STATUS_PENDING;

            if( $request->file_identity_card != null ){
                if( $request->hasFile('file_identity_card') != null ){
                    if( $identity_card->file_id != null ){
                        $picture = File::find(intval($identity_card->file_id));
                        Storage::delete($picture->path);
                        $picture->delete();
                    }
                }

                $filename  = $request->file('file_identity_card')->getClientOriginalName();
                $path      = $request->file('file_identity_card')->store('member/' . Auth::user()->id . '/');
                $extension = $request->file('file_identity_card')->getClientOriginalExtension();
                $size      = $request->file('file_identity_card')->getClientSize();
                
                $file            = new File();
                $file->filename  = time() . '_' . $filename;
                $file->title     = $request->name;
                $file->path      = $path;
                $file->extension = $extension;
                $file->size      = $size;
                $file->save();

                $identity_card->file()->associate($file);
            }

            $identity_card->save();

            if( !$identity_card->save() ){
                if ( $request->hasFile('file_identity_card') ) {
                   $fileDelete = File::where('path', '=', $file->path)->first();
                   Storage::delete($fileDelete->path);
                   $fileDelete->delete(); 
                }

                return response()->json([
                    'success'   => false,
                    'message'   => 'Identity Card Not Successfully Edited'
                ]);
            }
            else{
                return response()->json([
                    'success'  => true,
                    'message'  => 'Identity Card Successfully Edited'
                ]);
            }
        }
    }

    public function bank(Request $request, $id)
    {
        if( $request->bank_id == null )
        {
            $validator = $request->validate([
                'bank_name'         => 'required|string|max:191',
                'account_name'      => 'required|string|max:191',
                'account_number'    => 'required|numeric',
            ]);

            $bank           = new Bank();
            $bank->name     = $request->bank_name;
            $bank->owner    = $request->account_name;
            $bank->number   = $request->account_number;
            $bank->status   = 'publish';
            $bank->user_id  = Auth::user()->id;
            $bank->save();

            return response()->json([
                'success'   => true,
                'message'   => 'Bank Successfully Edited'
            ]);
        }
        else{
            $validator = $request->validate([
                'bank_name'         => 'required|string|max:191',
                'account_name'      => 'required|string|max:191',
                'account_number'    => 'required|numeric',
            ]);


            $bank           = Bank::find($request->bank_id);
            $bank->name     = $request->bank_name;
            $bank->owner    = $request->account_name;
            $bank->number   = $request->account_number;
            $bank->status   = 'publish';
            $bank->user_id  = Auth::user()->id;
            $bank->save();

            return response()->json([
                'success'   => true,
                'message'   => 'Bank Successfully Edited'
            ]);
        }
    }

    public function test(Request $request){
        // $user = User::find(7);
        // $mail = new UserConfirmation($user);

        // Mail::send($mail);
        
        // $booking = Booking::find(1);
        // $mail = new BookingProductToOwner($booking);

        $transaction = Transaction::find(1);
        $mail = new PaymentConfirmationRequest($transaction);

        return $mail;
    }
}
