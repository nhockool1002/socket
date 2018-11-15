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
use Illuminate\Support\Facades\Redis;
use Illuminate\Http\Request;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function() {

    Route::get('/posts/{post}/messages', function (\App\Post $post) {
        return $post->comments()->with('user')->get();
    });

    Route::get('/posts/{post}', function (\App\Post $post) {
        return view('post.show', compact('post'));
    });

    Route::post('/posts/{post}/messages', function(\App\Post $post, Request $request){
        $request->validate([
            'body' => 'required',
        ]);

        $comment = $post->comments()->create([
            'user_id' => auth()->id(),
            'body' => $request->get('body'),
        ]);

        $comment->load('user');

        Redis::publish('post.' . $post->id, json_encode(['event' => 'userComment', 'data' => $comment]));


        return $comment;

    });
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
