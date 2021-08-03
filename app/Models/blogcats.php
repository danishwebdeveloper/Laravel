<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class blogcats extends Model
{
   protected $fillable = [
        'title',
        'slug',
        'tb-order',
        'meta_title',
        'popular_title',
        'meta_description',
        'details',
        'meta_tags',
        'before_popular',
        'after_popular',
        'after_title',
        'microdata',
        'og_image',
    ];
}
