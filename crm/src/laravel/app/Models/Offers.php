<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offers extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'link',
        'comment',
        'archive',
        'order',
        'show_date',
        'created_at',
        'img',
    ];

    public function realstate()
    {
        return $this->hasOne(Order::class,'id', 'order_id');
    }
}
