<?php

namespace App\Models;

use App\Observers\VendorServiceObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class VendorService extends Model
{
    use HasFactory;
    protected $fillable = [
        'service_type_id',
        'license_number',
        'license_issueing_body',
        'document',
        'expiry_date'
    ];
    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }
}
