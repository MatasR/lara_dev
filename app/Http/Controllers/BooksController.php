<?php

namespace App\Http\Controllers;

use App\Book;
use App\Author;
use App\Http\Requests\BookStoreRequest;
use Illuminate\Support\Facades\Storage;

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
        $inputs = $request->all();

        $image = $request->new_image->hashName();

        $inputs['image'] = $image;
        
        Book::create($inputs);

        $request->new_image->store('public/images/books');
        
        return redirect()->back()->with('success', 'Inserted successfully!');
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
        $book->name = $request->input('name');
        $book->author_id = $request->input('author_id');

        if($request->hasFile('new_image')){
            Storage::delete('public/images/books/'.$book->image);
            $image = $request->new_image->hashName();
            $book->image = $image;
            $request->new_image->store('public/images/books');
        }

        $book->save();
        return redirect(route('books.index'))->with('success', 'Updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(BookStoreRequest $request, $id)
    {
        if($id == 'many'){
            $id = $request->input('id');
            foreach($id as $i){
                $book = Book::find($i);
                Storage::delete('public/images/books/'.$book->image);
            }
        }

        Book::destroy($id);
        
        return redirect()->back()->with('success', 'Deleted successfully!');
    }
}