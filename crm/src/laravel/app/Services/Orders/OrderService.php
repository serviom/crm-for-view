<?php
namespace App\Services\Orders;

use App\Enums\ClientStatus;
use App\Events\CreateCommentOrder;
use App\Models\Event;
use App\Models\Handbook;
use App\Models\Order;
use App\Models\Client;
use App\Models\Stage;
use App\Services\Events\EventsService;
use App\Services\Microservices\SiteLogger;
use Carbon\Carbon;
use Illuminate\Http\Request;

class OrderService
{
    protected $model;
    private $fields;
    private $siteLogger;
    private $eventService;

    public function __construct()
    {
        $this->model = new Order;
        $this->fields = $this->model->getFillable();
        $this->siteLogger = new SiteLogger;
        $this->eventService = new EventsService;
    }

    public function getList(Request $request)
    {
        $response = [
            'code' => 200,
        ];

        $sort    = !empty($request->sort) ? $request->sort : 'id';
        $orderBy = !empty($request->orderBy) ? $request->orderBy : 'desc';

        $query = $this->model->select()->with('color', 'client', 'districts', 'rooms', 'floors');

        if ( ! empty($request->only_active) && $request->only_active) $query->whereNull('closed_at');
        if ( ! empty($request->stage_id) && $request->stage_id) $query->where('stage_id', (int)$request->stage_id);
        if ( ! empty($request->with_client_data)) $query->with('client');
        if(empty($request->client_id)){
            $request->client_id = Client::where('user_id', '=', auth()->user()->id)->pluck('id')->all();
            $query->whereIn('client_id', $request->client_id);
        } else $query->where('client_id', (int)$request->client_id);

        $list  = $query->orderBy($sort, $orderBy)->get();
        $total = count($list);

        if($total){
            foreach ($list as &$v) {
                if(! empty($v->client)) {
                    $v->client['phoneNumbers'] = isset($v->client['phone_numbers']) ? $v->client['phone_numbers'] : [];
                }
            } unset($v);
        }

        $response['list'] = $total ? $list : [];
        $response['total'] = $total;

        return $response;
    }

    public function getItem($id)
    {
        if(! empty($id) && isset($id)) {
            return $this->model->with('client', 'districts', 'rooms', 'floors')->find($id);
        }
        return null;
    }

    public function saveItem($request)
    {
        $response = [
            'code' => 200,
            'message' => 'Something wrong..',
        ];
        $data = [];
        $title = '';

        if(! empty($request->id)){
            $order = $this->model->findOrFail($request->id);

            if($order) {
                $title = 'Редагування угоди "' . $order->category . ' / ' . $order->adv_type . '"';

                $data['prev'] = $order;
                $response['success'] = $order->update($request->fields);

                $data['new'] = $order;

                if($response['success']) {
                    $response['message'] = 'Угоду збережено';
                }

                if(! empty($request->fields['closed_at']) && isset($request->fields['closed_at'])) {
                    $this->addEvent($request->id, (object)[]);
                }
            }
        } else {
            $order = $this->model->create($request->fields);

            $title = 'Створено угоду "' . $order->category . ' / ' . $order->adv_type . '"';
            $data['new'] = $order;
            $response['message'] = 'Угоду створено';

            $stage = Stage::where('id', '=', $order->stage_id)->first();
            $date = Event::remindTime($stage);
            $this->addEvent($order->id, (object)[
                'comment' => 'Нова угода',
                'client_id' => $order->client_id,
                'user_id' => Client::where('id', '=', $order->client_id)->first()->user_id,
                'stage' => [
                    'date' => $date->format('Y-m-d'),
                    'time' => $date->format('H:i'),
                    'new' => [
                        'is_last' => $stage->is_last,
                    ]
                ]
            ]);
        }

        $log = [
            'title' => $title,
            'action' => 'OrderService.saveItem',
            'tags' => [
                ['entity' => 'order', 'id' => intval($request->id ?? $order->id)],
                ['entity' => 'clients', 'id' => intval($request->client_id)]
            ],
            'type' => 'INFO',
        ];
        if(! empty($data)) {
            $log['log']['data'] = $data;
        }

        $this->siteLogger->createLog($log);

        if(! empty($request->fields['districts'])){
            $order->districts()->sync($request->fields['districts']);
        }

        if(! empty($request->fields['rooms']) && isset($request->fields['rooms'])) {
            $order->rooms()->delete();
            $rooms = [];

            if(is_array($request->fields['rooms'])) {
                foreach ($request->fields['rooms'] as $v) {
                    $rooms[] = [
                        'order_id' => $order->id,
                        'rooms' => $v,
                    ];
                }
            } else {
                $rooms[] = [
                    'order_id' => $order->id,
                    'rooms' => $request->fields['rooms'],
                ];
            }

            $order->rooms()->createMany($rooms);
        }

        if(! empty($request->fields['floors']) && isset($request->fields['floors'])) {
            $order->floors()->delete();
            $floors = [];

            if(is_array($request->fields['floors'])) {
                foreach ($request->fields['floors'] as $v) {
                    $floors[] = [
                        'order_id' => $order->id,
                        'floors' => $v,
                    ];
                }
            } else {
                $floors[] = [
                    'order_id' => $order->id,
                    'floors' => $request->fields['floors'],
                ];
            }

            $order->floors()->createMany($floors);
        }

        if(! empty($request->fields['comment']) && isset($request->fields['comment'])) {
            $log = [
                'title' => $request->fields['comment'],
                'action' => 'OrderService.saveItem.comment',
                'tags' => [
                    ['entity' => 'order', 'id' => intval($request->id ?? $order->id)],
                    ['entity' => 'clients', 'id' => intval($request->client_id)]
                ],
                'type' => 'ORDER_COMMENT',
            ];

            $this->siteLogger->createLog($log);
        }

        return $response;
    }

