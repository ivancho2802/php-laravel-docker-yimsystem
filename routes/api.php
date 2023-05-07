<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\InventarioController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::post('login', [AuthController::class, 'login']);

Route::post('register', [AuthController::class, 'register']);

Route::post('logout', [AuthController::class, 'logout']);

Route::prefix('user')->group(function () {
    //, 'role:Appark|SysAdmin'
    Route::middleware(['auth:sanctum'])->group(function () {
        Route::delete('/', [UserController::class, 'remove']);
        Route::put('/', [UserController::class, 'update']);
        Route::get('/', [UserController::class, 'show']);
    });
});

/* Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
}); */

    /* $request->validate([
        'email' => 'required|email',
    ]);
    
    $user = User::where('email', $request->email)->first();
 
    if (! $user || ! Hash::check($request->password, $user->password)) {
        throw ValidationException::withMessages([
            'email' => ['The provided credentials are incorrect.'],
        ]);
    }

    // Revoke all tokens...
    $user->tokens()->delete();
    
    // Revoke a specific token...
    $user->tokens()->where('id', $tokenId)->delete();
 
    return $user; */


    
Route::group(['middleware' => 'auth'], function () {
	
	//productos
	Route::post('/api/productos', [InventarioController::class, 'search']);
	//end productos
});