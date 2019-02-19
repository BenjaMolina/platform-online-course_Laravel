<?php




Route::get('set_language/{lang}','Controller@setLanguage')->name('set_language');

/*RUTAS PARA EL LOGIN CON SOCIALITE */
Route::get('login/{driver}', 'Auth\LoginController@redirectToProvider')->name('social_auth');
Route::get('login/{driver}/callback', 'Auth\LoginController@handleProviderCallback');
/*------------------------ */


Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


Route::group(['prefix' => 'courses'], function () {
    
    Route::get('/{course}', 'CourseController@show')->name('courses.detail');
});



/*Ruta para retornar la imagen desde el Storage */
Route::get('/images/{path}/{attachment}', function($path, $attachment){
    $file = sprintf('storage/%s/%s',$path,$attachment);
    

    if(File::exists($file)){
        return \Intervention\Image\Facades\Image::make($file)->response();
    }
});