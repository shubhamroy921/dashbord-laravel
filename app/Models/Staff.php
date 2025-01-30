<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    use HasFactory;
    protected $table ='staffs';
    protected $fillable = [
        'staff_photo',
        'name',
        'gender',
        'father_name',
        'mother_name',
        'dob',
        'phone_number',
        'alternate_number',
        'role',
        'email',
        'current_address',
        'permanent_address',
        'document',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'dob' => 'date',
    ];
}
