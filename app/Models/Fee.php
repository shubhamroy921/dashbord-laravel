<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fee extends Model
{
    use HasFactory;
    protected $fillable = ['student_id', 'amount', 'payment_date'];

    // A fee belongs to a student
    public function student()
    {
        return $this->belongsTo(Student::class);
    }
    protected $casts = [
        'payment_date' => 'datetime',
    ];
}
