<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaction extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'collection_id', 'user_id', 'quantity', 'total', 'status', 'no_resi'
    ];

    public function collection()
    {
        return $this->hasOne(Collection::class, 'id', 'collection_id');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

     public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->timestamp;
    }

    public function getUpdatedAtAttribute($value)
    {
        return Carbon::parse($value)->timestamp;
    }
}
