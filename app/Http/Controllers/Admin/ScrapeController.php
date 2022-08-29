<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Goutte\Client;
use stdClass;

class ScrapeController extends Controller
{

    public function index() {
        $categories= Category::all();
        return view('admin/scraper', compact('categories'));
    }

    public function scrapedCategoriesShow(){
        $categories = Category::all()->sortBy('title');
        return view('admin/scraped-categories', compact('categories'));
    }


    public function scrapeCategories(Request $r){
        switch($r->shop){
            case '1' :
                $this->scrapeBabyCornerCategories($r->url, $r->shop);
                break;
            case '2':
                $this->scrapeBabyParkCategories($r->url,$r->shop);
                break;
            case '3':
                $this->scrapeAprilvisjeCategory($r->url,$r->shop);
                break;
        }
    }

    public function scrapeProducts(Request $r){
        switch($r->shop){
            case '1' :
                return $this->scrapeBabyCornerProducts($r, $r->url);
                break;
            case '2':
                $this->scrapeBabyParkProducts($r,$r->url);
                break;
            case '3':
                $this->scrapeAprilvisjeProducts($r, $r->url);
                break;
        }
    }

    
    //All logic for scraping of Baby Corner
    public function scrapeBabyCornerCategories($url, $shopId){
        $client = new Client();
        $crawler = $client->request('GET', $url);

        $categories = $crawler->filter('.facets .facet:nth-child(3) div ul li label a')
        ->each(function($node) {
            $title = $node->text();
            $url = 'https://www.thebabyscorner.be' . $node->attr('href');

            $cat = new stdClass();
            $cat->title = $title;
            $cat->url = $url;
            return $cat;
        });

        foreach($categories as $scrapeCategory){
            //Checks if category is already in the database
            $exists = Category::where('url', $scrapeCategory->url)->count();
            if($exists > 0 ) continue;

            //Creating and adding the categories to DB
            $categoryEntity = new Category();
            $categoryEntity->title = $scrapeCategory->title;
            $categoryEntity->url = $scrapeCategory->url;
            $categoryEntity->shop_id = $shopId;
            $categoryEntity->save();
        }

        return redirect()->back();
    }

    
    private function scrapeBabyCornerProducts($r, $url){

        $client = new Client();
        $crawler = $client->request('GET', $url);

        $products = $crawler->filter('.l-products-item')->each(function($node){
            $client = new Client();
            $product = new stdClass();
            $productCrawler = $client->request('GET', 'https://www.thebabyscorner.be' . $node->filter('.hyp-thumbnail')->attr('href'));

            $product->title = $productCrawler->filter('.details-info .font-product-title')->text();
            $product->EAN_code = $productCrawler->filter('.product-id .value')->text();

            $slug = $productCrawler->filter('.details-info .font-product-title')->text();
            $product->slug = Str::of($slug)->slug('-')->value();

            $product->price = $productCrawler->filter('.lbl-price')->text();
            $product->image_external = 'https://www.thebabyscorner.be' . $productCrawler->filter('.details-img .carousel-image-m-wrapper div .carousel-image-m  img')->attr('data-src');
            $product->url = 'https://www.thebabyscorner.be' . $node->filter('.hyp-thumbnail')->attr('href');

            return $product;
        });


        foreach($products as $scrapeProduct){
            //Checks if product is already in the database
            $exists = Product::where('title', $scrapeProduct->title)->count();
            if($exists > 0 ) continue;
            //Creating and adding the products to the DB
            $productEntity = new Product();
            $productEntity->slug = $scrapeProduct->slug;
            $productEntity->EAN_code = $scrapeProduct->EAN_code;
            $productEntity->title = $scrapeProduct->title;

            //making the price a float
            $productEntity->price = floatval((str_replace(
                array("€",","),
                array("", "."),
                $scrapeProduct->price
            )));

            $productEntity->image_external = $scrapeProduct->image_external;
            $productEntity->category_id = $r->category_id;
            $productEntity->shop_id = $r->shop;
            $productEntity->url = $scrapeProduct->url;
            $productEntity->save();
        }

        return redirect()->back();
    }

   
    //All logic for scraping of Baby Corner
    public function scrapeBabyParkCategories($url,$shopId){
        $client = new Client();
        $crawler = $client->request('GET', $url);

        $categories = $crawler->filter('.block-content dl dd ol li a')
        ->each(function($node) {
            $title = $node->text();
            $url = $node->attr('href');

            $cat = new stdClass();
            $cat->title = $title;
            $cat->url = $url;
            return $cat;
        });

        foreach($categories as $scrapeCategory){
             //Checks if category is already in the database
            $exists = Category::where('url', $scrapeCategory->url)->count();
            if($exists > 0 ) continue;

            //Creating and adding the categories to the DB
            $categoryEntity = new Category();
            $categoryEntity->title = $scrapeCategory->title;
            $categoryEntity->url = $scrapeCategory->url;
            $categoryEntity->shop_id = $shopId;
            $categoryEntity->save();
        }

        return redirect()->back();
    }


