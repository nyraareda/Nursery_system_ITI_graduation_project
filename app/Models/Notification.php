<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = ['parent_id', 'title', 'message'];

    public function parent()
    {
        return $this->belongsTo(Parents::class);
    }
}
