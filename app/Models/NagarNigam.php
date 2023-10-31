<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NagarNigam extends Model
{
    protected $table = 'master_nn';
    
    public function district()
    {
        return $this->belongsTo(District::class, 'district_id');
    }
}
