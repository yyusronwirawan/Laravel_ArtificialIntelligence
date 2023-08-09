<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OpenaiGeneratorFilter extends Model
{
    use HasFactory;
    protected $table = 'openai_filters';
    public $timestamps = false;
}
