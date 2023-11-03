<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VerificationLog extends Model
{
    public function userDocument() {
        return $this->belongsTo(UserDocument::class);
    }
}
