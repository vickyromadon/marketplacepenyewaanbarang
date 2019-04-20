<?php

namespace App\Http\Controllers\Admin;

use App\Models\Faq;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FaqController extends Controller
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
                "question",
                "answer",
            ];

            $total = Faq::where("question", 'LIKE', "%$search%")
            		->orWhere("answer", 'LIKE', "%$search%")
            		->count();

            $data = Faq::where("question", 'LIKE', "%$search%")
            		->orWhere("answer", 'LIKE', "%$search%")
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
    		'question'	=> 'required|string',
    		'answer'	=> 'required|string',
    	]);

    	$faq 			= new Faq();
    	$faq->question 	= $request->question;
    	$faq->answer 	= $request->answer;

    	if( $faq->save() ){
	    	return response()->json([
	            'success'   => true,
	            'message'   => 'FAQ Successfully Added'
	        ]);
    	}
    	else{
    		return response()->json([
	            'success'   => false,
	            'message'   => 'FAQ Not Successfully Added'
	        ]);
    	}		
    }

    public function update(Request $request, $id)
    {
    	$validator = $request->validate([
    		'question'	=> 'required|string',
    		'answer'	=> 'required|string',
    	]);

    	$faq 			= Faq::find($id);
    	$faq->question 	= $request->question;
    	$faq->answer 	= $request->answer;
     	
     	if( $faq->save() ){
	    	return response()->json([
	            'success'	=> true,
	            'message'	=> 'FAQ Successfully Updated'
	        ]);
     	}
     	else{
     		return response()->json([
	            'success'	=> false,
	            'message'	=> 'FAQ Not Successfully Updated'
	        ]);	
     	}
    }

    public function destroy($id)
    {
    	$faq = Faq::find($id);
    	
    	if( $faq->delete() ){
	    	return response()->json([
	            'success'	=> true,
	            'message'	=> 'FAQ Successfully Deleted'
	        ]);
    	}
    	else{
    		return response()->json([
	            'success'	=> false,
	            'message'	=> 'FAQ Not Successfully Deleted'
	        ]);	
    	}

    }

    public function show($id)
    {
        return $this->view(['data' => Faq::find($id)]);
    }
}
