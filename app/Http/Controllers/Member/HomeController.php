<?php

namespace App\Http\Controllers\Member;

use Illuminate\Http\Request;
use App\Models\CompanyProfile;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Models\User;
use App\Models\Rating;
use App\Models\Product;
use App\Models\Reversion;
use App\Models\Delivery;
use App\Models\Booking;
use App\Models\Transaction;
use App\Mail\UserConfirmation;
use App\Mail\BookingProductReject;
use App\Mail\BookingProductToMember;
use App\Mail\TransactionVerify;
use App\Mail\TransactionReject;
use App\Mail\TransactionCancel;
use App\Mail\PaymentConfirmationVerifyToMember;
use App\Mail\PaymentConfirmationVerifyToOwner;
use App\Mail\PaymentConfirmationRejectToMember;
use App\Mail\PaymentConfirmationRejectToOwner;
use App\Mail\PaymentConfirmationApprove;
use App\Mail\ConfirmationDelivery;
use App\Mail\DeliveryProduct;
use App\Mail\ArriveProduct;
use App\Mail\ArriveReversion;
use App\Mail\DeliveryReversion;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:web');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function home()
    {   
        $checkUser = User::find(Auth::user()->id);
        if ( count($checkUser->ratings) ) {
            $users = User::where('privilege', '0')->where('status', 'confirm')->get();
            // dd($users);
            $arr_idProduct = array();

            $product = Product::all();
            for ($i=0; $i < count($product); $i++) { 
                $arr_idProduct[$i] = $product[$i]->id;
            }

            $arr_rating = array(array());
            for ($i=0; $i < count($users); $i++) { 
                for ($j=0; $j < count($product); $j++) { 
                    $arr_rating[$i][$j] = (object)["product_id"=>$product[$j]->id,"rating"=>$this->rate($users[$i]->id, $product[$j]->id),"user_id"=>$users[$i]->id];
                }
            }

            // dd($arr_rating);
            // echo count($arr_rating);
            // exit();
            $arr_absolute = array(array());
            for ($i=0; $i < count($arr_rating[0]); $i++) { 
                for ($j=0; $j < count($arr_rating[0]); $j++) { 
                    $arr_absolute[$i][$j] = (object)["product_id1"=>"","product_id2"=>"","value"=>0];
                    
                    if($i != $j){
                        $per = 0;
                        for($k=0;$k<count($arr_rating);$k++){
                            $arr_absolute[$i][$j]->product_id1 = $arr_rating[$k][$i]->product_id;
                            $arr_absolute[$i][$j]->product_id2 = $arr_rating[$k][$j]->product_id;
                            if($arr_rating[$k][$j]->rating != 0 && $arr_rating[$k][$i]->rating != 0){
                                $per++;
                                $arr_absolute[$i][$j]->value += $arr_rating[$k][$j]->rating-$arr_rating[$k][$i]->rating;
                            }
                        }
                        if($per != 0){
                            $arr_absolute[$i][$j]->value /= $per;
                        }
                    }
                }
            }

            // dd($arr_absolute);

            $user = Auth::user();
            // $user = User::find(6);
            $product_ids = [];
            $arrids = [];
            foreach ($user->ratings as $rating) {
                $product_ids[] = (object)array('id'=>$rating->product_id,'rate'=>$rating->rate);
                $arrids[] = $rating->product_id;
            }

            $prods = Product::whereNotIn('id', $arrids)->where('status', 'publish')->pluck('id');
            // $prods = Product::where('status', 'publish')->pluck('id');
            // dd($prods);

            $predict = [];
            // dd($prods);
            // dd($arrids);
            for($i=0;$i<count($prods);$i++){
                $predict[] = (object)array('product_id'=>$prods[$i], 'value'=>0);
                $userrate = [];
                $userabs  = [];
                for($j=0;$j<count($arr_rating);$j++){
                    if($arr_rating[$j][$prods[$i]-1]->rating != 0){
                        $userrate[] = $arr_rating[$j];
                        $userabs[]  = $arr_absolute[$j];
                    }
                }

                // dd($predict);
                
                $acc = 0;
                $iter = 0;
                for($j=0;$j<count($userrate);$j++){
                    for($k=0;$k<count($userrate[0]);$k++){
                        if($userrate[$j][$k]->product_id == $prods[$i]){
                            if($userrate[$j][$k]->rating != 0){
                                for ($m=0; $m<count($product_ids); $m++) { 
                                    $pecah = array_map(function($obj){
                                        return $obj->product_id;
                                    }, $userrate[$j]);
                                    $ar = array_search($product_ids[$m]->id, $pecah);
                                    
                                    if($userrate[$j][$ar]->rating != 0){
                                        $iter++;
                                        $a = $product_ids[$m]->id;
                                        $b = $prods[$i];
                                        $c = $product_ids[$m]->rate;
                                        $map = array_map(function($obj) use ($a, $b, $c, &$acc){
                                            foreach ($obj as $abs) {
                                                if($abs->product_id1 == $a && $abs->product_id2 == $b){
                                                    $acc += $abs->value + $c;
                                                    // return $abs->value;
                                                }
                                            }
                                        }, $arr_absolute);
                                        // echo $i.". ";
                                        // print_r($acc);
                                        // echo "<br>";
                                        // echo $i.". ".$product_ids[$m]->id." ".$prods[$i]."<br>";
                                        // print_r($product_ids[$m]->id);
                                        // echo $userrate[$j][$ar]->rating."<br>";
                                    }
                                }   
                                // echo "userrate$i ".($prods[$i]-1)."<br>";
                                // echo "[ $i user_abs = ";
                                // print_r($userabs[$j]);
                                // echo "<br> user_rate = ";
                                // print_r($userrate[$j]);
                                // echo "<br> mufia_rating = $k ";
                                // // ajimat
                                // print_r($product_ids[$k]->id-1);
                                // echo "<br> rate = ";
                                // print_r($product_ids[$k]->rate);
                                // echo "]<br><br>";
                            }
                        }
                    } 
                }
                if($iter !== 0){
                    $predict[$i]->value = (1/$iter)*$acc;
                }
                // echo "<br>";
                // print_r($acc);
                // echo $i.". ".$acc."<br>";

            }
            // exit();
            
            usort($predict, function($a,$b)
            {
                if($a->value == $b->value){
                    return 0;
                }
                return ($a->value > $b->value) ? -1 : 1;
            });

            // dd($predict);
             
            // $productYetRate = DB::table('products')
            //                     ->join('ratings', 'products.id', 'ratings.product_id')
            //                     ->whereNotIn('products.id', $prods)
            //                     ->where('ratings.user_id', Auth::user()->id)
            //                     ->where('products.status', 'publish')
            //                     ->select(   'products.id AS product_id',
            //                                 DB::raw('AVG(ratings.rate) as value')
            //                             )
            //                     ->groupBy('products.id')
            //                     ->get()->toArray();

            // dd($productYetRate);
            
            // $allProductRecomendation = array_merge($predict, $productYetRate);

            // usort($allProductRecomendation, function($a,$b)
            // {
            //     if($a->value == $b->value){
            //         return 0;
            //     }
            //     return ($a->value > $b->value) ? -1 : 1;
            // });
            
            // dd($allProductRecomendation);

            $collactionProduct = collect();
            $dataProduct = Product::orderBy('id', 'asc')->get();

            $x = 0;
            $y = 0;
            while( count($collactionProduct) != count($predict) ){
                if( $predict[$x]->product_id == $dataProduct[$y]->id  ){
                    $collactionProduct[$x] = $dataProduct[$y];
                    $x++;
                    $y=0;
                }
                else
                    $y++;
            }

            // dd($collactionProduct);
            // exit();

            // dd( $prods->product_id );
            // dd( $arr_absolute );
            // dd( $arr_rating );
        }
        else{
            $collactionProduct = Product::orderBy('view', 'desc')->get();
        }

        return view('index')    
                ->with('data', CompanyProfile::find(1))
                ->with('products', $collactionProduct);
    }

    private function rate($user, $product)
    {
        $rating = Rating::where('user_id', $user)->where('product_id', $product)->first();

        if( $rating != null )
            return $rating->rate;
        else
            return 0;
    }

    public function test(Request $request){
        // $user = User::find(7);
        // $mail = new UserConfirmation($user);

        // Mail::send($mail);

        // $booking = Booking::find(2);
        // $mail = new BookingProductReject($booking);

        // $transaction = Transaction::find(1);
        // $mail = new PaymentConfirmationApprove($transaction);
        
        // $delivery = Delivery::find(1);
        // $mail = new ArriveProduct($delivery);
         
        $reversion = Reversion::find(1);
        $mail = new ArriveReversion($reversion);
        return $mail;
    }
}

// $user = Auth::user();

// $product_ids = array();
// foreach ($user->ratings as $rating) {
//     $product_ids[] = $rating->product_id;
// }

// $product =  DB::table('products')
//             ->leftjoin('ratings', 'products.id', '=', 'ratings.product_id') 
//             ->select(   "products.id",
//                         DB::raw("AVG(ratings.rate) AS avg_rate") )
//             ->orderBy('avg_rate', 'desc')
//             ->groupBy('products.id')
//             ->whereNotIn('products.id', $product_ids)
//             ->limit(12)
//             ->get();

// $collactionProduct = collect();
// $data = Product::orderBy('id', 'asc')->get();

// $x = 0;
// $y = 0;
// while( count($collactionProduct) != count($product) ){
//     if( $product[$x]->id == $data[$y]->id  ){
//         $collactionProduct[$x] = $data[$y];
//         $x++;
//         $y=0;
//     }
//     else
//         $y++;
// }
