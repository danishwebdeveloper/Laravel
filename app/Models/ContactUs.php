<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContactUs extends Model
{
    protected $fillable = [
        'meta_title',
        'meta_description',
        'meta_tags'
    ];
}
