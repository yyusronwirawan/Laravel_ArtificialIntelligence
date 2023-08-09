<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Mews\Purifier\Casts\CleanHtml;

class HowitWorks extends Model
{
    use HasFactory;
    protected $table = 'howitworks';

    protected $casts = [
        'title' => CleanHtml::class,
    ];

}
