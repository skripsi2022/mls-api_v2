<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use HasFactory;

    protected $table = 'answer';
    protected $primaryKey = 'id_answer';
    protected $fillable = ['quiz_id','question_id', 'user_id','answer', 'result'];
}
