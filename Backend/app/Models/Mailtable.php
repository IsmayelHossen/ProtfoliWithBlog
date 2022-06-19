<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mailtable extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'toemail',
        'subject',
        'message',
        'fromemail',
    ];
}
