<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'customers';

    protected $fillable = [
        'name',
        'email',
        'dob',
        'location',
        'current_timezone',
    ];

    public function queue(): HasMany
    {
        return $this->hasMany(Queue::class, 'customer_id');
    }
}
