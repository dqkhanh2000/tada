<?php

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
// get route

use App\GroupProduct;
use App\Order;
use App\Product;
use App\ProductByColor;
use App\Voucher;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Request;

//page
Route::get('/home', 'PageController@home');

Route::get('/', 'PageController@home')->name("home");

Route::get('/product', 'PageController@product')->name("product");

Route::get('/cart', 'PageController@cart')->name("cart")->middleware('auth');

Route::get('/order', 'PageController@order')->name('order')->middleware('auth');

Route::get('detail/{id}', 'PageController@detail')->name('detail');

Route::get('collection/{type}/{category?}', 'PageController@category')->name('category');

Route::get('search/', "PageController@search")->name("search");

Route::get('/contact', "PageController@contact")->name("contact");

//admin route
Route::group([
    'as' => 'admin.',
    'prefix' => 'dashboard',
    'middleware' => ['auth', 'admin']
    ],
    function() {
        Route::get('/', 'AdminController@index')->name('admin');

        Route::get('/order', 'AdminController@order')->name('order');

        Route::get('/customer', 'AdminController@customer')->name('customer');

        Route::post('/edit-product/delete-img', 'AdminController@deleteImage')->name('deleteImage');

        Route::post('/change-order-status', function (Request $request) {
            $order = Order::find($request->id);
            $order->Status = $request->status;
            if($order->save()) return 'ok';
        })->name('changeOrderStatus');

        Route::post('/change-quantity/product', function (Request $request){
            $product = Product::find($request->id);
            $product->quantity_storage = $request->quantity;
            if($product->save()) return 'ok';
            return 'false';
        })->name('changeQuantityProduct');

        Route::post('/change-voucher', function (Request $request) {
            $voucher = Voucher::find($request->id);
            if($request->quantity) $voucher->Quantity = $request->quantity;
            if($request->value) $voucher->Value = $request->value;
            if($request->status) $voucher->Status = $request->status;
            $voucher->save();
        })->name('changeVoucher');

        Route::post('/new-size', function (Request $request){
            if($request->size){
                $isUsed = Product::where('id_product_color', $request->colorid)
                                    ->where('Size', $request->size)->get();
                if($isUsed->first())return ['error'=> 'Size đã tồn tại'];
                else {
                    $size = new Product;
                    $size->Size = $request->size;
                    $size->id_product_color = $request->colorid;
                    $size->quantity_storage = $request->quantity;
                    if($size->save()) return 'ok';
                    else ['error'=> 'Có lỗi xuất hiện'];
                }
            }
            else return ['error'=> 'Không được để trống'];
        })->name('newSize');

        Route::post('/get-report', 'AdminController@getReport');

        Route::any('/voucher', 'AdminController@voucher')->name('voucher');

        Route::any('/product', 'AdminController@product')->name('product');

        Route::any('/edit-product/{id}', 'AdminController@editProduct')->name('editProduct');

        Route::any('/create-product', 'AdminController@createProduct')->name('createProduct');

        Route::any('/order-detail/{id}', 'AdminController@orderDetail')->name('orderDetail');
    }
);


// post route
Route::post('/add-to-cart', "CartController@create")->name('addCart');

Route::post('/update-cart', "CartController@update")->name('updateCart');

Route::post('/voucher', "VoucherController@index")->name('voucher');

Route::post('/get-district', "AddressController@district")->name('district');

Route::post('/get-commune', "AddressController@commune")->name('commune');

Route::post('/checkout', "OrderController@create")->name('checkout');

Route::post('/get-size-by-color', function (Request $request) {
    $groupID = GroupProduct::where("group_code", $request->groupID)->get()->first()->id;
    $productByColor = ProductByColor::where([
                                            ["color", "like", $request->color],
                                            ["id_group_product", "=", $groupID]
                                        ])->get()->first()->id;
    $data = Product::where([
                                ["id_product_color", "=", $productByColor],
                                ["quantity_storage", ">", 0]
                            ])->select("id", "Size as text")->get();
    return $data;
})->name("getSizeByColor");

Route::post('/get-detail', function (Request $request) {
    $product = GroupProduct::select("id", "group_name as name", "group_code as code", "price as price", "description as description", "sale_off as sale")
                                ->where("group_code", $request->id)->get()->first();
    $color = [];
    $image = [];
    $size = [];
    $id_product = $product->productByColor()->get()->first()->product()->get()->first()->id;
    foreach($product->productByColor()->get() as $item){
        array_push($color, ["id" => $item->id, "text" => $item->color]);
        foreach($item->productImage()->get() as $images){
            array_push($image, $images->path);
        }
    }
    foreach($product->productByColor()->get()->first()->product()->get() as $sizes){
        array_push($size, ["id" => $sizes->id, "text" => $sizes->size]);
    }
    return [$product, $color, $image, $size, $id_product];
});

Route::get('redirect/{driver}', 'SocialController@redirectToProvider')
    ->name('login.provider');
Route::get('/callback/{provider}', 'SocialController@callback');

Route::post('change-user-info', function (Request $request) {
    $user = Auth::user()->Customer()->get()->first();
    $user->CustomerName = $request->name;
    $user->Gender = $request->gender;
    $user->Address = $request->address;
    $user->Phone = $request->phone;
    $user->save();
    return redirect($request->session()->all()['_previous']['url']);
})->name('changeUserInfo');

Route::post('/change-password', function (Request $request) {
    $user = Auth::user();
    if(Hash::check($request->oldPassword, $user->password)){
        $user->password = Hash::make($request->newPassword);
        $user->save();
        return 'ok';
    }

    else return ['error' => 'old password is not match'];
});

Auth::routes();
