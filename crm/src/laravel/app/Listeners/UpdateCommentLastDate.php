<?php

namespace App\Listeners;

use App\Events\CreateCommentOrder;
use Carbon\Carbon;

class UpdateCommentLastDate
{
    /**
     *
     * @param CreateCommentOrder $event
     * @return void
     */
    public function handle(CreateCommentOrder $event)
    {
        $order = $event->order;
        $order->last_comment_date = Carbon::now();
        $order->save();
    }
}