    private function scrapeBabyParkProducts($r, $url){

        $client = new Client();
        $crawler = $client->request('GET', $url);

        $products = $crawler->filter('.product-listing .products-grid .item')->each(function($node){
            $client = new Client();
            $product = new stdClass();
            $productCrawler = $client->request('GET', $node->filter('.item__content .item__image a')->attr('href'));

            $product->title = $productCrawler->filter('.product-name__title')->text();
            $product->EAN_code = $productCrawler->filter('.ean_code-attribute-custom')->text();
            $slug = $product->title;
            $product->image_external = $productCrawler->filter('#image')->attr('src');
            $product->slug = Str::of($slug)->slug('-')->value();
            $product->price = $productCrawler->filter('.price')->text();
            $product->url =  $node->filter('.item__content .item__image a')->attr('href');

            return $product;
        });

       
        foreach($products as $scrapeProduct){
            //Checks if product is already in the database
            $exists = Product::where('title', $scrapeProduct->title)->count();
            if($exists > 0 ) continue;

            //Creating and adding the products to the DB
            $productEntity = new Product();
            $productEntity->slug = $scrapeProduct->slug;
            $productEntity->EAN_code = $scrapeProduct->EAN_code;
            $productEntity->title = $scrapeProduct->title;
            //price to float
            $productEntity->price = floatval(str_replace(',','.',$scrapeProduct->price));
            $productEntity->image_external = $scrapeProduct->image_external;
            $productEntity->category_id = $r->category_id;
            $productEntity->shop_id = $r->shop;
            $productEntity->url = $scrapeProduct->url;
            $productEntity->save();
        }

        return redirect()->back();
    }

    //All logic for scraping of Aprilvisje
    public function scrapeAprilvisjeCategory($url,$shopId){
            $client = new Client();
            $crawler = $client->request('GET', $url);

            $categories = $crawler->filter('.list-content div .col-lg-4')
            ->each(function($node) {
                $title = $node->filter('.info h3 a')->text();
                $url = "https://www.aprilvisje.be" . $node->filter('a')->attr('href');

                $cat = new stdClass();
                $cat->title = $title;
                $cat->url = $url;
                return $cat;
            });
           
            
            foreach($categories as $scrapeCategory){
                 //Checks if category is already in the database
                $exists = Category::where('url', $scrapeCategory->url)->count();
                if($exists > 0 ) continue;

                //Creating and adding the categories
                $categoryEntity = new Category();
                $categoryEntity->title = $scrapeCategory->title;
                $categoryEntity->url = $scrapeCategory->url;
                $categoryEntity->shop_id = $shopId;
                $categoryEntity->save();
            }

            return redirect()->back();
    }

    private function scrapeAprilvisjeProducts($r, $url){

        $client = new Client();
        $crawler = $client->request('GET', $url);

        $products = $crawler->filter('.list-content div .col-lg-4')->each(function($node){
            $client = new Client();
            $product = new stdClass();
            $productCrawler = $client->request('GET',"https://www.aprilvisje.be" . $node->filter('.info .title a')->attr('href'));

            $product->title = $productCrawler->filter('.container .page-title')->text();
            $product->EAN_code = $productCrawler->filter('.code .value')->text();
            $slug = $product->title;
            $product->slug = Str::of($slug)->slug('-')->value();
            $product->image_external = $productCrawler->filter('.img-responsive')->attr('src');
            //had to trim the euro sign to make it a float
            $priceWithoutSign = trim($productCrawler->filter('.price-current')->text(),"€\xC2\xA0");
            $priceToFloat = floatval(str_replace(',','.',$priceWithoutSign));
            $product->price = $priceToFloat;

            $product->url =  "https://www.aprilvisje.be" . $node->filter('.info .title a')->attr('href');

            return $product;
        });

        foreach($products as $scrapeProduct){
             //Checks if product is already in the database
            $exists = Product::where('title', $scrapeProduct->title)->count();
            if($exists > 0 ) continue;

            //Creating and adding the categories
            $productEntity = new Product();
            $productEntity->slug = $scrapeProduct->slug;
            $productEntity->EAN_code = $scrapeProduct->EAN_code;
            $productEntity->title = $scrapeProduct->title;
            $productEntity->price = $scrapeProduct->price;
            $productEntity->image_external = $scrapeProduct->image_external;
            $productEntity->category_id = $r->category_id;
            $productEntity->shop_id = $r->shop;
            $productEntity->url = $scrapeProduct->url;
            $productEntity->save();
        }

        return redirect()->back();
    }
}
