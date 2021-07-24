<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Lelang extends Model
{
    use HasFactory;

    public $filable = [
        'id_collection', 'time', 'bid','status'
    ];

    public function collection()
    {
        return $this->hasOne(Collection::class, 'id', 'id_collection');
    }

    public function getCreatedAtAttribute($created_at)
    {
        return Carbon::parse($created_at)
            ->getPreciseTimestamp(3);
    }
    public function getUpdatedAtAttribute($updated_at)
    {
        return Carbon::parse($updated_at)
            ->getPreciseTimestamp(3);
    }
}
