<?php

namespace App\Console\Commands;

use App\Models\Order;
use App\Services\Microservices\SiteLogger;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class UpdateLastCommentDate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:last-comment-date';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update field last_comment_date for each order';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        $orders = Order::all();
        $filter = [
            'tags' => ['entity' => 'order', 'id' => 0],
            'type' => 'ORDER_COMMENT',
            'limit' => 1,
            'dir' => 'desc',
            'orderby' => 'date'
        ];

        $orders->each(function (Order $order, int $key) use ($filter) {
            $filter['tags']['id'] = $order->id;
            $list = (new SiteLogger)->getLogsList($filter);
            if (!empty($list['data']['data'][0])) {
                $data = $list['data']['data'][0];

                $order->last_comment_date = Carbon::parse($data['date'])->timestamp;
                $order->save();
            }
        });

        $this->info('Команда виконана успішно!');

        return 0;
    }
}
