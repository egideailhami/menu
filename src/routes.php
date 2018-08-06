<?php

Route::get(env('menu_url'), function () {
    return view(str_replace('/','.',env('menu_path')).'.menu');
});
