<?php

namespace App\Http\Controllers\Admin;

use App\Models\Location;
use Illuminate\Http\Request;
use App\Models\CompanyProfile;
use App\Http\Controllers\Controller;

class CompanyProfileController extends Controller
{
    public function index()
    {
    	return $this->view(['data' => CompanyProfile::find(1)]);
    }

    public function contact(Request $request)
    {
        $validator = $request->validate([
            'email' => 'required|email',
            'phone' => 'nullable|phone:ID',
        ]);

        $companyProfile         = CompanyProfile::find(1);
        $companyProfile->email  = $request->email;
        $companyProfile->phone  = $request->phone;

        if( $companyProfile->save() ){
            return response()->json([
                'success'   => true,
                'message'   => 'Contact Successfully Edited'
            ]);
        }
        else{
            return response()->json([
                'success'   => false,
                'message'   => 'Contact Not Successfully Edited'
            ]); 
        }
    }

    public function description(Request $request)
    {
    	$companyProfile  				= CompanyProfile::find(1);
    	$companyProfile->description 	= $request->description;

    	if( $companyProfile->save() ){
    		return response()->json([
	            'success'   => true,
	            'message'   => 'Who We Are Successfully Edited'
	        ]);
    	}
    	else{
    		return response()->json([
	            'success'   => false,
	            'message'   => 'Who We Are Not Successfully Edited'
	        ]);	
    	}
    }

    public function terms_of_use(Request $request)
    {
    	$companyProfile  				= CompanyProfile::find(1);
    	$companyProfile->terms_of_use 	= $request->terms_of_use;

    	if( $companyProfile->save() ){
    		return response()->json([
	            'success'   => true,
	            'message'   => 'Terms Of Use Successfully Edited'
	        ]);
    	}
    	else{
    		return response()->json([
	            'success'   => false,
	            'message'   => 'Terms Of Use Not Successfully Edited'
	        ]);	
    	}
    }

    public function privacy_policy(Request $request)
    {
    	$companyProfile  				= CompanyProfile::find(1);
    	$companyProfile->privacy_policy = $request->privacy_policy;

    	if( $companyProfile->save() ){
    		return response()->json([
	            'success'   => true,
	            'message'   => 'Privacy Policy Successfully Edited'
	        ]);
    	}
    	else{
    		return response()->json([
	            'success'   => false,
	            'message'   => 'Privacy Policy Not Successfully Edited'
	        ]);	
    	}
    }

    public function location(Request $request)
    {
        $companyProfile     = CompanyProfile::find(1);

        if( $companyProfile->location_id == null ){
            $location               = new Location();
            $location->title        = $request->title;
            $location->latitude     = $request->latitude;
            $location->longitude    = $request->longitude;
            $location->save();

            $companyProfile->location()->associate($location);
            $companyProfile->save();
        }
        else{
            $location = Location::where('id', $companyProfile->location_id)->first();
            $location->title        = $request->title;
            $location->latitude     = $request->latitude;
            $location->longitude    = $request->longitude;
            $location->save();
        }

        return response()->json([
            'success'   => true,
            'message'   => 'Set Location Successfully Edited'
        ]);
    }
}
