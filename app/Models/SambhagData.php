<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SambhagData extends Model
{
    protected $table = 'master_sambhag';

    public function districts()
    {
        return $this->hasMany(District::class, 'sambhag_id');
    }
}
