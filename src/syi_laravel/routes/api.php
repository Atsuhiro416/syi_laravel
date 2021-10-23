<?php

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::middleware('auth:api')->group(function() {

  Route::apiResource('/users', 'UserController')->only([
    'show', 'update', 'destroy'
  ]);
  Route::post('/logout', 'AuthController@logout');

  Route::apiResource('/stacks', 'StackController');
  Route::get('/users/{user_id}/stacks', 'StackController@indexUsersStacks');
  Route::get('/users/{user_id}/stack-counts', 'StackController@getUserStackCounts');

  Route::apiResource('/folders', 'FolderController');
  Route::get('/users/{user_id}/folders', 'FolderController@indexUsersFolders');
  Route::get('/users/{user_id}/folder-counts', 'FolderController@getUserFolderCounts');
  Route::get('/folders/{folder_id}/stacks', 'FolderController@indexFoldersStacks');
  Route::post('/folders/{folder_id}/stacks/{stack_id}', 'FolderController@attachStackToFolder');
  Route::delete('/folders/{folder_id}/stacks/{stack_id}', 'FolderController@detachStackToFolder');
});


Route::post('/register', 'AuthController@register');
Route::post('/login', 'AuthController@login');
