<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tukarbarang extends Model
{
    use HasFactory;

    protected $fillable = [
          'id_collection', 'id_users', 'alasan_tukar_barang', 'buktiPhoto', 'status'
    ];

    public function collection()
    {
        return $this->hasOne(Collection::class, 'id', 'id_collection');
    }

    public function users()
    {
        return $this->hasOne(User::class, 'id', 'id_users');
    }

    public function toArray()
    {
        $toArray = parent::toArray();
        $toArray['buktiPhoto'] = $this->buktiPhoto;

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

    public function getBuktiPhotoAttribute()
    {
        return url('') . Storage::url($this->attributes['buktiPhoto']);
    }
}
