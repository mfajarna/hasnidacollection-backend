<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Lelangdetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_collection', 'id_users','jumlah_bid'
    ];

    public function collection()
    {
        return $this->hasOne(Collection::class, 'id', 'id_collection');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'id_users');
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
