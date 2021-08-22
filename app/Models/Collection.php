<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;

class Collection extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable =[
        'name','description','stock', 'price', 'rate', 'types', 'category','picturePath','url_barcode','photoBarcode','perhitungan_akhir','total_jumlah_order'
    ];

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->timestamp;
    }

    public function getUpdatedAtAttribute($value)
    {
        return Carbon::parse($value)->timestamp;
    }

    public function toArray(){
        $toArray = parent::toArray();
        $toArray['picturePath'] = $this->picturePath;
        $toArray['photoBarcode'] = $this->photoBarcode;

        return $toArray;
    }

    public function getPicturePathAttribute()
    {
        return url('') . Storage::url($this->attributes['picturePath']);
    }

    public function getPhotoBarcodeAttribute()
    {
        return url('') . Storage::url($this->attributes['photoBarcode']);
    }
}
