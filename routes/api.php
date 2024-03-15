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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('/user')->group(function () {
    Route::get('/', function () {
        global $users;
        echo json_encode($users, JSON_PRETTY_PRINT);
    });

    Route::get('/{userIndex}', function ($userIndex) {
        global $users;
        if (isset($users[$userIndex])) {
            echo json_encode($users[$userIndex]);
        } else {
            echo 'Cannot find the user with index ' . $userIndex;
        }
    })->where('userIndex', '[0-9]+');

    Route::get('/{userName}', function ($userName) {
        global $users;
        foreach ($users as $user) {
            if ($user['name'] === $userName) {
                return json_encode($user);
            }
        }
        return 'Cannot find the user with name ' . $userName;
    })->where('userName', '[A-Za-z]+');;

    Route::get('/{userIndex}/post/{postIndex}', function ($userIndex, $postIndex) {
        global $users;
        if ($users[$userIndex]) {
            $user = $users[$userIndex]['posts'];
            if ($user[$postIndex]) {
                return $user[$postIndex];
            }
        }
        return 'Cannot find the post with id ' . $userIndex . ' for user ' . $postIndex;
    })->where('userIndex', '[0-9]+', 'postIndex', '[0-9]+');
    // $users[1]['posts'][1];
});
