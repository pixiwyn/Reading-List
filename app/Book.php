<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'google_id',
        'title',
        'order',
        'description',
        'short_description',
        'authors',
        'published_date',
        'buy_link',
        'average_rating',
        'ratings_count',
        'cover_img_url',
        'user_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'google_id', 'user_id',
    ];

}
