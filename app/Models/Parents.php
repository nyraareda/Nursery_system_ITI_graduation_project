<?php

namespace App\Models;
use App\Models\Child;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parents extends Model
{
    use HasFactory;

    public function children()
    {
        return $this->hasMany(Child::class);
    }
}
