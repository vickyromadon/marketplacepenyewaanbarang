<?php

namespace App\Http\Controllers\Owner;

use App\Models\Refund;
use App\Models\Reversion;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class ReversionController extends Controller
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


            $total = Reversion::with(['delivery' => function($q){
                $q->with(['transaction' => function($q){
                    $q->with(['booking' => function($q){
                        $q->with(['product' => function($q){
                            $q->with(['user'])->where('id', Auth::user()->id);
                        }]);
                    }]);
                }]);
            }])
    		->count();

            $data = Reversion::with(['delivery' => function($q){
                $q->with(['transaction' => function($q){
                    $q->with(['booking' => function($q){
                        $q->with(['product' => function($q){
                            $q->with(['user'])->where('id', Auth::user()->id);
                        }]);
                    }]);
                }]);
            }])->where('status', '<>', Reversion::STATUS_EMPTY)
            ->orderBy('created_at', 'desc')
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
        return $this->view([
            'data'      => Reversion::find($id),
        ]);
    }

    public function arrive(Request $request)
    {
        $reversion          = Reversion::find($request->arrived_id);
        $reversion->status  = Reversion::STATUS_ARRIVED;
        $reversion->save();

        return response()->json([
            'success'   => true,
            'message'   => 'Arrived Successfully Sent'
        ]);
    }

    public function refund(Request $request)
    {
        $transaction = Transaction::find($request->transaction_id);

        $refund                 = new Refund();
        $refund->price_owner    = $transaction->price;
        $refund->price_member   = $transaction->deposite;
        $refund->transaction()->associate($transaction);
        $refund->save();

        return response()->json([
            'success'   => true,
            'message'   => 'Refund Request Successfully Sent'
        ]);
    }
}
