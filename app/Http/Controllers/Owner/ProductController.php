<?php

namespace App\Http\Controllers\Owner;

use App\Models\File;
use App\Models\User;
use App\Models\Album;
use App\Models\Product;
use App\Models\Location;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use App\Models\IdentityCard;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image as Intervention;

class ProductController extends Controller
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
                "quantity",
                "view",
                "created_at",
            ];

            $total = Product::where("user_id", '=', Auth::user()->id )
                    ->where( function($q) use ($search) {
                        $q->where("name", 'LIKE', "%$search%")
                        ->orWhere("quantity", 'LIKE', "%$search%")
                        ->orWhere("view", 'LIKE', "%$search%");
                    })
            		->count();

            $data = Product::where("user_id", '=', Auth::user()->id )
                    ->where( function($q) use ($search) {
                        $q->where("name", 'LIKE', "%$search%")
                        ->orWhere("quantity", 'LIKE', "%$search%")
                        ->orWhere("view", 'LIKE', "%$search%");
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
        $checkUser = User::find(Auth::user()->id);

    	if( $request->isMethod('post') ){
            if( $checkUser->phone       == null ||
                $checkUser->address     == null ||
                $checkUser->gender      == null ||
                $checkUser->birthdate   == null ||
                $checkUser->birthplace  == null ||
                $checkUser->privilege   == null ||
                $checkUser->file        == null ||
                $checkUser->banks       == null 
            ){
                return response()->json([
                    'success'   => false,
                    'message'   => 'Add Product Can Not Because Your Profile is Not Complete, Please Complete Your Profile.'
                ]);
            }
            else{
                if ( $checkUser->identity_card_id == null ) {
                    return response()->json([
                        'success'   => false,
                        'message'   => 'Add Product Can Not Because You Have Not Upload Your Identity Card, Please to Upload Your Identity Card.'
                    ]);
                }
                else{
                    if( $checkUser->identity_card->status != IdentityCard::STATUS_APPROVED ){
                        return response()->json([
                            'success'   => false,
                            'message'   => 'Add Product Can Not Because Your Identity Card Has Not Been Approved by Admin, Please Wait for Response from Admin.'
                        ]);
                    }
                    else{
                		$validator = $request->validate([
            	    		'name'			        => 'required|string|max:191',
            	    		'category' 		        => 'required|numeric',
                            'sub_category'          => 'required|numeric',
            	    		'quantity' 		        => 'required|numeric',
            	    		'price' 		        => 'required|numeric',
            	    		'file_id'               => 'required|mimes:jpeg,jpg,png|max:5000',
            	    		'description' 	        => 'required|string',
                            'terms_and_conditions'  => 'required|string',
                            'title'                 => 'required|string',
                            'latitude'              => 'required',
                            'longitude'             => 'required',
                            'time_periode'          => 'required|string',
                            'deposite'              => 'nullable|numeric',
                            'status'                => 'required',
            	    	]);

            	    	$product 				        = new Product();
            	    	$product->name 			        = $request->name;
            	    	$product->quantity 		        = $request->quantity;
            	    	$product->price 		        = $request->price;
            	    	$product->description     	    = $request->description;
                        $product->terms_and_conditions  = $request->terms_and_conditions;
                        $product->time_periode          = $request->time_periode;
                        $product->status                = $request->status;
                        
                        if ( $request->deposite != null )
                            $product->deposite = $request->deposite;
                        else
                            $product->deposite = 0;

                        $user = User::where('id', '=', Auth::user()->id )->first();
                        $product->user()->associate($user);

                        if( $request->title != null ){
                            $location               = new Location();
                            $location->title        = $request->title;
                            $location->latitude     = $request->latitude;
                            $location->longitude    = $request->longitude;
                            $location->save();

                            $product->location()->associate($location);
                        }

            	    	if( $request->file_id != null ){
            	    		$filename  = $request->file('file_id')->getClientOriginalName();
            		        $path      = $request->file('file_id')->store('product/' . Auth::user()->id . '/cover/');
            		        $extension = $request->file('file_id')->getClientOriginalExtension();
            		        $size      = $request->file('file_id')->getClientSize();

            		        $file            = new File();
            		        $file->filename  = time() . '_' . $filename;
            		        $file->title     = $request->name;
            		        $file->path      = $path;
            		        $file->extension = $extension;
            		        $file->size      = $size;
            		        $file->save();

            		        $product->file()->associate($file);
            	    	}

            	    	if( $request->sub_category != null ){
            	    		$sub_category 		= SubCategory::where('id', $request->sub_category)->first();

            	    		$product->sub_category()->associate($sub_category);
            	    	}

            	    	$product->save();

            	    	if( !$product->save() ){
            	            if ( $request->hasFile('file_id') ) {
            	               $fileDelete = File::where('path', '=', $file->path)->first();
            	               Storage::delete($fileDelete->path);
            	               $fileDelete->delete(); 
            	            }

                            return response()->json([
                                'success'   => false,
                                'message'   => 'Product Not Successfully Added'
                            ]);
            	        }
            	        else{
            	            return response()->json([
            	                'success'  => true,
            	                'message'  => 'Product Successfully Added'
            	            ]);
            	        }
                    }
                }
            }

    	}

    	return $this->view(['data' => Category::all(),
                            'subCategory' => SubCategory::all(),
                            ]);
    }

    public function show($id)
    {
        return $this->view(['data' => Product::find($id)]);
    }

    public function update(Request $request, $id)
    {
        if( $request->isMethod('post') ){
            $validator = $request->validate([
                'name'                  => 'required|string|max:191',
                'category'              => 'required|numeric',
                'sub_category'          => 'required|numeric',
                'quantity'              => 'required|numeric',
                'price'                 => 'required|numeric',
                'file_id'               => 'nullable|mimes:jpeg,jpg,png|max:5000',
                'description'           => 'required|string',
                'terms_and_conditions'  => 'required|string',
                'title'                 => 'required|string',
                'latitude'              => 'required',
                'longitude'             => 'required',
                'time_periode'          => 'required|string',
                'deposite'              => 'nullable|numeric',
                'status'                => 'required',
            ]);

            $product                        = Product::find($request->id);
            $product->name                  = $request->name;
            $product->quantity              = $request->quantity;
            $product->price                 = $request->price;
            $product->description           = $request->description;
            $product->terms_and_conditions  = $request->terms_and_conditions;
            $product->status                = $request->status;
            $product->time_periode          = $request->time_periode;
            $product->deposite              = $request->deposite;

            if( $request->title != null ){
                if ($product->location != null) {
                    $location               = Location::find($product->location_id);
                    $location->title        = $request->title;
                    $location->latitude     = $request->latitude;
                    $location->longitude    = $request->longitude;
                }
                else{
                    $location           = new Location();
                    $location->title        = $request->title;
                    $location->latitude     = $request->latitude;
                    $location->longitude    = $request->longitude;
                }

                $location->save();
                $product->location()->associate($location);
            }

            if( $request->file_id != null ){
                if( $product->file_id != null ){
                    $picture = File::find(intval($product->file_id));
                    Storage::delete($picture->path);
                    $picture->delete();
                }

                $filename  = $request->file('file_id')->getClientOriginalName();
                $path      = $request->file('file_id')->store('product/' . Auth::user()->id . '/cover/');
                $extension = $request->file('file_id')->getClientOriginalExtension();
                $size      = $request->file('file_id')->getClientSize();

                $file            = new File();
                $file->filename  = time() . '_' . $filename;
                $file->title     = $request->name;
                $file->path      = $path;
                $file->extension = $extension;
                $file->size      = $size;
                $file->save();

                $product->file()->associate($file);
            }


            if( $request->sub_category != null ){
                $sub_category       = SubCategory::where('id', $request->sub_category)->first();

                $product->sub_category()->associate($sub_category);
            }

            $product->save();

            if( !$product->save() ){
                if ( $request->hasFile('file_id') ) {
                   $fileDelete = File::where('path', '=', $file->path)->first();
                   Storage::delete($fileDelete->path);
                   $fileDelete->delete(); 
                }

                return response()->json([
                    'success'   => false,
                    'message'   => 'Product Not Successfully Added'
                ]);
            }
            else{
                return response()->json([
                    'success'  => true,
                    'message'  => 'Product Successfully Added'
                ]);
            }
        }

        $product = Product::find($id);

        return $this->view(['data'          => $product,
                            'categories'    => Category::all(),
                            'subCategories' => SubCategory::all(), 
                            'subCategory'   => SubCategory::where('category_id', $product->sub_category->category_id)->get(), 
                        ]);
    }

    public function destroy($id)
    {
        $product = Product::find($id);
        
        $file = File::find($product->file_id);
        if( $product->file_id != null ){
            Storage::delete($file->path);
            $file->delete();
        }

        if( $product->delete() ){
            return response()->json([
                'success'   => true,
                'message'   => 'Product Successfully Deleted'
            ]);
        }
        else{
            return response()->json([
                'success'   => false,
                'message'   => 'Product Not Successfully Deleted'
            ]); 
        }
    }

    public function upload(Request $request, $id){
        if( $request->isMethod('post') ){
            
            if( $request->flag == 2 ){
                $file = File::where('filename', '=', $request->name)->first();

                $album = Album::where('product_id', '=', $id)->where('file_id', '=', $file->id)->first();
                
                Storage::delete($file->path);
                $file->delete();
                
                $album->delete();
                
                return response()->json([
                    'success'   => true,
                    'message'   => 'Foto Successfully Deleted'
                ]);
            }
            else{    
                $data = $request->all();
                $time = date( "d-m-Y H.i.s");

                $validator = $request->validate([
                    'file'    => 'required',
                ]);
                
                foreach ($data['file'] as $item) {
                    $album                = new Album();
                    $album->product_id    = $id;

                    $filename   = $item->getClientOriginalName();
                    $path       = $item->store('product/' . Auth::user()->id . '/album/');
                    $extension  = $item->getClientOriginalExtension();
                    $size       = $item->getClientSize();

                    $file            = new File();
                    $file->filename  = $filename;
                    $file->title     = date( "d-m-Y H.i.s", strtotime( '+1 second',strtotime(($time)) ) );
                    $file->path      = $path;
                    $file->extension = $extension;
                    $file->size      = $size;
                    $file->save();

                    $album->file()->associate($file);
                    
                    $album->save();
                }

                if( !$album->save() ){
                    if ( $request->hasFile('file_id') ) {
                       $imgDelete = File::where('path', '=', $file->path);
                       Storage::delete($imgDelete->path);
                       $imgDelete->delete(); 
                    }
                }
                else{
                    return response()->json([
                        'success' => true,
                        'message' => 'Foto Successfully Uploaded',
                    ]);
                }
            }

        }

        return $this->view(['data' => Product::find($id)]);
    }
}
