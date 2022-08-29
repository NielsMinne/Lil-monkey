<?php

namespace App\Http\Controllers;

use App\Models\Babylist;
use App\Models\Order;
use App\Models\Product;
use Darryldecode\Cart\Facades\CartFacade as Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;



class BabylistController extends Controller
{
    public function createList(){
        $listTables = DB::getSchemaBuilder()->getColumnListing('babylists');
        return view('user/create-list',compact('listTables'));
    }

    public function add(Request $r){

        //if List exists in DB -> skip
        $exists = Babylist::where('name_list', $r->name_list)->count();
        if($exists > 0 ) return;

        $r->validate([
            'user_id' => 'required|exists:users,id',
            'name_list' => 'required|max:255',
            'name_child' => 'required|max:255',
            'password' => 'required|min:6',
        ]);

        $list = new Babylist();
        $list->user_id = $r->user_id;
        $list->name_list = $r->name_list;
        $list->name_child = str_replace(" ","_",$r->name_child);

        if($r->message){
            $list->message = $r->message;
         }else {
             $list->message = " ";
         }
        
        $list->password = $r->password;
        $list->url = "/geboortelijst/" . $list->name_child . "-" . $list->user_id;
        $list->save();

        return redirect()->back()->with("success","Your list has been created");
    }

    public function edit(Request $r ,Babylist $id){
        
        $r->validate([
            'user_id' => 'required|exists:users,id',
            'name_list' => 'required|max:255',
            'name_child' => 'required|max:255',
            'password' => 'required|min:6',
        ]);

        $id->name_child = str_replace(" ","_",$r->name_child);
        $id->name_list = $r->name_list;
        $id->password = $r->password;
        $id->message = $r->message;
        $id->save();

        return redirect()->back()->with('success','Your list has been successfully edited');
    }


    public function showUserLists(){

    $user_id = auth()->user()->id;

    $lists = Babylist::where('user_id', $user_id)->paginate(10);
    
    $amountOfProducts = [];
    foreach($lists as $list){
        if($list->products != null){
        $unArrCount = count(unserialize($list->products));
        $amountOfProducts[$list->id] = $unArrCount;
        } else{
            $amountOfProducts[$list->id] = 0;
        }
    }

   
    return view('user/user-lists',compact('lists','amountOfProducts'));
    }


    private function getCategories($products){
        $categories = [];
        foreach($products->pluck('category.title')->unique() as $product){
            array_push($categories, $product);
        }
        sort($categories);
        return $categories;
    }

   
    public function showSpecificList(Babylist $id){

        if($id->user_id !== auth()->user()->id){
            return redirect()->back()->with('error','You do not have permission to view this list');
        } 
    
        if($id->products){
        $unArr = unserialize($id->products);
        $products = Product::whereNotIn('id',$unArr)->get()->sortBy('category.title');
        }else{
        $products = Product::all()->sortBy('category.title');
        }
        $babylist= $id;

        $categories = $this->getCategories($products);

        return view('user/specific-list',compact('products','categories','babylist'));
    }

    public function showSpecificListSortedByPrice(Babylist $id){
        if($id->user_id !== auth()->user()->id){
            return redirect()->back()->with('error','You do not have permission to view this list');
        } 
    
        if($id->products){
            $unArr = unserialize($id->products);
            $products = Product::whereNotIn('id',$unArr)->get()->sortBy('price');
        }else{
            $products = Product::all()->sortBy('price');
        }

        $babylist= $id;

        $categories = $this->getCategories($products);

        return view('user/specific-list',compact('products','categories','babylist'));
    }

    
    public function showSpecificListSortedByName(Babylist $id){
        if($id->user_id !== auth()->user()->id){
            return redirect()->back()->with('error','You do not have permission to view this list');
        } 
    
        if($id->products){
        $unArr = unserialize($id->products);
        $products = Product::whereNotIn('id',$unArr)->get()->sortBy('title');
        }else{
        $products = Product::all()->sortBy('title');
        }

        $babylist= $id;

        $categories = $this->getCategories($products);

        return view('user/specific-list',compact('products','categories','babylist'));
    }


    public function showProductsInList(Babylist $id){
        $listTables = DB::getSchemaBuilder()->getColumnListing('babylists');
        $products_arr = unserialize($id->products);

        $paidProducts = $this->getPaidProductsID($id);

        $arr = [];
        foreach($products_arr as $listProduct){
            array_push($arr, intval($listProduct));
        }
        $productsInList = Product::whereIn('id', $arr)->paginate(7);
        $products = Product::whereIn('id', $arr)->get();
        $totalPrice = 0.00;
        foreach($products as $product){
            $totalPrice += $product->price;
        }
        
        $babylist = $id;

        return view('user/edit-list',compact('productsInList','babylist','listTables','totalPrice','paidProducts'));
    }

    private function showBabylist($babylist){
        $cart = Cart::session(1);

        if(!$babylist->products){
            return redirect()->back()->with('warning','This list has no products in it yet.');
        } else{

        $paidProducts = $this->getPaidProductsID($babylist);
        $products_arr = unserialize($babylist->products);
        $arr = [];
        foreach($products_arr as $listProduct){
         array_push($arr, intval($listProduct));
        }
        $productsInList = Product::whereIn('id',$arr)->get();
        return view('guest-list',compact('babylist','productsInList','cart','paidProducts'));
        }
    }

    public function askPasswordForList(Request $r,$name,$id){
        $babylist = Babylist::where('name_child', $name)->where('user_id', $id)->firstOrFail();
        
        
        if(session('password') === $babylist->password){
           return $this->showBabylist($babylist);
        } else {
            return view('guest-list-form',compact('babylist'));
        }
    }

    private function getPaidProductsID($babylist){
        $orders = Order::where('list_id',$babylist->id)->get();
        
        $paidProducts = [];

        foreach($orders as $order){
            if($order->status === 'paid'){
            foreach(unserialize($order->products) as $id){
                array_push($paidProducts,intval($id));
                }
            }
        }

        return $paidProducts;
    }

    
    public function verifyPassword(Request $r,$name,$id){

        $babylist = Babylist::where('name_child', $name)->where('user_id', $id)->firstOrFail();
       
        if($r->password === $babylist->password){
            $r->session()->put('password', $babylist->password);
            return $this->showBabylist($babylist);
        } else{
            return redirect()->back()->with('error','Incorrect Password');
        }
        
    }

}
