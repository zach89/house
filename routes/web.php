<?php
 use Webpatser\Uuid\Uuid;
 use App\Events\MessagePosted;
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
    return view('app');
});

Route::group(['prefix' => 'api/'],function() {
    Route::resource('customer','CustomerController');
    Route::resource('invoice','InvoiceController');
});
Route::get('/chat', function () {
    return view('chat');
})->middleware('auth');
Route::group(['middleware' => ['web','auth']],function(){
    Route::resource('house','HouseController');
    Route::post('house/create','HouseController@create');
    Route::get('house/read','HouseController@show');
    Route::post('house/update','HouseController@update');
    Route::post('house/delete','HouseController@delete');
});
Route::get('/message',function() {
	return App\Message::with('user')->get();
})->middleware('auth');
Route::get('/mail',function() {
	// Mail::raw('这里填写邮件的内容',function ($message){
 //         // 发件人（你自己的邮箱和名称）
 //        $message->from('zach88@126.com', 'zach');
 //        // 收件人的邮箱地址
 //        $message->to('123113118@qq.com');
 //        // 邮件主题
 //        $message->subject('测试');
 //        echo '操作成功';
 //    });
    // Mail::send('mail.mail',['name'=>'古杰海测试'],function($message){
    // 	$message->from('zach88@126.com', 'zach');
    // 	$message->to('123113118@qq.com');
    // 	$message->subject('测试');
    // });
    // $user = Redis::get('user:profile:'.id);
    // echo $user;
    echo Uuid::generate();
});
Route::post('/message',function() {
	$user = Auth::user();

	$message = $user->messages()->create([
		'message' => request()->get('message')
	]);
    // event(new MessagePosted($message,$user));
    broadcast(new MessagePosted($message,$user))->toOthers();
	return ['status' => 'OK'];
})->middleware('auth');

Auth::routes();

Route::get('/home', 'HomeController@index');
