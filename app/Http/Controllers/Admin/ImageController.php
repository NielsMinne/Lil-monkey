<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageController extends Controller
{
    public function getAllImages(){
        $products = Product::all();
        $this->storeImages($products);
        return redirect()->back();
    }

    private function storeImages($products){
        foreach($products as $product){
            //If there is already an image path in DB -> skip
            if($product->image) continue;

            $info = pathinfo($product->image_external);
            $extension = Str::substr($info['extension'],0,4);
            $image = file_get_contents($product->image_external);
            $slug = $product->slug;
            $fileLocation = 'public/images/' . $product->shop->name . '/' . $slug . "." . $extension;
            
            Storage::put($fileLocation, $image);

            //save path to image table in Product DB
            $product->image = 'images/' . $product->shop->name . '/' . $slug . "." . $extension;
            $product->save();
        }
    }
}
