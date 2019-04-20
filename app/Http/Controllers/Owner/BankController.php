<?php

namespace App\Http\Controllers\Owner;

use App\Models\Bank;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class BankController extends Controller
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
                "number",
                "owner",
            ];

            $total = Bank::where("user_id", '=', Auth::user()->id )
            		->where( function($q) use ($search){
            			$q->where("name", 'LIKE', "%$search%")
            			->orWhere("number", 'LIKE', "%$search%")
            			->orWhere("owner", 'LIKE', "%$search%");
            		})
            		->count();

            $data = Bank::where("user_id", '=', Auth::user()->id )
            		->where( function($q) use ($search){
            			$q->where("name", 'LIKE', "%$search%")
            			->orWhere("number", 'LIKE', "%$search%")
            			->orWhere("owner", 'LIKE', "%$search%");
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

    	return $this->view(['data' => Bank::where('user_id', Auth::user()->id)->get()]);
    }

    public function store(Request $request)
    {
    	$validator = $request->validate([
    		'name'		=> 'required|string|max:191',
    		'number'	=> 'required|numeric|unique:banks',
    		'owner'		=> 'required|string|max:191',
    	]);

        DB::transaction(function () use ($request){
        	$bank = new Bank();
        	$bank->name 	= $request->name;
        	$bank->number 	= $request->number;
        	$bank->owner	= $request->owner;
        	$bank->status 	= 'publish';

            $user          = User::where('id', Auth::user()->id)->first();
            $bank->user_id = $user->id;

            $bank->save();
        });
    	
    	return response()->json([
            'success'   => true,
            'message'   => 'Bank Successfully Added'
        ]);
    }

    public function update(Request $request, $id)
    {
    	$validator = $request->validate([
    		'name'		=> ['required', 'string', 'max:191'],
    		'number'	=> ['required', 'numeric', Rule::unique('banks')->ignore($id)],
    		'owner'		=> 'required|string|max:191',
    	]);

    	$bank = Bank::find($id);
    	$bank->name 	= $request->name;
    	$bank->number 	= $request->number;
    	$bank->owner	= $request->owner;
    	$bank->status 	= 'publish';
     	
     	if( $bank->save() ){
	    	return response()->json([
	            'success'	=> true,
	            'message'	=> 'Bank Successfully Updated'
	        ]);
     	}
     	else{
     		return response()->json([
	            'success'	=> false,
	            'message'	=> 'Bank Not Successfully Updated'
	        ]);	
     	}
    }

    public function destroy($id)
    {
    	$bank = Bank::find($id);
    	
    	if( $bank->delete() ){
	    	return response()->json([
	            'success'	=> true,
	            'message'	=> 'Bank Successfully Deleted'
	        ]);
    	}
    	else{
    		return response()->json([
	            'success'	=> false,
	            'message'	=> 'Bank Not Successfully Deleted'
	        ]);	
    	}

    }
}
