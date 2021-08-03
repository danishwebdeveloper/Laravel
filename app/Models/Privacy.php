<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class Privacy extends Model
{
	
    protected $fillable = [
        'meta_title',
        'meta_description',
        'meta_tags',
		'title', 
        'content',
        'views',
        'og_image'
    ];
}
