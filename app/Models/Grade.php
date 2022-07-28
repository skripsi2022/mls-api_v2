<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    use HasFactory;
    protected $table = 'grade';
    protected $primaryKey = 'id_grade';
    protected $fillable = ['user_id', 'quiz_id', 'grade'];
}
