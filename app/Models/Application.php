<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;
    protected $casts = [
        'date_submitted' => 'datetime',
    ];
    protected $fillable = ['child_id', 'status', 'date_submitted'];

    public function child()
    {
        return $this->belongsTo(Child::class);
    }
}
