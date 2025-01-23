<?php

namespace App\Models;

use App\Enums\ClientStatus;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'fio',
        'email',
        'description',
        'income_source_id',
        'income_source',
        'is_agency',
        'agency',
        'user_id',
        'social',
        'status',
    ];

    protected $casts = [
        'status' => ClientStatus::class,
        'last_comment_date' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function phoneNumbers()
    {
        return $this->hasMany(ClientPhone::class);
    }

    public function events()
    {
        return $this->hasMany(Event::class)
            ->where('remind_at', '<', Carbon::now())
            ->whereNull('closed_at');
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
