<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Mews\Purifier\Casts\CleanHtml;

class Testimonials extends Model
{
    use HasFactory;
    protected $table = 'testimonials';

    protected $casts = [
        'words' => CleanHtml::class,
    ];

}
