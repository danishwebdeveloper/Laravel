<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class Faqs extends Model
{
    protected $fillable = [
        'question',
        'answer',
        'tb-order'
    ];
}