    public function cancelItem($request)
    {
        $response = [
            'code' => 200,
            'message' => 'Something wrong..',
        ];

        if( ! empty($request->id)){
            $order = $this->model->findOrFail($request->id);
            $data = [];

            if($order) {
                $data['prev'] = $order;
                $response['success'] = $order->update(['closed_at' => Carbon::now()]);
                $data['new'] = $order;

                $response['message'] = $title = 'Угоду завершено';
                $title .= ' "' . $order->category . ' / ' . $order->adv_type . '"';

                $log = [
                    'title' => $title,
                    'action' => 'Order.cancelOrder',
                    'tags' => [
                        ['entity' => 'order', 'id' => intval($order->id)],
                        ['entity' => 'clients', 'id' => intval($order->client_id)]
                    ],
                    'type' => 'INFO',
                ];
                if(! empty($data)) {
                    $log['log']['data'] = $data;
                }

                $this->siteLogger->createLog($log);

                (new Event)->where('order_id', $request->id)->update(['closed_at' => Carbon::now()]);
            }
        }

        return $response;
    }

    public function removeItem($id)
    {
        $response = [
            'code' => 200,
            'message' => 'Something wrong..',
        ];

        $order = $this->model->findOrFail($id);

        if ($order) {
            $response['success'] = $success = $order->delete();

            if($success) {
                $response['message'] = 'Угоду видалено';

                $log = [
                    'title' => 'Угоду видалено "' . $order->category . ' / ' . $order->adv_type . '"',
                    'action' => 'Order.removeOrder',
                    'tags' => [
                        ['entity' => 'order', 'id' => intval($order->id)],
                        ['entity' => 'clients', 'id' => intval($order->client_id)]
                    ],
                    'type' => 'INFO',
                    'log' => ['data' => $order],
                ];

                $this->siteLogger->createLog($log);
            }
        } else {
            $response['code'] = 404;
            $response['message'] = 'Запис не знайдено';
        }

        return $response;
    }

    public function getItemComments(Request $request)
    {
        $response = [];

        if ( ! empty($request->id)) {
            $filter = [
                'tags' => ['entity' => 'order', 'id' => intval($request->id)],
                'type' => 'ORDER_COMMENT',
            ];
            if( ! empty($request->limit)) $filter['limit'] = $request->limit;
            if( ! empty($request->orderBy)) $filter['orderby'] = $request->orderBy;
            if( ! empty($request->sort)) $filter['dir'] = $request->sort;

            $list = (new SiteLogger)->getLogsList($filter);
            $data = [];

            if (! empty($list['data']['data'])) {
                foreach ($list['data']['data'] as $v){
                    $item = [
                        'title' => $v['title'],
                        'name' => $v['user_name'],
                        'date' => Carbon::parse($v['date'])->timezone(date_default_timezone_get())->format('d.m.Y H:i'),
                        'log' => [],
                    ];

                    if(! empty($v['log']['data'])) $item['log'] = $v['log']['data'];

                    $data[] = $item;
                }
            }

            $response['list'] = $data;
        }

        return $response;
    }

