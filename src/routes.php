<?php
Route::get('demo', function () {
    return \Egideailhami::method1("ua");
});

Route::get('view', function () {
    return view('egideailhami.menu::index');
});
