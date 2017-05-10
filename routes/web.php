<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index');

Route::group(['middleware' => ['auth', 'locale']], function () {

	//Locale
	Route::get('locale/{locale}', function($locale){
		Session::put('locale', $locale);
		return redirect()->back();
	});

	//Both
	Route::get('both', 'BothController@index')->name('both');

	//Books
	Route::get('books', 'BooksController@index')->name('books.index');

	Route::post('books', 'BooksController@store')->name('books.store');

	Route::get('books/{book}/edit', 'BooksController@edit')->name('books.edit');

	Route::put('books/{book}', 'BooksController@update')->name('books.update');

	Route::delete('books/{book}', 'BooksController@destroy')->name('books.destroy');

	//Authors
	/*Route::get('authors', 'AuthorsController@index')->name('authors');

	Route::post('authors/store', 'AuthorsController@store')->name('authors.store');

	Route::post('authors/destroy', 'AuthorsController@destroy')->name('authors.destroy');

	Route::get('authors/{id}', 'AuthorsController@edit')->name('authors.edit');

	Route::post('authors/update/{id}', 'AuthorsController@update')->name('authors.update');*/
	Route::resource('authors', 'AuthorsController');

});