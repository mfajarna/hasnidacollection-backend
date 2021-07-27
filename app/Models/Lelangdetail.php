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
        'id_lelang', 'id_users','id_collection','jumlah_bid'
    ];

    public function lelang()
    {
        return $this->hasOne(Lelang::class, 'id', 'id_lelang');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'id_users');
    }

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
