<?php




Route::get('set_language/{lang}', 'Controller@setLanguage')->name('set_language');

/*RUTAS PARA EL LOGIN CON SOCIALITE */
Route::get('login/{driver}', 'Auth\LoginController@redirectToProvider')->name('social_auth');
Route::get('login/{driver}/callback', 'Auth\LoginController@handleProviderCallback');
/*------------------------ */


Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');


Route::group(['prefix' => 'courses'], function () {

    Route::get('/{course}', 'CourseController@show')->name('courses.detail');
});

Route::group(['prefix' => 'subscriptions'], function () {
    Route::get('/plans', 'SubscriptionController@plans')->name('subscriptions.plans');
    Route::post('/process_subscription', 'SubscriptionController@proccessSubscription')->name('subscriptions.process_subscription');
});



/*Ruta para retornar la imagen desde el Storage */
Route::get('/images/{path}/{attachment}', function ($path, $attachment) {
    $file = sprintf('storage/%s/%s', $path, $attachment);


    if (File::exists($file)) {
        return \Intervention\Image\Facades\Image::make($file)->response();
    }
});