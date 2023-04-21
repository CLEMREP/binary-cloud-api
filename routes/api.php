<?php

use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});
Route::prefix('account')->middleware('api')->group(function () {
    Route::put('/update/{user}', [UserController::class, 'update']);
    Route::put('/update/{user}/password', [UserController::class, 'updatePassword']);

    Route::post('/upload', function (Request $request) {
        var_dump($request->all());
        $image = $request->file('image');
        $imageName = time() . '_' . $image->getClientOriginalName();
        $image->storeAs('public', $imageName);

        return response()->json([
            'message' => 'Image uploaded successfully',
        ]);
    })->name('upload.image');
});

require __DIR__.'/auth.php';
