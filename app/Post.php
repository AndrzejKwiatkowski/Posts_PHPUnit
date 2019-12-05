<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Post extends Model
{
    
    protected $fillable = ['title', 'body', 'published_at'];

    public function scopePublished($query)
    {
        //return $query->whereNotNull('published_at');
        //return $query->whereNotNull('published_at')->where('published_at', '<', Carbon::now());
        return $query->whereNotNull('published_at')->where('published_at', '<=', Carbon::now());
    }

}
