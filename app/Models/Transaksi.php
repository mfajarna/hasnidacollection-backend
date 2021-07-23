<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaksi extends Model
{
    use HasFactory;

    protected $fillable = [
        'collection_id', 'user_id', 'quantity', 'total', 'status', 'no_resi','no_transaksi','jasa','pembayaranPath'
    ];

    public function collection()
    {
        return $this->hasOne(Collection::class, 'id', 'collection_id');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function toArray()
    {
        $toArray = parent::toArray();
        $toArray['pembayaranPath'] = $this->pembayaranPath;

        return $toArray;
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

    public function getpembayaranPathhAttribute()
    {
        return config('app.url') . Storage::url($this->attributes['pembayaranPath']);
    }
}
