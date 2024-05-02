<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Medication extends Model
{
    use SoftDeletes, HasFactory;

    const ACTIVE_STATUS = 'active';
    const INACTIVE_STATUS = 'inactive';

    protected $fillable = [
        'name',
        'description',
        'quantity',
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
