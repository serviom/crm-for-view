<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientPhone extends Model
{
    use HasFactory;

    protected $fillable = [
        'phoneNumber',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function setPhoneNumberAttribute($value)
    {
        $value = str_replace( ['+38', ' ' , '(', ')', '-'],  '',  $value);
        $this->attributes['phoneNumber'] = $value;
    }
}
