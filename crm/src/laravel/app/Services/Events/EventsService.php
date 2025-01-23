<?php
namespace App\Services\Events;

use App\Events\CreateCommentOrder;
use App\Models\Event;
use App\Models\Order;
use App\Models\Stage;
use App\Models\User;
use App\Models\Handbook;
use App\Models\Client;
use App\Services\Microservices\SiteLogger;
use App\Services\Telegram\TelegramService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class EventsService
{

    public Event $model;
    public array $fields;
    public TelegramService $telegram;
    private $siteLogger;
    const HOURS_BEFORE_SET_FREE_CLIENT = 2;
    const TEXT_BEFORE_SET_FREE_CLIENT = 'Доброго дня!
Вам потрібно підтвердити співпрацю з клієнтом {FIO}. Змініть етап угоди або продовжіть поточний етап.
Якщо цього не зробити, клієнт буде в загальній базі клієнтів, доступний всім агентам компанії!';

    public function __construct()
    {
        $this->model = new Event;
        $this->fields = $this->model->getFillable();
        $this->telegram = new TelegramService;
        $this->siteLogger = new SiteLogger;
    }

    /**
     * @param Request $request
     * @return array
     */
    public function getRemindList(Request $request) :array
    {
        $list = $this->model->where('user_id', auth()->user()->id)
            ->where('remind_at', '<', Carbon::now())
            ->whereNull('closed_at')
            ->with('client')
            ->with('order')
            ->orderBy('remind_at')
            ->get()
            ->toArray();

        foreach ($list as &$v) {
            $v['remind_at'] = Carbon::parse($v['remind_at'])->format('d.m.Y H:i');
            $v['title'] = $this->eventTitle($v);
        }

        return $list;
    }

    /**
     * @param Request $request
     * @return array
     */
    public function closeEvent(Request $request) :array
    {

        $event = $this->model->findOrFail($request->id);

        $result = $event->update([
            'closed_at' => Carbon::now(),
        ]);

        if ($event->type === Event::EVENT_TYPE_NOTIFY) {
            $log = [
                'title' => 'Взяв в роботу',
                'action' => 'EventsService.closeEvent',
                'tags' => [
                    ['entity' => 'clients', 'id' => intval($event->client_id)],
                    ['entity' => 'users', 'id' => intval($event->user_id)]
                ],
                'type' => 'INFO',
            ];
            $this->siteLogger->createLog($log);
        }

        return [
            'success' => $result,
            'message' => $result ? 'Подія завершена' : 'Щось пішло не так..'
        ];
    }

    /**
     * @param Request $request
     * @return array
     */
    public function restoreEvent(Request $request) :array
    {
        $response = [
            'success' => $request['remind_at'] ? $this->model->where('id', $request['id'])->update([
                'remind_at' => $request['remind_at'],
            ]) : false,
        ];

        $response['message'] = $response['success'] ? 'Термін продовжено' : 'Щось пішло не так..';

        return $response;
    }

    protected function eventTitle($event, $tlg = false)
    {
        $title = $event['title'];

        if($event['type'] == $this->model::EVENT_TYPE_STAGE_CHANGED) {
            $order = Order::with('rooms', 'districts')->find($event['order_id']);
            $stage = (new Handbook)->getHandbook('stages', (object)['id'=>$order->stage_id]);

            $title = $event['title'] . ' (' . $order->category . ', ' . $order->adv_type .
                ', єтап: ' . $stage['title'] . ')';

            if($tlg) {
                $client = Client::find($event['client_id']);
                $rooms = collect($order->rooms)->pluck('rooms')->toArray();
                $districts = collect($order->districts)->pluck('title')->toArray();

                $title = $client->fio . PHP_EOL .
                    $order->adv_type . ', ' .
                    $order->category;

                if(! empty($rooms)) $title .=
                    ', ' . PHP_EOL . 'Кімнат: ' . implode(',', $rooms);

                if(! empty($districts)) $title .=
                    ', ' . PHP_EOL . 'Район: ' . implode(',', $districts);

                if($order->price) $title .=
                    ', ' . PHP_EOL .
                    ($order->adv_type == 'Купівля' ? 'до ' : '') .
                    '$' . number_format($order->price, 0, '', ' ');

                if($event['title']) $title .=
                    ', ' . PHP_EOL . PHP_EOL . $event['title'];
            }
        }

        return $title;
    }

    public function cronNotifies()
    {
        $list = $this->model->where('notified', false)
            ->where('remind_at', '<', Carbon::now())
            ->whereNull('closed_at')
            ->get();

        foreach ($list as $event) {
            $user = User::find($event->user_id);

            if(! empty($user->telegram_id)) {
                $sendData = [
                    'user_id' => $event->user_id,
                    'chat_id' => $user->telegram_id,
                    'text'    => $this->eventTitle($event, true),
                ];
                $this->telegram->sendMessage($sendData);
            }

            Event::where('id', $event->id)->update(['notified' => true]);
        }
    }

    public function cronNotifiesBeforeFreeClients()
    {

        $list = $this->model
            ->with('order')
            ->where('notified', true)
            ->where('notified2', false)
            ->whereNull('closed_at')
            ->where('type', '!=', Event::EVENT_TYPE_NOTIFY)
            ->get();

        foreach ($list as $event) {
            if($event->order) {
                $period = Stage::where('id', '=', $event->order->stage_id)->first()->unsubscribe_period;
                if(!$period) $period = 3;
                if(Carbon::now() > Carbon::parse($event->remind_at)->addDays($period)->subHours(self::HOURS_BEFORE_SET_FREE_CLIENT)) {

                    $user = User::find($event->user_id);

                    if(! empty($user->telegram_id)) {
                        $sendData = [
                            'user_id' => $event->user_id,
                            'chat_id' => $user->telegram_id,
                            'text'    => $this->makeText($user)
                        ];
                        $this->telegram->sendMessage($sendData);
                    }

                    Event::where('id', $event->id)->update(['notified2' => true]);
                }
            }
        }
    }

    public function makeText($user)
    {
        return strtr(self::TEXT_BEFORE_SET_FREE_CLIENT, [
            '{FIO}' => $user->name,
        ]);
    }

    public function cronFreeClients()
    {
        $list = $this->model
            ->with('order')
            ->where('notified', true)
            ->whereNull('closed_at')
            ->where('type', '!=', Event::EVENT_TYPE_NOTIFY)
            ->get();

        foreach ($list as $event) {
            if($event->order) {
                $period = Stage::where('id', '=', $event->order->stage_id)->first()->unsubscribe_period;

                if(!$period) $period = 3;

                if(Carbon::now() > Carbon::parse($event->remind_at)->addDays($period)) {
                    Event::where('client_id', $event->client_id)
                        ->where('user_id', $event->user_id)
                        ->update(['closed_at' => Carbon::now()]);

                    Client::find($event->client_id)->update(['user_id' => null]);
                }
            }
        }
    }
}
