<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class generalsetting extends Model
{
    protected $fillable = [
        'logo',
        'favicon',
        'og',
        'logo_text',
        'contact_number',
        'skype',
        'email',
        'google_analytics',
        'smtp_email',
        'smtp_password',
        'web_master',
        'fbid',
        'bing_master'
    ];
}
