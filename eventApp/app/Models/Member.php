<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Member extends Authenticatable
{

    use HasFactory,HasApiTokens,Notifiable;



    protected $fillable = [
        'name',
        'email',
        'password',
        'role'
    ];
    protected $hidden = [
        'password',
        'remember_token',
    ];


    public function events()
    {
        return $this->belongsToMany(Event::class, 'event_member');
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }
}
