<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NagarPalika extends Model
{
    protected $table = 'master_np';
    
    public function district()
    {
        return $this->belongsTo(District::class, 'district_id');
    }
}
