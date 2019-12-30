<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\GoogleBooks;
use App\Book;
use Illuminate\Http\Response;
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
    private $limit = 15;

    private $pageLimit = 10;

    /**
     * BookController constructor
     */
    public function __construct() {
        $this->googleBooks = new GoogleBooks([
            'key' => 'AIzaSyDqVSJGBNJz-9-r2vjWzvqF14_bxKe2l_U',
            'maxResults' => $this->limit,
        ]);
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        return $this->search($request);
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function search(Request $request)
    {
        $q = $request->query('q');
        $startIndex = !empty($request->query('page')) ? $request->query('page') * $this->limit : 0;

        $results = $this->googleBooks->raw('volumes', [
            'q' => $q,
            'startIndex' => $startIndex,
            'langRestrict' => 'en',
            'orderBy' => 'relevance',
            'printType' => 'books'
        ]);

        $numOfPages = ceil($results['totalItems'] / $this->limit);
        $currentPage = !empty($request->query('page')) ? (int)$request->query('page') : 1;

        $list = array_map([$this->googleBooks, "formatGoogleResult"], $results['items']);

        return response([
            'status' => 'success',
            'numOfPages' => ($this->pageLimit < $numOfPages) ? $this->pageLimit : $numOfPages,
            'currentPage' => $currentPage,
            'results' => $list
        ]);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $gBook = $this->googleBooks->raw("volumes/" . $request->google_id);
        $book = $this->googleBooks->formatGoogleResult($gBook);
        $book['short_description'] = strip_tags($request->description);
        $book['user_id'] = Auth::user()->id;
        $book['order'] = 0;
        Book::create($book);
        return response([$book], 201);
    }

    /**
     * Display the specified resource.
     * @param Request $request
     * @param int $id
     * @return Response
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
            $book = $this->googleBooks->formatGoogleResult($result);
        }

        return response([
            'status' => 'success',
            'details' => $book
        ]);
    }

    /**
     * Remove the specified resource from storage.
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $deleted = Book::where([
            'id' => $id,
            'user_id' => Auth::user()->id
        ])->delete();

        return response(['deletedIds' => $deleted]);
    }
}
