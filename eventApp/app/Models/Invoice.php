<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Invoice extends Authenticatable
{
    use HasFactory,HasApiTokens,Notifiable;
    protected $fillable = [
        'status',
        'memberID',
        'billedDate',
        'paidDate',
    ];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }
}
