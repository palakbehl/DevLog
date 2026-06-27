<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [ // allows mass assignment for these fields, meaning you can create or update a post with an array of these attributes without having to set each one individually

        'user_id',
        'title',
        'slug',
        'content',
        'featured_image',
        'is_published'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}