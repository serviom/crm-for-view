<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    /**
     * @property int $user_id
     * @property int $client_id
     * @property int $order_id
     * @property string $type
     * @property string $title
     * @property string $comment
     * @property \Illuminate\Support\Carbon|null $remind_at
     * @property \Illuminate\Support\Carbon|null $closed_at
     */

    protected $fillable = ['user_id', 'client_id', 'order_id', 'type', 'title', 'comment', 'remind_at', 'closed_at'];

    const EVENT_TYPE_NOTIFY = 1;
    const EVENT_TYPE_STAGE_CHANGED = 2;
    const PERIOD_HOURS = 1;
    const PERIOD_DAYS  = 2;

    public $period_types = [
        ['id' => self::PERIOD_HOURS, 'title' => 'години'],
        ['id' => self::PERIOD_DAYS,  'title' => 'дні'],
    ];

    public function client()
    {
        return $this->hasOne(Client::class,'id', 'client_id')->with('phoneNumbers');
    }

    public function order()
    {
        return $this->hasOne(Order::class,'id', 'order_id');
    }

    static public function remindTime($stage)
    {
        $date = Carbon::now();

        switch ($stage->period_type) {
            case self::PERIOD_HOURS:
                $date->addHours($stage->period);
                break;
            case self::PERIOD_DAYS:
                $date->addDays($stage->period);
                break;
        }

        return $date;
    }
}
