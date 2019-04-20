<?php

namespace App\Http\Controllers\Admin;

use App\Models\Bank;
use App\Models\Admin;
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

            $total = Bank::where("admin_id", '=', Auth::user()->id )
                    ->where( function($q) use ($search){
                        $q->where("name", 'LIKE', "%$search%")
                        ->orWhere("number", 'LIKE', "%$search%")
                        ->orWhere("owner", 'LIKE', "%$search%");
                    })
            		->count();

            $data = Bank::where("admin_id", '=', Auth::user()->id )
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

    	return $this->view();
    }

    public function store(Request $request)
    {
    	$validator = $request->validate([
    		'name'		=> 'required|string|max:191',
    		'number'	=> 'required|numeric|unique:banks',
    		'owner'		=> 'required|string|max:191',
    		'status' 	=> 'required'
    	]);

        DB::transaction(function () use ($request){
        	$bank = new Bank();
        	$bank->name 	= $request->name;
        	$bank->number 	= $request->number;
        	$bank->owner	= $request->owner;
        	$bank->status 	= $request->status;

            $admin          = Admin::where('id', Auth::user()->id)->first();
            $bank->admin_id = $admin->id;

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
    		'status' 	=> 'required',
    	]);

    	$bank = Bank::find($id);
    	$bank->name 	= $request->name;
    	$bank->number 	= $request->number;
    	$bank->owner	= $request->owner;
    	$bank->status 	= $request->status;
     	
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
