<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{

    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'location',
        'starting_date',
        'ending_date',
        'organizer_id',
        'capacity',
        'status',
    ];

    public function members()
    {
        return $this->belongsToMany(Member::class, 'event_member');
    }
}
