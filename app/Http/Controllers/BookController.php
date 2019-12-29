<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\GoogleBooks;
use App\Book;
use Illuminate\Support\Facades\Auth;

class BookController extends Controller
{

    /**
     * @var GoogleBooks
     */
    private $googleBooks;

    /**
     * @var int limit
     */
    private $limit = 25;

    public function __construct() {
        $this->googleBooks = new GoogleBooks([
            'key' => 'AIzaSyDqVSJGBNJz-9-r2vjWzvqF14_bxKe2l_U',
            'maxResults' => $this->limit,
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $q = $request->query('q');
        $results = $this->googleBooks->raw('volumes', ['q' => $q, 'orderBy' => 'relevance', 'printType' => 'books']);

        $numOfPages = ceil($results['totalItems'] / $this->limit);
        $currentPage = !empty($request->query('pages')) ? $request->query('pages') : 1;

       $list = array_map([$this, "formatGoogleResult"], $results['items']);

        return response([
            'status' => 'success',
            'numOfPages' => $numOfPages,
            'currentPage' => $currentPage,
            'results' => $list
        ]);
    }

    /**
     * @param $result
     * @return array
     */
    private function formatGoogleResult($result) {
        return [
            'google_id' => $result['id'],
            'id' => $result['id'],
            'title' => $result['volumeInfo']['title'],
            'authors' => isset($result['volumeInfo']['authors']) ? $result['volumeInfo']['authors'] : [],
            'description' => isset($result['volumeInfo']['description']) ? $result['volumeInfo']['description'] : '',
            'cover_img_url' => isset($result['volumeInfo']['imageLinks']['smallThumbnail']) ? $result['volumeInfo']['imageLinks']['smallThumbnail'] : '#'
        ];
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
    public function show(Request $request, $id)
    {
        $bookType = !empty($request->query('bookType')) ? $request->query('bookType') : 'list';

        if($bookType === 'list') {
            $book = Book::where([
                'id' => $id,
                'user_id' => Auth::user()->id
            ])->first();
        } else {
            $result = $this->googleBooks->raw("volumes/$id");
            $book = $this->formatGoogleResult($result);
            //$book = $result;
        }


        return response([
            'status' => 'success',
            'details' => $book
        ]);
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
            'user_id' => Auth::user()->id
        ])->delete();

        return response()->json(['deletedIds' => $deleted]);
    }
}
