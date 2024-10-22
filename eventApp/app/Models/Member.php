<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{

    use HasFactory;



    protected $fillable = [
        'name',
        'email',
        'password',
        'role'
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
