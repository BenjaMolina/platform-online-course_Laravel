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

    Route::group(['middleware' => ['auth']], function () {
        Route::get('/subscribed', 'CourseController@subscribed')->name('courses.subscribed');
        Route::get('/{course}/inscribe', 'CourseController@inscribe')->name('courses.inscribe');
        Route::post('/add_review', 'CourseController@addReview')->name('courses.add_review');

        Route::get('/create', 'CourseController@create')->name('courses.create')
            ->middleware([sprintf("role:%s", \App\Role::TEACHER)]);
        Route::post('/store', 'CourseController@store')->name('courses.store')
            ->middleware([sprintf("role:%s", \App\Role::TEACHER)]);
    });

    Route::get('/{course}', 'CourseController@show')->name('courses.detail');
});

Route::group(['middleware' => ['auth']], function () {
    Route::group(['prefix' => 'subscriptions'], function () {
        Route::get('/plans', 'SubscriptionController@plans')->name('subscriptions.plans');
        Route::get('/admin', 'SubscriptionController@admin')->name('subscriptions.admin');

        Route::post('/process_subscription', 'SubscriptionController@proccessSubscription')->name('subscriptions.process_subscription');

        Route::post('/resume', 'SubscriptionController@resume')->name('subscriptions.resume');
        Route::post('/cancel', 'SubscriptionController@cancel')->name('subscriptions.cancel');
    });


    Route::group(['prefix' => 'invoices'], function () {
        Route::get('/admin', 'InvoiceController@admin')->name('invoices.admin');
        Route::get('/{invoice}/download', 'InvoiceController@download')->name('invoices.download');
    });
});


Route::group(['prefix' => 'profile', "middleware" => ['auth']], function () {
    Route::get('/', 'ProfileController@index')->name('profile.index');
    Route::put('/', 'ProfileController@update')->name('profile.update');
});

Route::group(['prefix' => 'solicitude', "middleware" => ['auth']], function () {
    Route::post('/teacher', 'SolicitudeController@teacher')->name('solicitude.teacher');
});


Route::group(['prefix' => 'teacher', "middleware" => ['auth']], function () {
    Route::get('/courses', 'TeacherController@courses')->name('teacher.courses');
    Route::get('/students', 'TeacherController@students')->name('teacher.students');

    Route::post('/send_message_to_student', 'TeacherController@sendMessageToStudent')->name('teacher.send_message_to_student');
});




/*Ruta para retornar la imagen desde el Storage */
Route::get('/images/{path}/{attachment}', function ($path, $attachment) {
    $file = sprintf('storage/%s/%s', $path, $attachment);


    if (File::exists($file)) {
        return \Intervention\Image\Facades\Image::make($file)->response();
    }
});
