<?php
use App\Category;
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
Auth::routes();
Route::get('/', 'WelcomeController@index');
Route::get('/product/detail/', 'ProductDetailController@detail')->name('product_detail');
Route::match(["GET", "POST"], "/register", function(){
    return redirect("/login");
})->name("register");

Route::get('/admin', function () {
    $categories = \App\Category::get();
    return view('auth.login',['categories'=>$categories]);
    });

//Sales Route
Route::group(['middleware' => ['auth','checkRole:SALES']],function(){
    Route::get('/main_home', 'MainHomeSalesController@index')->name('main_home');
    Route::get('/logout', '\App\Http\Controllers\Auth\LoginController@logout')->name('log-out');

    Route::group(['prefix' => '/{vendor}'], function()
    {
        Route::get('/sales-home/{cat?}', 'SalesHomeController@index')->name('home_customer');
        Route::post('/session/store','SessionStore@index')->name('session.store');
        Route::get('/session/clear','SessionStore@clear')->name('session.clear');
        Route::post('/keranjang/pesan','CustomerKeranjangController@pesan')->name('customer.keranjang.pesan');
        Route::get('/produk-paket', 'SalesHomeController@index')->name('home_paket');
        Route::get('/contact', 'ContactController@index')->name('contact');
        Route::get('/profil', 'ProfilController@index')->name('profil.index');
        Route::put('/profil/{id}/update', 'ProfilController@update')->name('profil.update');
        Route::get('/pesanan/{status?}','TransaksiSalesController@index')->name('pesanan');
        Route::post('/pesanan/cancel','TransaksiSalesController@change_status')->name('cancel_status');
    });

    Route::get('/success/send/order','SessionStore@OrderSuccess');
    Route::post('/ajax/city', 'AjaxCitySearch@ajax_city');
    Route::post('/ajax/store', 'AjaxCitySearch@ajax_store');
    Route::post('/sales/order_search','AjaxDetailPesananSales@search_order');
    Route::post('/pesanan/detail','AjaxDetailPesananSales@detail');
    Route::get('/home_cart', 'CustomerKeranjangController@ajax_cart');

    Route::group(['prefix' => '/keranjang'], function()
    {
        //Route::post('/apply_code', 'CustomerKeranjangController@apply_code');
        //Route::post('/search_vcode','CustomerKeranjangController@voucher_code')->name('customer.keranjang.vcode');
        Route::post('/simpan','CustomerKeranjangController@simpan')->name('customer.keranjang.simpan');
        Route::post('/cek_order','CustomerKeranjangController@cek_order');
        Route::post('/preview_order','CustomerKeranjangController@preview_order');
        Route::post('/delete_allcart','CustomerKeranjangController@delete_allcart');
        Route::post('/kurang','CustomerKeranjangController@kurang')->name('customer.keranjang.kurang');
        Route::post('/tambah','CustomerKeranjangController@tambah')->name('customer.keranjang.tambah');
        Route::post('/delete','CustomerKeranjangController@delete')->name('customer.keranjang.delete');
        //paket
        Route::post('/paket/cek_max_qty','CustomerPaketController@cek_max_qty');
        Route::post('/paket/simpan','CustomerPaketController@simpan')->name('customer.paket.simpan');
        Route::post('/paket/totalquantity','CustomerPaketController@get_total_qty');
        Route::post('/paket_all/simpan_cart','CustomerPaketController@simpan_all_tocart');
        Route::post('/paket_all/delete_tmp','CustomerPaketController@delete_tmp');
        Route::post('/paket/delete_pkt','CustomerPaketController@delete_paket');
        Route::post('/cek_detail/paket','CustomerPaketController@cek_detail_pkt');
        Route::post('/delete_kr/paket','CustomerPaketController@delete_kr_pkt');
        Route::post('/paket/product_search','CustomerPaketController@search_paket')->name('live.search.paket');
        //bonus
        Route::post('/bonus/simpan','CustomerPaketController@simpan_bonus');
        Route::post('/bonus/totalquantity','CustomerPaketController@get_total_qty_bns');
        Route::post('/bonus/delete_bns','CustomerPaketController@delete_bonus');
        Route::post('/bonus/product_search','CustomerPaketController@search_bonus');

        Route::post('/min_order','CustomerKeranjangController@min_order')->name('customer.keranjang.min_order');
    });

    //profil sales
    //Route::resource('profil','ProfilController');
    Route::resource('profil', 'ProfilController')->except([
        'index',
        'create',
        'store',
        'update',
        'edit',
        'destroy',
    ]);
    Route::get('/updated-activity', 'TelegramBotController@updatedActivity')->name('update.telegram');
    //Route::get('/histori','historiController@index')->name('riwayat_pemesanan');
    //Route::resource('category','filterProductController');
    //Route::resource('search','searchController');
    //Route::get('/sales_home/paket_group', 'CustomerPaketController@index')->name('home_paket');
    //Route::post('/session/new/store','SessionStore@new_store')->name('session.new_store');
});

