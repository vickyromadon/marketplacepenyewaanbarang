<?php

namespace App\Http\Controllers\Member;

use App\Models\User;
use App\Models\Rating;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class MaeController extends Controller
{
    public function index()
    {
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
        // dd($arrids);
        
        $predict = [];
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
            if($a->product_id == $b->product_id){
                return 0;
            }
            return ($a->product_id < $b->product_id) ? -1 : 1;
        });

        // dd($predict);

        $totProduct = Product::all();
        $pengguna = Auth::user();

        $produk_ids = array();
        foreach ($pengguna->ratings as $rating) {
            $produk_ids[] = $rating->product_id;
        }

        // dd($pengguna);
        
        // $totalUser = count($users);

        $produk =  DB::table('products')
                    ->leftjoin('ratings', 'products.id', '=', 'ratings.product_id') 
                    ->select(   "products.id",
                                DB::raw("AVG(ratings.rate) AS avg_rate") )
                    ->orderBy('id', 'asc')
                    ->groupBy('products.id')
                    ->whereNotIn('products.id', $produk_ids)
                    ->where('products.status', 'publish')
                    ->get();

        // dd($produk);

        $mae = array();
        $totalMae = 0;
        for ($i=0; $i < count($produk); $i++) { 
            $detailProduk = Product::with(['file'])->find($produk[$i]->id);
            $mae[$i] = (object)array(   'id' => $produk[$i]->id, 
                                        'detail'    => $detailProduk,
                                        'average'   => $produk[$i]->avg_rate,
                                        'predict'   => $predict[$i]->value,
                                        'mae'       => abs( floatval($produk[$i]->avg_rate) - $predict[$i]->value) 
                                    );

            $totalMae += abs( floatval($produk[$i]->avg_rate) - $predict[$i]->value);
        }

        usort($mae, function($a,$b)
        {
            if($a->predict == $b->predict){
                return 0;
            }
            return ($a->predict > $b->predict) ? -1 : 1;
        });        

		// dd($mae);
        
        $totalRating = DB::table('ratings')
                        ->select('product_id')
                        ->groupBy('product_id')
                        ->where('user_id', Auth::user()->id)
                        ->get();

        // dd(count($totProduct) - count($totalRating));

    	return $this->view(['mae' => $mae, 
                            'totalProduct' => count($totProduct),
                            'totalMae' => $totalMae  / (count($totProduct) - count($totalRating)),
                            'totalProductRating' => count($totalRating),
                        ]);
    }

    private function rate($user, $product)
    {
        $rating = Rating::where('user_id', $user)->where('product_id', $product)->first();

        if( $rating != null )
            return $rating->rate;
        else
            return 0;
    }
}
