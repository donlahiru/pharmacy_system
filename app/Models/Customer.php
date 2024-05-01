<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use SoftDeletes, HasFactory;

    const ACTIVE_STATUS = 'active';
    const INACTIVE_STATUS = 'inactive';

    protected $fillable = [
        'first_name',
        'last_name',
        'street_address',
        'city',
        'postal_code',
        'phone_no',
        'status',
        'created_by',
        'updated_by',
        'deleted_by'
    ];

    public function getFillable()
    {
        return $this->fillable;
    }
}
