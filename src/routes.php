<?php
\Auth::routes();

Route::get('grit/modalmenu/{name}/{type}/{id?}','Egideailhami\Menu\Controllers\ModalController@modal')->name('modalMenu');

Route::get(env('menu_url'), function () {
    return view(str_replace('/','.',env('menu_path')).'.menu');
});
Route::group(['prefix'=>'api/table'], function () {
    Route::get('/menu', 'Egideailhami\Menu\Controllers\TableController@tableMenu')->name('tableMenu');
});