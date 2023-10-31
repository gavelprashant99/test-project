<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NagarPanchayat extends Model
{
    protected $table = 'nagar_panchayat';
    
    public function district()
    {
        return $this->belongsTo(District::class, 'district_id');
    }
}
