<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Notas extends Model
{
    use HasFactory;

    protected $table = 'table_notas';

    protected $fillable = [
        'title',
        'content'
    ];
}
