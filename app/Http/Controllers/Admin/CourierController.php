<?php

namespace App\Http\Controllers\Admin;

use App\Models\File;
use App\Models\Courier;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class CourierController extends Controller
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
                "file",
                "created_at",
            ];

            $total = Courier::with(['file'])
            		->where("name", 'LIKE', "%$search%")
            		->count();

            $data = Courier::with(['file'])
            		->where("name", 'LIKE', "%$search%")
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
    		'name'		=> 'required|string|max:191|unique:couriers',
    		'file_id' 	=> 'required|mimes:jpeg,jpg,png|max:5000',
    	]);

    	$courier  	= new Courier();
    	$courier->name 	= $request->name;

    	if( $request->file_id != null ){
    		$filename  = $request->file('file_id')->getClientOriginalName();
	        $path      = $request->file('file_id')->store('courier');
	        $extension = $request->file('file_id')->getClientOriginalExtension();
	        $size      = $request->file('file_id')->getClientSize();

	        $file            = new File();
	        $file->filename  = time() . '_' . $filename;
	        $file->title     = $request->name;
	        $file->path      = $path;
	        $file->extension = $extension;
	        $file->size      = $size;
	        $file->save();

	        $courier->file()->associate($file);
    	}

    	$courier->save();

    	if( !$courier->save() ){
            if ( $request->hasFile('file_id') ) {
               $fileDelete = File::where('path', '=', $file->path)->first();
               Storage::delete($fileDelete->path);
               $fileDelete->delete(); 
            }

            return response()->json([
                'success'   => false,
                'message'   => 'Courier Not Successfully Added'
            ]);
        }
        else{
            return response()->json([
                'success'  => true,
                'message'  => 'Courier Successfully Added'
            ]);
        }
    }

    public function update(Request $request)
    {
    	$validator = $request->validate([
    		'name'		=> ['required', 'string', 'max:191', Rule::unique('couriers')->ignore($request->id)],
    		'file_id' 	=> 'nullable|mimes:jpeg,jpg,png|max:5000',
    	]);

    	$courier  		= Courier::find($request->id);
    	$courier->name 	= $request->name;

    	if( $request->file_id != null ){
            if( $request->hasFile('file_id') != null ){
                $picture = File::find(intval($courier->file_id));
                Storage::delete($picture->path);
                $picture->delete();
            }

            $filename  = $request->file('file_id')->getClientOriginalName();
            $path      = $request->file('file_id')->store('courier');
            $extension = $request->file('file_id')->getClientOriginalExtension();
            $size      = $request->file('file_id')->getClientSize();
            
            $file            = new File();
            $file->filename  = time() . '_' . $filename;
            $file->title     = $request->name;
            $file->path      = $path;
            $file->extension = $extension;
            $file->size      = $size;
            $file->save();

            $courier->file()->associate($file);
        }

        $courier->save();

        if( !$courier->save() ){
            if ( $request->hasFile('file_id') ) {
               $fileDelete = File::where('path', '=', $file->path)->first();
               Storage::delete($fileDelete->path);
               $fileDelete->delete(); 
            }

            return response()->json([
                'success'   => false,
                'message'   => 'Courier Not Successfully Edited'
            ]);
        }
        else{
            return response()->json([
                'success'  => true,
                'message'  => 'Courier Successfully Edited'
            ]);
        }
    }

    public function destroy($id)
    {
        $courier = Courier::find($id);
        
        $file = File::find($courier->file_id);
        if( $courier->file_id != null ){
            Storage::delete($file->path);
            $file->delete();
        }

        if( $courier->delete() ){
            return response()->json([
                'success'   => true,
                'message'   => 'Courier Successfully Deleted'
            ]);
        }
        else{
            return response()->json([
                'success'   => false,
                'message'   => 'Courier Not Successfully Deleted'
            ]); 
        }

    }
}
