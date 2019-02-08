<?php
\Auth::routes();

Route::get('/grit/addmodal/{name}','GritTekno\Menu\Controllers\ModalController@addmodal');
Route::get('/grit/editmodal/{name}/{id}','GritTekno\Menu\Controllers\ModalController@editmodal');


Route::group(['prefix'=>env('menu_url').'/api','middleware' => ['web','auth']], function () {
    Route::match(['get', 'post', 'delete', 'put'], '/menu/{id?}', 'GritTekno\Menu\Controllers\FormController@menu')->name('routeMenu');
    Route::match(['get', 'post', 'delete', 'put'], '/user/{id?}', 'GritTekno\Menu\Controllers\FormController@user')->name('routeUser');
    Route::match(['get', 'post', 'delete', 'put'], '/role-permission/{id?}', 'GritTekno\Menu\Controllers\FormController@rolePermission')->name('routeRP');
    Route::get('/appname', 'GritTekno\Menu\Controllers\FormController@getAppName')->name('routeAppName');
    Route::get('/namauser', 'GritTekno\Menu\Controllers\FormController@getNamaUser')->name('routeNamaUser');
    Route::get('/role-menu', 'GritTekno\Menu\Controllers\FormController@getRoleMenu')->name('route_filter_role_menu');
    Route::post('/role-menu', 'GritTekno\Menu\Controllers\FormController@postRoleMenu')->name('route_filter_role_menu');
    Route::get('/previewMenu', 'GritTekno\Menu\Controllers\FormController@getPreview')->name('routePreviewMenu');
    Route::group(['prefix'=>'table'], function () {
        Route::get('/menu/{app?}', 'GritTekno\Menu\Controllers\TableController@tableMenu')->name('tableMenu');
        Route::get('/role_menu/{filter?}', 'GritTekno\Menu\Controllers\TableController@tableRoleMenu')->name('tableRoleMenu');
        Route::get('/role', 'GritTekno\Menu\Controllers\TableController@tableRole')->name('tableRole');
        Route::get('/permission', 'GritTekno\Menu\Controllers\TableController@tablePermission')->name('tablePermission');
        Route::get('/user', 'GritTekno\Menu\Controllers\TableController@tableUser')->name('tableUser');
    });
});