//Admin Route
Route::get('/home', 'HomeController@index')->name('home');

Route::group(['prefix' => '/{vendor}'], function()  
{  
    //home
    Route::get('/home_admin', 'DashboardController@home_admin')->name('home_admin');

    //Client profil
    //Route::get('/shop-profile', 'ProfilClientController@index')->name('profile_client.index');
    Route::put('/shop-update-profile/{id}', 'DashboardController@update')->name('profile.client.update');
    
    //Owner
    Route::get('/client-list', 'ClientListController@index')->name('client_so.index');
    Route::get('/client-list/create', 'ClientListController@create')->name('client_so.create');
    Route::post('/client-list/store', 'ClientListController@store')->name('client_so.store');
    Route::post('/client-list/update', 'ClientListController@update_client')->name('client_so.update');
    
    //admin
    Route::get('/users', 'UserController@index')->name('users.index');
    Route::get('/users/create', 'UserController@create')->name('users.create');
    Route::post('/users/store', 'UserController@store')->name('users.store');
    Route::get('/users/{id}/update', 'UserController@update')->name('users.update');
    Route::get('/users/{id}/edit', 'UserController@edit')->name('users.edit');
    Route::get('/users/{id}/destroy', 'UserController@destroy')->name('users.destroy');
    
    //sales
    Route::get('/sales', 'SalesController@index')->name('sales.index');
    Route::get('/sales/create', 'SalesController@create')->name('sales.create');
    Route::post('/sales/store', 'SalesController@store')->name('sales.store');
    Route::get('/sales/{id}/edit', 'SalesController@edit')->name('sales.edit');
    Route::get('/sales/{id}/update', 'SalesController@update')->name('sales.update');
    Route::get('/sales/{id}/destroy', 'SalesController@destroy')->name('sales.destroy');
    Route::get('/sales/export', 'SalesController@export')->name('sales.export');

    //spv
    Route::get('/spv', 'SpvController@index')->name('spv.index');
    Route::get('/spv/create', 'SpvController@create')->name('spv.create');
    Route::post('/spv/store', 'SpvController@store')->name('spv.store');
    Route::get('/spv/{id}/edit', 'SpvController@edit')->name('spv.edit');
    Route::get('/spv/{id}/update', 'SpvController@update')->name('spv.update');
    Route::get('/spv/{id}/destroy', 'SpvController@destroy')->name('spv.destroy');

    //Banner
    Route::get('/banner', 'BannerController@index')->name('banner.index');
    Route::get('/banner/create', 'BannerController@create')->name('banner.create');
    Route::post('/banner/store', 'BannerController@store')->name('banner.store');
    Route::get('/banner/{id}/edit', 'BannerController@edit')->name('banner.edit');
    Route::get('/banner/{id}/update', 'BannerController@update')->name('banner.update');
    Route::get('/banner/{id}/destroy', 'BannerController@destroy')->name('banner.destroy');
    Route::get('/banner/trash', 'BannerController@trash')->name('banner.trash');
    Route::get('/banner/{id}/restore', 'BannerController@restore')->name('banner.restore');
    Route::delete('/banner/{id}/delete-permanent','BannerController@deletePermanent')->name('banner.delete-permanent');

    //Categories
    Route::get('/categories', 'CategoryController@index')->name('categories.index');
    Route::get('/categories/create', 'CategoryController@create')->name('categories.create');
    Route::post('/categories/store', 'CategoryController@store')->name('categories.store');
    Route::get('/categories/{id}/update', 'CategoryController@update')->name('categories.update');
    Route::get('/categoriess/{id}/edit', 'CategoryController@edit')->name('categories.edit');
    Route::delete('/categories/{id}/destroy', 'CategoryController@destroy')->name('categories.destroy');
    Route::get('/categories/export', 'CategoryController@export')->name('categories.export');
    Route::get('/categories/trash', 'CategoryController@trash')->name('categories.trash');
    Route::get('/categories/{id}/restore', 'CategoryController@restore')->name('categories.restore');
    Route::delete('/categories/{category}/delete-permanent','CategoryController@deletePermanent')->name('categories.delete-permanent');

    //Products
    Route::get('/products', 'productController@index')->name('products.index');
    Route::get('/products/create', 'productController@create')->name('products.create');
    Route::post('/products/store', 'productController@store')->name('products.store');
    Route::get('/products/{id}/edit', 'productController@edit')->name('products.edit');
    Route::delete('/products/{id}/destroy', 'productController@destroy')->name('products.destroy');
    Route::put('/products/{id}/update', 'productController@update')->name('products.update');
    Route::get('/products/low_stock', 'productController@low_stock')->name('products.low_stock');
    Route::get('/products/import_products', 'productController@import_product')->name('products.import_products');
    Route::post('/products/import_data', 'productController@import_data')->name('products.import_data');
    Route::get('/products/export_lowstock', 'productController@export_low_stock')->name('products.export_lowstock');
    Route::get('/products/edit_stock', 'productController@edit_stock')->name('products.edit_stock');
    Route::post('/products/update_lowstock', 'productController@update_low_stock')->name('products.update_lowstock');
    Route::get('/products/trash', 'productController@trash')->name('products.trash');
    Route::get('/products/export_all', 'productController@export_all')->name('products.export_all');
    Route::get('/products/{id}/restore', 'productController@restore')->name('products.restore');
    Route::delete('/products/{products}/delete-permanent','productController@deletePermanent')->name('products.delete-permanent');

    //Group-paket
    Route::get('/groups', 'GroupController@index')->name('groups.index');
    Route::get('/groups/create', 'GroupController@create')->name('groups.create');
    Route::post('/groups/store', 'GroupController@store')->name('groups.store');
    Route::put('/groups/{id}/update', 'GroupController@update')->name('groups.update');
    Route::get('/groups/{id}/edit', 'GroupController@edit')->name('groups.edit');
    Route::delete('/groups/{id}/destroy', 'GroupController@destroy')->name('groups.destroy');
    Route::post('/groups/edit_status', 'GroupController@update_status')->name('groups.edit_status');

    //Paket
    Route::get('/paket', 'PaketController@index')->name('paket.index');
    Route::get('/paket/create', 'PaketController@create')->name('paket.create');
    Route::post('/paket/store', 'PaketController@store')->name('paket.store');
    Route::put('/paket/{id}/update', 'PaketController@update')->name('paket.update');
    Route::get('/paket/{id}/edit', 'PaketController@edit')->name('paket.edit');
    Route::delete('/paket/{id}/destroy', 'PaketController@destroy')->name('paket.destroy');
    Route::post('/paket/edit_status', 'PaketController@update_status')->name('paket.edit_status');

    //Customers
    Route::get('/customers', 'CustomerController@index')->name('customers.index');
    Route::get('/customers/create', 'CustomerController@create')->name('customers.create');
    Route::post('/customers/store', 'CustomerController@store')->name('customers.store');
    Route::put('/customers/{id}/update', 'CustomerController@update')->name('customers.update');
    Route::get('/customers/{id}/edit', 'CustomerController@edit')->name('customers.edit');
    Route::delete('/customers/{id}/destroy', 'CustomerController@destroy')->name('customers.destroy');
    Route::get('/customers/{id}/detail', 'CustomerController@detail')->name('customers.detail');
    Route::get('/customers/export_city', 'CustomerController@exportCity')->name('cities.export');
    Route::get('/customers/export', 'CustomerController@export')->name('customers.export');
    Route::get('/customers/import', 'CustomerController@import')->name('customers.import');
    Route::post('/customers/import_data', 'CustomerController@import_data')->name('customers.import_data');
    Route::delete('/customers/{customers}/delete-permanent','CustomerController@deletePermanent')->name('customers.delete-permanent');
    Route::get('/customers/customers-type', 'CustomerController@index_type')->name('type_customers.index_type');
    Route::get('/customers/export-customers-type', 'CustomerController@export_type')->name('type_customers.export');
    Route::get('/customers/create-customers-type', 'CustomerController@create_type')->name('type_customers.create');
    Route::get('/customers/{id}/edit-customers-type', 'CustomerController@edit_type')->name('type_customers.edit');
    Route::post('/customers/store-customers-type', 'CustomerController@store_type')->name('type_customers.store');
    Route::put('/customers/{id}/update-customer-type', 'CustomerController@update_type')->name('type_customers.update');
    Route::delete('/customers/{customers}/type-delete-permanent','CustomerController@deletePermanent_type')->name('type_customers.delete-permanent');

    //Order
    Route::get('/orders', 'OrderController@index')->name('orders.index');
    Route::put('/orders/{id}/update', 'OrderController@update')->name('orders.update');
    Route::get('/orders/{id}/edit', 'OrderController@edit')->name('orders.edit');
    Route::get('/orders/{id}/detail', 'OrderController@detail')->name('orders.detail');
    Route::get('/orders/export_mapping', 'OrderController@export_mapping')->name('orders.export_mapping') ;
    Route::get('/orders/add-new-customer/{id}/{payment}', 'OrderController@new_customer')->name('orders.addnew_customer') ;
    Route::put('/orders/new-customer/{id}/update', 'OrderController@save_new_customer')->name('orders.newcustomer.update');

    //Change Password
    Route::get('/users/change_password', 'changePasswordController@index')->name('changepass');
    Route::post('/users/post/change_password', 'changePasswordController@changepassword')->name('post.changepass');

});

