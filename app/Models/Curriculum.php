<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Curriculum extends Model
{
    use HasFactory;

    protected $fillable = [
        'level',
        'description'
    ];
    protected $table = 'curriculums';
    public function classes()
    {
        return $this->hasMany(Classes::class);
    }
}
