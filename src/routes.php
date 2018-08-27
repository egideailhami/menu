<?php
\Auth::routes();
Route::post('/login-app', 'Egideailhami\Menu\Controllers\LoginController@login')->name('loginGrit');

Route::get('/grit/addmodal/{name}','Egideailhami\Menu\Controllers\ModalController@addmodal');
Route::get('/grit/editmodal/{name}/{id}','Egideailhami\Menu\Controllers\ModalController@editmodal');

// Route::get(env('menu_url'), function () {
//     return view(str_replace('/','.',env('menu_path')).'.menu');
// });


Route::group(['prefix'=>env('menu_url').'/api'], function () {
    Route::match(['get', 'post', 'delete', 'put'], '/menu/{id?}', 'Egideailhami\Menu\Controllers\FormController@menu')->name('routeMenu');
    Route::get('/appname', 'Egideailhami\Menu\Controllers\FormController@getAppName')->name('routeAppName');
    Route::get('/previewMenu', 'Egideailhami\Menu\Controllers\FormController@getPreview')->name('routePreviewMenu');
    Route::group(['prefix'=>'table'], function () {
        Route::get('/menu/{app?}', 'Egideailhami\Menu\Controllers\TableController@tableMenu')->name('tableMenu');
    });
});