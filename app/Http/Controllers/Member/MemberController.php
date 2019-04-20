<?php

namespace App\Http\Controllers\Member;

use App\Models\Faq;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\CompanyProfile;
use App\Http\Controllers\Controller;

class MemberController extends Controller
{
    public function index()
    {
    	return view('index')
    			->with('data', CompanyProfile::find(1))
                ->with('products', Product::orderBy('view', 'desc')->get());
    }

    public function howitworks()
    {
    	return $this->view();
    }

    public function termsofuse()
    {
    	return $this->view(['data' => CompanyProfile::find(1)]);
    }

    public function privacypolicy()
    {
    	return $this->view(['data' => CompanyProfile::find(1)]);
    }

    public function faqs()
    {
    	return $this->view(['data' => Faq::paginate(5)]);
    }

    public function location()
    {
        return $this->view(['data' => CompanyProfile::find(1)]);
    }

    public function main_categories()
    {
        return view('main_categories')
                ->with('data', Category::all());
    }
}
