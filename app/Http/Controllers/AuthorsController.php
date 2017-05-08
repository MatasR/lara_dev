<?php

namespace App\Http\Controllers;

use App\Book;
use App\Author;
use App\Http\Requests\AuthorStoreRequest;

class AuthorsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $authors = Author::all();
        return view('authors.index', compact('authors'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AuthorStoreRequest $request)
    {
        Author::create($request->all());
        return redirect()->back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $authors = Author::all();
        $edit_author = Author::find($id);
        return view('authors.index', compact('authors', 'edit_author'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AuthorStoreRequest $request, $id)
    {
        $author = Author::find($id);
        $author->name = $request->input('name');
        $author->save();
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $author = Author::find($id);
        $author->books()->delete();
        $author->delete();
        //Author::destroy($id);
        return redirect()->back();
    }
}
