<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Admin;
use App\Models\Refund;
use App\Models\Message;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user   = User::where('privilege', '0')->where('status', 'confirm')->get();
        $owner  = User::where('privilege', '1')->where('status', 'confirm')->get();

        $ktpUser = DB::table('users')
                    ->join('identity_cards', 'users.identity_card_id', 'identity_cards.id')
                    ->where('users.privilege', '0')
                    ->where('users.status', 'confirm')
                    ->where('identity_cards.status', 'pending')
                    ->get();

        $ktpOwner = DB::table('users')
                    ->join('identity_cards', 'users.identity_card_id', 'identity_cards.id')
                    ->where('users.privilege', '1')
                    ->where('users.status', 'confirm')
                    ->where('identity_cards.status', 'pending')
                    ->get();

        $message = Message::all();

        $product = Product::where('status', 'publish')->get();

        $rekber = Transaction::where('payment_method', 'rekber')->get();

        $cod = Transaction::where('payment_method', 'cod')->get();

        $payment_confirmation = Transaction::where('status_payment', 'pending')->get();

        $refund = Refund::where('status', 'verified')->get();
        // dd($payment_confirmation);

        return view('admin.home')
                ->with('user', $user)
                ->with('owner', $owner)
                ->with('ktpUser', $ktpUser)
                ->with('ktpOwner', $ktpOwner)
                ->with('message', $message)
                ->with('product', $product)
                ->with('rekber', $rekber)
                ->with('cod', $cod)
                ->with('payment_confirmation', $payment_confirmation)
                ->with('refund', $refund);
    }

    public function profile($id)
    {
        return  view('admin.profile')
                ->with('data', Admin::find($id));
    }

    public function setting(Request $request, $id)
    {
        $validator = $request->validate([
            'name'  => 'nullable|string|max:191',
            'phone' => ['nullable', 'string', 'phone:ID', Rule::unique('admins')->ignore($id)],
        ]);

        $admin = Admin::find($id);
        if( $request->name != null && $request->phone == null ){
            $admin->name  = $request->name;
        }
        else if( $request->name == null && $request->phone != null ){
            $admin->phone = $request->phone;
        }
        else{
            $admin->name  = $request->name;   
            $admin->phone = $request->phone;
        }

        if( $admin->save() ){
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
        $admin = Admin::find($id);

        if( !(Hash::check($request->current_password, $admin->password)) ){
            return response()->json([
                'success' => false,
                'message' => 'Your current password does not matches with the password you provided. Please try again.',
            ]);
        }

        $validator = $request->validate([
            'new_password'         => 'required|min:6',
            'new_password_confirm' => 'required_with:new_password|same:new_password|min:6',
        ]);

        $admin->password = Hash::make($request->new_password);
        
        if( $admin->save() ){
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
}
