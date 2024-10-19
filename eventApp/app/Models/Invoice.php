<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;
    protected $fillable = [
        'status',
        'memberID',
        'billedDate',
        'paidDate',
    ];
    public function member(){
        return $this->belongsTo(Member::class);
    }
}
