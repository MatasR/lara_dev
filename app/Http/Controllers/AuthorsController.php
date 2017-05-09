<?php

namespace App\Http\Controllers;

use App\Book;
use App\Author;
use App\Http\Requests\AuthorStoreRequest;
use Illuminate\Support\Facades\Storage;

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
        $inputs = $request->all();

        $image = $request->new_image->hashName();

        $inputs['image'] = $image;
        
        Author::create($inputs);

        $request->new_image->store('public/images/authors');
        
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

        if($request->hasFile('new_image')){
            Storage::delete('public/images/authors/'.$author->image);
            $image = $request->new_image->hashName();
            $author->image = $image;
            $request->new_image->store('public/images/authors');
        }

        $author->save();
        return redirect(route('authors.index'))->with('success', 'Updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(AuthorStoreRequest $request, $id)
    {
        if($id == 'many'){
            $id = $request->input('id');

            //Delete all books which were wrote by author
            //then delete author
            foreach($id as $i){
                $author = Author::find($i);
                foreach($author->books as $book)
                    Storage::delete('public/images/books/'.$book->image);
                $author->books()->delete();
                Storage::delete('public/images/authors/'.$author->image);
                $author->delete();
            }

        }else{
            //Delete all books which were wrote by author
            //then delete author
            $author = Author::find($id);
            foreach($author->books as $book)
                Storage::delete('public/images/books/'.$book->image);
            $author->books()->delete();
            Storage::delete('public/images/authors/'.$author->image);
            $author->delete();
        }

        return redirect()->back()->with('success', 'Deleted successfully!');
    }
}