//Ajax controller in admin panel
Route::get('/ajax/users_email/search', 'AjaxAdminSearch@email_search');
Route::get('/ajax/cities/search', 'AjaxAdminSearch@CitySearch');
Route::post('/ajax/post-sortable','AjaxAdminSearch@post_sortable');
Route::get('/ajax/products/code/search', 'AjaxAdminSearch@CodeProductSearch');
Route::get('/ajax/categories/search', 'AjaxAdminSearch@CategorySearch');
Route::get('/products/change_status_stock', 'AjaxAdminSearch@OnOff_stock');
Route::get('/ajax/groups/search', 'AjaxAdminSearch@GroupNameSearch');
Route::get('/ajax/paket/search', 'AjaxAdminSearch@PaketNameSearch');
Route::get('/ajax/users/search', 'AjaxAdminSearch@CustomerajaxUserSearch');
Route::get('/customer/ajax/city_search', 'AjaxAdminSearch@CustomerajaxCitySearch');
Route::get('/ajax/code_cust/search', 'AjaxAdminSearch@CustomerCodeSearch');
Route::get('/ajax/name_client_so/search', 'AjaxAdminSearch@ClientsoCodeSearch');
Route::get('/ajax/email_client_so/search', 'AjaxAdminSearch@email_so_search');
Route::get('/ajax/type_customers/search', 'AjaxAdminSearch@TypeCustomerSearch');

