<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\GoogleBooks;
use App\Book;
use Illuminate\Support\Facades\Auth;


class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $books = Book::where('user_id', Auth::user()->id)->get();
        return response()->json([
            'books' => $books
        ]);
    }

    public function search(Request $request) {
        $googleBooks = new GoogleBooks([
            'key' => 'AIzaSyDqVSJGBNJz-9-r2vjWzvqF14_bxKe2l_U',
            'maxResults' => 25,
        ]);

        $q = $request->query('q');
        $results = $$googleBooks->raw('volumes', ['q' => $q, 'orderBy' => 'relevance', 'printType' => 'books']);
        return response()->json($results);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $book = Book::create([
            'google_id' => $request->google_id,
            'title' => $request->title,
            'description' => $request->description,
            'cover_img_url' => $request->cover_img_url,
            'user_id' => Auth::user()->id,
        ]);

        return response()->json($book);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //Not implemented
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deleted = Book::where([
            'id' => $id,
            'user_id' => $this->user_id
        ])->delete();

        return response()->json(['deletedIds' => $deleted]);
    }
}
