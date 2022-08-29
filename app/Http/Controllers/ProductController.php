<?php

namespace App\Http\Controllers;

use App\Models\Babylist;
use App\Models\Order;
use App\Models\Product;
use Darryldecode\Cart\Facades\CartFacade as Cart;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    //
    public function index(){
        $products = Product::all()->sortBy('title');
        return view('guest/articles',compact('products'));
    }

    public function addItemToList(Request $r, Babylist $id){

        if($id->products === null){
            $arr = [];
            array_push($arr,$r->productID);
            $sArr = serialize($arr);
            $id->products = $sArr;
            $id->save();
        } else{
           $unArr = unserialize($id->products);
           array_push($unArr, $r->productID);
           $sArr = serialize($unArr);
           $id->products = $sArr;
           $id->save();
        }

        return redirect()->back()->with('success','Product has been added to the list');
    }

    public function delete(Request $r,babyList $id){

        $r->validate([
            'productID' => 'required|exists:products,id'
        ]);
        
        $unArr = unserialize($id->products);

        if (($key = array_search($r->productID, $unArr)) !== false) {
            unset($unArr[$key]);
        }

        $sArr= serialize($unArr);
        $id->products = $sArr;
        $id->save();

        return redirect()->back()->with('success',"The product has been removed from the list");
    }


    public function store(Request $r){
        
        $isInCart = false;

        $r->validate([
            'productID' => 'required|exists:products,id'
        ]);
        //Check if product is already in the cart
        foreach(Cart::session(1)->getContent()->pluck('id') as $id){
            if($id == $r->productID) $isInCart = true;
        }


        $product = Product::findOrFail($r->productID);

        if($isInCart){
            return redirect()->back()->with('warning',"This item is already in the basket");
        } else if(count(Cart::session(1)->getContent()) < 5){ //Limit of 5 items in the cart
            Cart::session(1)->add(array(
                'id' =>$product->id,
                'name' =>$product->title,
                'price' =>$product->price,
                'quantity' => 1,
                'attributes' => array(),
                'associatedModel' => $product,
            ));
        } else{
            return redirect()->back()->with('warning',"You are only allowed 5 items in the basket");
        }
        
        return redirect()->back();
    }

    public function getAllPaidProducts(Request $r, Babylist $id){

        $orders = Order::where('list_id',$id->id)->get();
        $babylist = $id;
        
        $totalPrice = 0.00;
        foreach($orders as $order){
            $totalPrice += $order->total;
        }

        //Get all the products that have been ordered already
        $paidProducts = [];
        foreach($orders as $order){
            if($order->status === 'paid'){
                foreach(unserialize($order->products) as $id){
                    array_push($paidProducts,intval($id));
                }
            }
        }

        $purchasedProducts = Product::whereIn('id', $paidProducts)->get();
        
        return view('user/user-list-purchased',compact('purchasedProducts','totalPrice','babylist','orders'));
    }
}
