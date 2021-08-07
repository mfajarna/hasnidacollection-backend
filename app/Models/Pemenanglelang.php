<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pemenanglelang extends Model
{
    use HasFactory;

    protected $fillable = [
        'users_id','collection_id','lelangdetail_id','pembayaranPath','status'
    ];

    public function lelangdetail()
    {
        return $this->hasOne(Lelangdetail::class, 'id', 'lelangdetail_id');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'users_id');
    }

    public function collection()
    {
        return $this->hasOne(Collection::class, 'id', 'collection_id');
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


    public function getPembayaranPathAttribute()
    {
        return url('') . Storage::url($this->attributes['pembayaranPath']);
    }
}
