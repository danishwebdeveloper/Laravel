<?php



namespace App;



use Illuminate\Database\Eloquent\Model;



class Views extends Model

{

    protected $fillable = [

        'view_date',

        'post_id',

		'views',
		
		'page_name',

		'page_id'

    ];

}