    public function addItemComment($id, $request)
    {
        $data = [];

        if(! empty($request->stage) && isset($request->stage)) {
            $data = [
                'old' => $request->stage['old']['title'],
                'new' => $request->stage['old']['title'],
            ];

            if(! empty($request->stage['new'])) {
                if(! $request->stage['new']['is_last']) {
                    $this->addEvent($id, $request);
                }

                $data['new'] = $request->stage['new']['title'];
            }
        }

        $log = [
            'title' => $request->comment,
            'action' => 'OrderService.addItemComment',
            'tags' => [['entity' => 'order', 'id' => intval($id)]],
            'type' => 'ORDER_COMMENT',
        ];
        if(! empty($request->client_id)) {
            $log['tags'][] = ['entity' => 'clients', 'id' => intval($request->client_id)];
        }
        if(! empty($data)) {
            $log['log']['data'] = $data;
        }

        $response = $this->siteLogger->createLog($log);

        if(! empty($response['data']['_id'])) {
            $response['data']['message'] = 'Коментар додано.';
        }

        $order = $this->model->findOrFail($id);
        CreateCommentOrder::dispatch($order);

        return $response;
    }

    public function addEvent($id, $request)
    {
        Event::where('order_id', '=', $id)
            ->update(['closed_at' => Carbon::now()->format('Y-m-d H:i')]);

        if(! empty($request->stage) && !$request->stage['new']['is_last']) {
            $create = [
                'user_id' => !empty($request->user_id) ? $request->user_id : \auth()->user()->id,
                'order_id' => $id,
                'title' => $request->comment,
                'remind_at' => $request->stage['date'] . ' ' . $request->stage['time'],
                'type' => Event::EVENT_TYPE_STAGE_CHANGED,
            ];
            if(! empty($request->client_id)) $create['client_id'] = $request->client_id;

            Event::create($create);
        }
    }

    //

    public function getDynprops(Request $request)
    {
        if(! empty($request->key)){
            switch ($request->key){
                case 'walls':  return $this->model->dp_walls;
                case 'floors': return $this->model->dp_floors;
                case 'rooms': return $this->model->dp_rooms;
                case 'repairs': return $this->model->dp_repairs;
                case 'build_types': return $this->model->dp_build_types;
                case 'categories': return $this->model->dp_categories;
                case 'adv_types': return $this->model->dp_adv_types;
                case 'stages': return (new Handbook)->getHandbook('stages')['data'];
                case 'period_types': return (new Event)->period_types;
            }
        }

        $dynprops = [
            'walls' => $this->model->dp_walls,
            'floors' => $this->model->dp_floors,
            'rooms' => $this->model->dp_rooms,
            'repairs' => $this->model->dp_repairs,
            'build_types' => $this->model->dp_build_types,
            'categories' => $this->model->dp_categories,
            'adv_types' => $this->model->dp_adv_types,
            'stages' => (new Handbook)->getHandbook('stages')['data'],
            'period_types' => (new Event)->period_types,
        ];

        if($request->withMyClients) {
            if(auth()->user()->hasRole('SuperAdmin')) {
                $dynprops['clients'] = Client::all()->toArray();
            } else {
                $dynprops['clients'] = Client::where('user_id', auth()->user()->id)->get()->toArray();
            }
        }

        return $dynprops;
    }

    static public function ordersListDashboard()
    {
        $stages = (new Handbook)->getHandbook('stages', (object)['all'=>true]) ?? [];
        $clients = Client::where('user_id', '=', auth()->user()->id)
            ->where(function ($query) {
                $query->where('status', '!=', ClientStatus::STATUS_ARCHIVE);
                $query->orWhereNull('status');
            })
            ->with('phoneNumbers')->get();
        $count = 0;
        $data = [];

        foreach ($stages as $stage) {
            if($stage['is_last']) continue;

            $stageData = [
                'title' => $stage['title'],
                'items' => [],
            ];

            foreach ($clients as $client) {
                $orders = Order::where([
                    ['client_id', '=', $client->id],
                    ['stage_id', '=', $stage['id']]
                ])->with('districts', 'rooms', 'floors')->get()->toArray();

                foreach ($orders as $v) {
                    $v['districts'] = collect($v['districts'])->pluck('id');
                    $v['rooms'] = collect($v['rooms'])->pluck('rooms');
                    $v['floors'] = collect($v['floors'])->pluck('floors');

                    $stageData['items'][] = array_merge($v, ['client'=>$client],
                        ['color'=>['color'=>$stage['color'],'white_text'=>$stage['white_text']]]);
                    $count += 1;
                }
            }

            $data[] = $stageData;
        }

        return ['data' => $data, 'count' => $count];
    }
}
