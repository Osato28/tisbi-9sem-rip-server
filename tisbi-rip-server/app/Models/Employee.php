<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    //
    use HasFactory;

    public function jobTitle() {
        return $this->belongsTo(JobTitle::class);
    }

    public function bonuses() {
        return $this->hasMany(Bonus::class);
    }
}
