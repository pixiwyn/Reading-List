<?php

namespace App\Http\Controllers;

use App\Book;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class ListController extends Controller
{
    /**
     * @var int limit
     */
    private $limit = 5;

    /**
     * Display a listing of the resource.
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $order_by = !empty($request->query('order_by')) ? $request->query('order_by') : 'created_at';
        $direction = !empty($request->query('direction')) ? $request->query('direction') : 'DESC';
        $books = Book::where([
            'user_id' => Auth::user()->id
        ])->orderBy($order_by, $direction)->paginate($this->limit);
        return response([
            'books' => $books
        ]);
    }
}
