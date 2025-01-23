<?php

namespace App\Console\Commands;

use App\Models\Order;
use App\Services\Events\EventsService;
use App\Services\Microservices\SiteLogger;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class SendEventNotifyBeforeFreeClients extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'event:send-notify-before-free';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send notify before free clients';

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
        (new EventsService)->cronNotifiesBeforeFreeClients();
        $this->info('Команда виконана успішно!');
        return 0;
    }
}
