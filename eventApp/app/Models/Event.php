<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Event extends Authenticatable
{

    use HasFactory,HasApiTokens,Notifiable;

    protected $fillable = [
        'name',
        'description',
        'location',
        'starting_date',
        'organizer_id'
    ];

    public function members()
    {
        return $this->belongsTo(Member::class);
    }
}
