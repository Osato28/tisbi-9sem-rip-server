<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bonus extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'date',
        'sum',
        'employee_id'
    ];

    public function employee() {
        return $this->belongsTo(Employee::class);
    }
}
