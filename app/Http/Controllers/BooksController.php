<?php

namespace App\Http\Controllers;

use App\Book;
use App\Author;
use App\Http\Requests\BookStoreRequest;

class BooksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $books = Book::all();
        $authors = Author::all();
        return view('books.index', compact('books', 'authors'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BookStoreRequest $request)
    {
    	Book::create($request->all());
        return redirect()->back()->with('success', 'Inserted successfuly!');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    	$books = Book::all();
    	$authors = Author::all();
        $edit_book = Book::find($id);
        return view('books.index', compact('books', 'edit_book', 'authors'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BookStoreRequest $request, $id)
    {
        $book = Book::find($id);
        $book->fill($request->all());
        $book->save();
        return redirect(route('books.index'))->with('success', 'Updated successfuly!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Book::destroy($id);
        return redirect()->back()->with('success', 'Deleted successfuly!');
    }
}