<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobTitle extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'name',
        'insurance_payout'
    ];

    public function employees() {
        return $this->hasMany(Employee::class);
    }
}
