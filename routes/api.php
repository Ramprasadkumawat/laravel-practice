<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use app\Http\Controllers\HomeController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('createdb', [App\Http\Controllers\HomeController::class,'createDB']);
Route::get('getdb', [App\Http\Controllers\HomeController::class,'getDB']);

Route::group(['prefix' => 'api/v1'], function () {
    Route::get('/getTasks', function () {
    return Task::all();
    });
    Route::post('/addTask', function (Request $request) {
    $validator = Validator::make($request->all(), [
    'names' => 'required|max:255',
    ]);
    if ($validator->fails()) {
    return response()->json(['error' => $validator->messages()],
    200);
    }
    $task = new Task;
    $task->names = $request->names;
    $task->save();
    return response()->json(['response' => "Added {$request->names} to tasks."],
    200);
    });
    });
