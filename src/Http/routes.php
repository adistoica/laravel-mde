<?php
if (config('editor.example')) {
    Route::get('laravel-mde/example', function () {
        return view('editor::example');
    });
}

Route::post('laravel-mde/upload/image', '\AdrianStoica\LaravelMde\Http\Controllers\EditorController@ImageUpload')->name('mde-image-upload');