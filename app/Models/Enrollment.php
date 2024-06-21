<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
    use HasFactory;
    protected $dates = ['date_enrolled'];
    public function child()
    {
        return $this->belongsTo(Child::class);
    }
}
