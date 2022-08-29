<?php

use App\Http\Controllers\Admin\ScrapeController;
use App\Http\Controllers\Admin\ImageController;
use App\Http\Controllers\BabylistController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\WebhookController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('guest/home');
});

Route::get('/products',[ProductController::class, 'index'])->name('products');

//admin scraping routes
Route::prefix('/admin')->middleware(['admin'])->group(function() { 
    Route::get('/scrape', [ScrapeController::class, 'index'])->name('scrape');
    Route::get('/categories', [ScrapeController::class, 'scrapedCategoriesShow'])->name('scrape.categories.show');
    Route::post('/scrape/categories', [ScrapeController::class, 'scrapeCategories'])->name('scrape.categories');
    Route::post('/scrape/products', [ScrapeController::class, 'scrapeProducts'])->name('scrape.products');
    Route::get('/scrape/pictures', [ImageController::class, 'getAllImages'])->name('scrape.images');
});


Route::prefix('')->middleware(['auth'])->group(function() { 
    Route::get('/create-list', [BabylistController::class, 'createList'])->name('list.create');
    Route::post('/create-list', [BabylistController::class, 'add'])->name('list.add');
    Route::get('/my-lists', [BabylistController::class, 'showUserLists'])->name('list.user');
    Route::get('/my-list/export', [OrderController::class,'export'])->name('export');
    Route::get('/my-list/{id}', [BabylistController::class, 'showSpecificList'])->name('list.specific');
    Route::get('/my-list/{id}/sorted-price', [BabylistController::class, 'showSpecificListSortedByPrice'])->name('list.sortedByPrice');
    Route::get('/my-list/{id}/sorted-name', [BabylistController::class, 'showSpecificListSortedByName'])->name('list.sortedByName');
    Route::post('my-list/{id}', [ProductController::class, 'addItemToList'])->name('product.addList');
    Route::get('/my-list/{id}/products', [BabylistController::class, 'showProductsInList'])->name('list.detail');
    Route::get('/my-list/{id}/purchased', [ProductController::class, 'getAllPaidProducts'])->name('list.purchased');
Route::post('/my-list/{id}/products', [ProductController::class, 'delete'])->name('product.delete');
Route::put('/my-list/{id}/edit', [BabylistController::class, 'edit'])->name('list.edit');
});

Route::prefix('/geboortelijst')->group(function() {
    Route::get('/{childName}-{userID}', [BabylistController::class,'askPasswordForList']);
    Route::post('/{childName}-{userID}', [BabylistController::class,'verifyPassword'])->name('list.guest.enter');
    Route::post('/{childName}-{userID}/add', [ProductController::class,'store'])->name('list.guest.addCart');
    Route::get('/checkout', [CheckoutController::class,'checkout'])->name('checkout');
    Route::get('/checkout/success', [CheckoutController::class,'success'])->name('checkout.success');
});


Route::post('/webhooks/mollie',[WebhookController::class, 'handle'])->name('webhooks.mollie');


require __DIR__.'/auth.php';
