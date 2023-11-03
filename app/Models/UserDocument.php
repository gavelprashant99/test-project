<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDocument extends Model
{
    public function verificationLogs() {
        return $this->hasMany(VerificationLog::class);
    }
}
