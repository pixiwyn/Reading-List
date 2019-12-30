<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Helpers\GoogleBooks;

class GoogleBooksTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testCreateGoogleBooks()
    {
        $gBooks = new GoogleBooks(['key' => env('GOOGLE_API_KEY'), 'maxResults' => env('GOOGLE_API_LIMIT')]);
        $this->assertIsObject($gBooks);
    }
}
