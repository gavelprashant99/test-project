<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class District extends Model
{

        protected $table = 'master_district';
    
        public function sambhag()
        {
            return $this->belongsTo(SambhagData::class, 'sambhag_id');
        }
    
}
