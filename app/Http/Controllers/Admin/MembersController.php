<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\IdentityCard;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class MembersController extends Controller
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
                "name",
                "email",
                "phone",
                "created_at"
            ];

            $total = User::with(['identity_card'])
                    ->where("privilege", '=', '0')
            		->where( function($q) use ($search){
	            		$q->where("name", 'LIKE', "%$search%")
	            		->orWhere("email", 'LIKE', "%$search%")
	            		->orWhere("phone", 'LIKE', "%$search%")
	            		->orWhere("created_at", 'LIKE', "%$search%");
            		})
            		->count();

            $data = User::with(['identity_card'])
                    ->where("privilege", '=', '0')
            		->where( function($q) use ($search){
	            		$q->where("name", 'LIKE', "%$search%")
	            		->orWhere("email", 'LIKE', "%$search%")
	            		->orWhere("phone", 'LIKE', "%$search%")
	            		->orWhere("created_at", 'LIKE', "%$search%");
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
        return $this->view(['data' => User::find($id)]);
    }

    public function not_active(Request $request)
    {
        $member = User::find($request->id);
        $member->status = User::STATUS_NOT_ACTIVE;
        $member->save();

        return response()->json([
            'success'   => true,
            'message'   => 'Member Successfully Change Status be Not Active'
        ]);
    }

    public function approve(Request $request)
    {
        $user = User::find($request->approve_id);

        $identity_card          = IdentityCard::find($user->identity_card_id);
        $identity_card->status  = IdentityCard::STATUS_APPROVED;
        $identity_card->note    = IdentityCard::STATUS_APPROVED;
        $identity_card->save();

        return response()->json([
            'success'   => true,
            'message'   => 'Identity Card Member Successfully Change Status be Approved'
        ]);
    }

    public function reject(Request $request)
    {
        $user = User::find($request->approve_id);

        $identity_card          = IdentityCard::find($user->identity_card_id);
        $identity_card->status  = IdentityCard::STATUS_REJECTED;
        $identity_card->note    = $request->note;
        $identity_card->save();

        return response()->json([
            'success'   => true,
            'message'   => 'Identity Card Member Successfully Change Status be Rejected'
        ]);
    }
}
