<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class ContactUser extends Model
{
    protected $table ="contactusers";
    protected $fillable = [
        'name',
        'email',
        'phone',
		'content',
        'subject',
        'type'
    ];
}