<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserOpenaiChat extends Model
{
    use HasFactory;
    protected $table = 'user_openai_chat';

    public function messages(){
        return $this->hasMany(UserOpenaiChatMessage::class);
    }

    public function category(){
        return $this->belongsTo(OpenaiGeneratorChatCategory::class, 'openai_chat_category_id', 'id' );
    }
}