/*===route group unique product===*/
//Route::get('/ajax/groups/search', 'GroupController@ajaxSearch');
//Route::post('/groups/add/item', 'GroupController@add_item')->name('groups.add_item');
//Route::get('/groups/{id}/{status}/edit_status', 'GroupController@update_status')->name('groups.update_status');
/*===end==========================*/

/*===route edit order===*/
//Route::get('/orders/{id}/edit_order', 'OrderEditController@edit')->name('order_edit');
//Route::post('/orders/edit_order_update', 'OrderEditController@update')->name('order_edit_update');
/*===End==========================*/

//Route::resource('/{vendor}/users','UserController');
//Admnin
Route::resource('users', 'UserController')->except([
    'index',
    'create',
    'store',
    'update',
    'edit',
    'destroy',
]);

//Route::resource('sales','SalesController');
//Sales
Route::resource('sales', 'SalesController')->except([
    'index',
    'create',
    'store',
    'edit',
    'update',
    'destroy',
]);

//Route::resource('spv','SpvController');
//Supervisor
Route::resource('spv', 'SpvController')->except([
    'index',
    'create',
    'store',
    'edit',
    'update',
    'destroy',
]);

//Route::resource('banner','BannerController');
//Banner
Route::resource('banner', 'BannerController')->except([
    'index',
    'create',
    'store',
    'edit',
    'update',
    'destroy',
]);

//Route::resource('categories','CategoryController');
//Categories
Route::resource('categories', 'CategoryController')->except([
    'index',
    'create',
    'store',
    'edit',
    'update',
    'destroy',
]);

//Route::resource('products', 'productController');
//Product
Route::resource('products', 'productController')->except([
    'index',
    'create',
    'store',
    'edit',
    'update',
    'destroy',
]);

//Route::resource('groups','GroupController');
//Group
Route::resource('groups', 'GroupController')->except([
    'index',
    'create',
    'store',
    'edit',
    'update',
    'destroy',
]);

//Route::resource('paket','PaketController');
//Paket
Route::resource('paket', 'PaketController')->except([
    'index',
    'create',
    'store',
    'edit',
    'update',
    'destroy',
]);

//Route::resource('customers','CustomerController');
//Customers
Route::resource('customers', 'CustomerController')->except([
    'index',
    'create',
    'store',
    'edit',
    'update',
    'destroy',
]);

//Route::resource('orders', 'OrderController');
//Order
Route::resource('orders', 'OrderController')->except([
    'index',
    //'create',
    //'store',
    'edit',
    'update',
    //'destroy',
]);

//Route Voucher
/*Route::get('/ajax/vouchers/search', 'VoucherController@ajaxSearch');
Route::get('/vouchers/trash', 'VoucherController@trash')->name('vouchers.trash');
Route::get('/vouchers/{id}/restore', 'voucherController@restore')->name('vouchers.restore');
Route::delete('/vouchers/{vouchers}/delete-permanent','voucherController@deletePermanent')->name('vouchers.delete-permanent');
Route::resource('vouchers','VoucherController');*/
    
    



    

