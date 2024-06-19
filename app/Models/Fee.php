<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fee extends Model
{
    use HasFactory;

    protected $fillable = ['child_id', 'amount' ,'status', 'description','due_date'];
    
    public function child()
    {
        return $this->belongsTo(Child::class);
    }
}
