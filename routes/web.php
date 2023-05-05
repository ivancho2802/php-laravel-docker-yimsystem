<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SessionsController;
use App\Http\Controllers\InfoUserController;
use App\Http\Controllers\ResetController;
use App\Http\Controllers\ChangePasswordController;
use App\Http\Controllers\BookShoppingController;
use App\Http\Controllers\BookSalesController;
use App\Http\Controllers\ProviderController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\RetencionesController;
use App\Http\Controllers\ComprasController;
use App\Http\Controllers\InventarioController;


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

/* Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('admin')->middleware(['auth'])->namespace('App\Attp\controller\Admin')->group(function (){

    Route::resource('organizaciones', OrganizacionesControler::class);

    Route::get('logs', [\Rap2hpoutre\LaravelLogViewer\LogViewerController::class, 'index']);

}); 


Auth::routes();
*/

//

Route::group(['middleware' => 'auth'], function () {

    Route::get('/', function () {
        return redirect('dashboard');
    });
	Route::get('dashboard', function () {
		return view('dashboard');
	})->name('dashboard');

	Route::get('billing', function () {
		return view('billing');
	})->name('billing');

	Route::get('profile', function () {
		return view('profile');
	})->name('profile');

	Route::get('rtl', function () {
		return view('rtl');
	})->name('rtl');

	Route::get('user-management', function () {
		return view('laravel-examples/user-management');
	})->name('user-management');
    
	Route::get('fixed-plugin', function () {
		return view('laravel-examples/fixed-plugin');
	})->name('fixed-plugin');

	Route::get('tables', function () {
		return view('tables');
	})->name('tables');

    Route::get('virtual-reality', function () {
		return view('virtual-reality');
	})->name('virtual-reality');

    Route::get('static-sign-in', function () {
		return view('static-sign-in');
	})->name('sign-in');

    Route::get('static-sign-up', function () {
		return view('static-sign-up');
	})->name('sign-up');

	//libros de compras
	Route::get('book-shopping', [BookShoppingController::class, 'index']);

	Route::post('book-shopping', [BookShoppingController::class, 'search'])
	->name('book-shopping.search');

	Route::delete('book-shopping/{id}', [BookShoppingController::class, 'destroy'])
	->name('book-shopping.destroy');

	Route::get('book-shopping-add', [BookShoppingController::class, 'create']);
	Route::post('book-shopping-add', [BookShoppingController::class, 'store']);

	Route::get('book-shopping-edit/{factCompra}', [BookShoppingController::class, 'edit'])
	->name('book-shopping.edit');
	Route::put('book-shopping-edit/{factCompra}', [BookShoppingController::class, 'update']);
	
	Route::get('book-shopping-print', [BookShoppingController::class, 'indexPrint']);

	Route::post('book-shopping-print', [BookShoppingController::class, 'print'])
		->name('book-shopping-print.print');

	Route::get('book-shopping-detail/{factCompra}', [RetencionesController::class, 'indexDetail'])
	->name('book-shopping.detail');

	//retencion
	Route::post('book-shopping-print-report', [BookShoppingController::class, 'report'])
	->name('book-shopping-print.report');

	Route::get('book-shopping-reten-add', [RetencionesController::class, 'retenadd']);

	Route::get('book-shopping-reten-gen', [RetencionesController::class, 'generate']);

	Route::put('book-shopping-reten', [RetencionesController::class, 'update']);

	//end retencion

	//compras de una fact
	Route::post('compras/{id}', [ComprasController::class, 'search'])
	->name('compras.search');
	//compras de una fact

	//end libros de compras

	//libros de ventas
	Route::get('book-sales', [BookSalesController::class, 'index'])
	->name('book-sales.list');

	Route::post('book-sales', [BookSalesController::class, 'search'])
	->name('book-sales.search');

	Route::get('book-sales/{numero}/{control}', [BookSalesController::class, 'valid']);

	Route::post('book-sales-print-report', [BookSalesController::class, 'report'])
	->name('book-sales-print.report');

	Route::post('book-fact-sales-print-report', [BookSalesController::class, 'reportFact'])
	->name('book-fact-sales-print.report');

	Route::get('book-sales-add', [BookSalesController::class, 'create']);
	Route::post('book-sales-add', [BookSalesController::class, 'store']);

	Route::get('book-sales-detail/{id_fact_venta}', [BookSalesController::class, 'indexDetail'])
	->name('book-sales.detail');

	Route::get('book-sales', [BookSalesController::class, 'index']);

	//end libros de ventas

	//proveedores
	Route::post('providers', [ProviderController::class, 'search'])
	->name('providers.search');
	
	Route::post('provider', [ProviderController::class, 'store']);
	
	Route::put('provider/{id}', [ProviderController::class, 'update']);

	//end proveedores

	//vendedores
	Route::post('clientes', [ClientController::class, 'search'])
	->name('clientes.search');
	
	Route::put('cliente/{id}', [ClientController::class, 'update']);
	Route::post('cliente', [ClientController::class, 'store']);
	
	Route::get('clienteVzla/{numero}', [ClientController::class, 'findUserByVzla']);
	//end vendedores
	
	//productos
	Route::post('productos', [InventarioController::class, 'search']);
	Route::get('checkdateii/{id}', [InventarioController::class, 'validDate']);
	//end productos

	//inventario-add
	Route::get('inventario-add', [InventarioController::class, 'create']);

	Route::post('inventario-add', [InventarioController::class, 'store']);

	Route::put('inventario/{id}', [InventarioController::class, 'update']);

	//retiro del inventario
	Route::post('inventario-withdraw', [InventarioController::class, 'storeRetiro']);

	Route::get('inventario-list', [InventarioController::class, 'index']);

	Route::get('inventario-config', [InventarioController::class, 'config']);
	
	Route::post('inventario-report', [InventarioController::class, 'reportInventario'])
	->name('inventario.report');

	//inventario-end
	

    Route::get('/logout', [SessionsController::class, 'destroy']);
	Route::get('/user-profile', [InfoUserController::class, 'create']);
	Route::post('/user-profile', [InfoUserController::class, 'store']);
    Route::get('/login', function () {
		return view('dashboard');
	})->name('sign-up');
});

Route::group(['middleware' => 'guest'], function () {
    Route::get('/register', [RegisterController::class, 'create']);
    Route::post('/register', [RegisterController::class, 'store']);
    Route::get('/login', [SessionsController::class, 'create']);
    Route::post('/session', [SessionsController::class, 'store']);
	Route::get('/login/forgot-password', [ResetController::class, 'create']);
	Route::post('/forgot-password', [ResetController::class, 'sendEmail']);
	Route::get('/reset-password/{token}', [ResetController::class, 'resetPass'])->name('password.reset');
	Route::post('/reset-password', [ChangePasswordController::class, 'changePassword'])->name('password.update');

});

Route::get('/login', function () {
    return view('session/login-session');
})->name('login');