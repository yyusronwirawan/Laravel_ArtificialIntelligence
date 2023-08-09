<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OpenAIGenerator extends Model
{
    use HasFactory;
    protected $table = 'openai';
}
