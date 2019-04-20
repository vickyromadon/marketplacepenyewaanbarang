<?php

namespace App\Http\Controllers\Admin;

use App\Models\Message;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MessageController extends Controller
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

            $total = Message::where("name", 'LIKE', "%$search%")
                    ->where("email", 'LIKE', "%$search%")
                    ->where("phone", 'LIKE', "%$search%")
            		->where("created_at", 'LIKE', "%$search%")
                    ->count();

            $data = Message::where("name", 'LIKE', "%$search%")
                    ->where("email", 'LIKE', "%$search%")
                    ->where("phone", 'LIKE', "%$search%")
                    ->where("created_at", 'LIKE', "%$search%")
                    ->orderBy($column[$request->order[0]['column'] - 1], $request->order[0]['dir'])
                    ->skip($start)
                    ->take($length)
                    ->get();

            $response = [
                'data'  =>  $data,
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
        return $this->view(['data' => Message::find($id)]);
    }
}
