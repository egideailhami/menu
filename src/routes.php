<?php
\Auth::routes();

Route::get('/grit/addmodal/{name}','Egideailhami\Menu\Controllers\ModalController@addmodal');
Route::get('/grit/editmodal/{name}/{id}','Egideailhami\Menu\Controllers\ModalController@editmodal');


Route::group(['prefix'=>env('menu_url').'/api'], function () {
    Route::match(['get', 'post', 'delete', 'put'], '/menu/{id?}', 'Egideailhami\Menu\Controllers\FormController@menu')->name('routeMenu');
    Route::match(['get', 'post', 'delete', 'put'], '/role-permission/{id?}', 'Egideailhami\Menu\Controllers\FormController@rolePermission')->name('routeRP');
    Route::get('/appname', 'Egideailhami\Menu\Controllers\FormController@getAppName')->name('routeAppName');
    Route::get('/previewMenu', 'Egideailhami\Menu\Controllers\FormController@getPreview')->name('routePreviewMenu');
    Route::group(['prefix'=>'table'], function () {
        Route::get('/menu/{app?}', 'Egideailhami\Menu\Controllers\TableController@tableMenu')->name('tableMenu');
        Route::get('/role', 'Egideailhami\Menu\Controllers\TableController@tableRole')->name('tableRole');
        Route::get('/permission', 'Egideailhami\Menu\Controllers\TableController@tablePermission')->name('tablePermission');
        Route::get('/user', 'Egideailhami\Menu\Controllers\TableController@tableUser')->name('tableUser');
    });
});