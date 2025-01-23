<?php
namespace App\Services\Users;

use App\Models\Client;
use App\Models\Event;
use App\Models\SeniorAgent;
use App\Models\User;
use App\Models\Order;
use App\Services\Microservices\SiteLogger;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;

class UsersService
{
    private $fields;
    private $siteLogger;

    const AVATAR_PATH = 'images/avatars';

    public function __construct(User $model)
    {
        $this->fields = $model->getFillable();
        $this->siteLogger = new SiteLogger;
    }

    static public function makePathAvatar(string $avatar)
    {
        return self::AVATAR_PATH . DIRECTORY_SEPARATOR . $avatar;
    }

    static public function makeUrlPathAvatar(string $avatar)
    {
        if (!$avatar) {
            return '';
        }
        return Storage::url(self::makePathAvatar($avatar));
    }

    public function getItems($request)
    {

        $query = User::with('clients')
            ->when($request->role, function ($query) use ($request) {
                $query->whereHas('roles', function ($query) use ($request) {
                    $query->where('name', $request->role);
                });
                if($request->userId) {
                    $query->where('id', '!=', $request->userId);
                }
            })
            ->when($request->senior_agent_id, function ($query) use ($request) {
                $ids = SeniorAgent::where('senior_agent_id', $request->senior_agent_id)->pluck('user_id');
                $query->whereIn('id', $ids);
            })
            ->when($request->filterSearch, function ($query) use ($request) {
                $query->where('name', 'ilike', "%". $request->filterSearch . "%")
                    ->orWhere('email', 'ilike', "%". $request->filterSearch . "%")
                    ->orWhere('phoneNumber', 'ilike', "%". $request->filterSearch . "%");
            })
            ->when(isset($request->sortBy) && isset($request->sortDesc), function ($query) use ($request) {
                if ($request->sortBy !== "user") {
                    $query->orderBy($request->sortBy, $request->sortDesc ? 'desc' : 'asc');
                } else {
                    $query->orderBy(User::select('name')
                        ->whereColumn('users.id', 'clients.user_id'),
                        $request->sortDesc ? 'desc' : 'asc'
                    );
                }
            })
            ->when(!isset($request->sortBy) || !isset($request->sortDesc), function ($query) use ($request) {
                $query->orderBy('name', 'asc');
            });
        $count = $query->count();
        $data = $query
            ->when($request->page && $request->itemsPerPage, function ($query) use ($request) {
                $query
                    ->skip( ($request->page - 1) * $request->itemsPerPage)
                    ->take($request->itemsPerPage);
            })
            ->get();

        foreach ($data as &$v) {
            $v->events_count = 0;
            $v->clients_count = count($v->clients);
            foreach ($v->clients as $vv) {
                $v->events_count += $vv->events->count();
            }
        }

        return [
            'data' => $data,
            'count' => $count,
        ];
    }

    public function createItem($request)
    {
        $user = User::query()->create($request->only($this->fields));
        $user->syncRoles([$request->roleName]);

        if($user->id){
            if(! empty($request['seniorIds'])){
                if($user->hasRole('SeniorAgent')) {
                    foreach ($request['seniorIds'] as $v) {
                        SeniorAgent::create(['senior_agent_id' => $user->id, 'user_id' => $v]);
                    }
                } else {
                    SeniorAgent::create(['senior_agent_id' => $request['seniorIds'], 'user_id' => $user->id]);
                }
            }

            $log = [
                'title' => 'Створено користувача',
                'action' => 'UsersService.createItem',
                'user_id' => $user->id,
                'user_name' => $user->name,
                'ip' => request()->getClientIp(),
                'type' => 'INFO',
            ];

            $this->siteLogger->createLog($log);
        }

        return $user->refresh();
    }

    public function restoreUser($id)
    {
        if (! empty($id) && $id === 1) return false;

        $user = User::withTrashed()->find($id);

        if (!auth()->user()->hasRole('SuperAdmin')) {
            abort(403);
        }

        $log = [
            'title' => 'Відновлено користувача',
            'action' => 'UsersService.restoreUser',
            'user_id' => $user->id,
            'user_name' => $user->name,
            'ip' => request()->getClientIp(),
            'type' => 'INFO',
            'log' => json_encode([]),
        ];
        $this->siteLogger->createLog($log);

        return $user->restore();
    }

    public function updateItem($id, $request)
    {
        if (! empty($id) && $id === 1) return false;

        $user = User::withTrashed()->find($id);

        if(! isset($user->id)) return false;

        $logData = $user->only($this->fields);
        unset($logData['password']);

        if(! empty($request['roleName'])){
            $user->syncRoles([$request['roleName']]);
            $logData['roleName'] = $request['roleName'];
        }

        $this->seniorDataClear($id);

        if(! empty($request['seniorIds'])){
            if($user->hasRole('SeniorAgent')) {
                $this->seniorDataClear($request['seniorIds']);

                foreach ($request['seniorIds'] as $v) {
                    SeniorAgent::create(['senior_agent_id' => $id, 'user_id' => $v]);
                }
            } else {
                SeniorAgent::create(['senior_agent_id' => $request['seniorIds'], 'user_id' => $id]);
            }
        }

        $log = [
            'title' => 'Оновлено дані користувача',
            'action' => 'UsersService.updateItem',
            'user_id' => $user->id,
            'user_name' => $user->name,
            'ip' => request()->getClientIp(),
            'type' => 'INFO',
            'log' => json_encode($logData),
        ];
        $this->siteLogger->createLog($log);

        $user->update($request->only($this->fields));

        return $user->refresh();
    }

    private function seniorDataClear($ids) {
        if(!is_array($ids)) {
            $ids = [$ids];
        }
        foreach ($ids as $id) {
            SeniorAgent::where('senior_agent_id', $id)->delete();
            SeniorAgent::where('user_id', $id)->delete();
        }
    }

    public function getItem($id)
    {
        return User::withTrashed()->with('roles', 'subAgents', 'seniorAgent')->find($id);
    }

    public function deleteItem($id, $request)
    {
        $user = User::find($id);
        if(! isset($user)) return false;

        if(! empty($request->user_id)) {
            Client::where('user_id', $id)->update(['user_id'=>$request->user_id]);
            Event::where('user_id', $id)->update(['user_id'=>$request->user_id]);
        }

        if ($id != 1) {
            return $user->delete();
        }

        return false;
    }

    public function getAllRolesList() {
        return Role::orderBy('name', 'asc')->get();
    }

    public function getLogList($user_id)
    {
        $response = [
            'code' => 200,
            'message' => 'Лог лист пустий',
        ];

        if ( ! empty($user_id)) {
            $filter = [
                'user_id' => $user_id,
                'limit' => 1000
            ];

            $data = $this->siteLogger->getLogsList($filter);
            $list = [];

            if(! empty($data['data']['total']) && $data['data']['total']) {
                foreach ($data['data']['data'] as $v) {

                    $item = [
                        'title' => $v['title'],
                        'date' => Carbon::parse($v['date'])->format('d.m.Y H:i'),
                        'order_id' => 0,
                        'client_id' => 0,
                        'log' => $v['log']['data'] ?? null
                    ];

                    $tags = !empty($v['tags']) && is_array($v['tags']) ? array_column($v['tags'], 'entity') : [];

                    $tag = array_search('order', $tags);
                    if($tag !== false) {
                        $item['order_id'] = $v['tags'][$tag]['id'];
                    }

                    $tag = array_search('clients', $tags);
                    if($tag !== false) {
                        $item['client_id'] = $v['tags'][$tag]['id'];
                    } else if($item['order_id']) {
                        $order = Order::find($item['order_id']);

                        if(isset($order) && !empty(isset($order->client_id))) {
                            $item['client_id'] = $order->client_id;
                        }
                    }

                    if($item['client_id']) {
                        if(empty($list['clients'][$item['client_id']]['title'])) {
                            $clientData = Client::find($item['client_id']);
                            $list['clients'][$item['client_id']]['title'] = $clientData->fio ?? 'Видалений клієнт';
                            $list['clients'][$item['client_id']]['removed'] = empty($clientData->fio);
                        }

                        if($item['order_id']) {
                            if(empty($list['clients'][$item['client_id']]['logs'][$item['order_id']]['title'])) {
                                $orderData = Order::find($item['order_id']);
                                $list['clients'][$item['client_id']]['logs'][$item['order_id']]['title'] = isset($orderData)
                                    ? $orderData->category .' / '.$orderData->adv_type
                                    : 'Видалена угода';
                                $list['clients'][$item['client_id']]['logs'][$item['order_id']]['removed'] = ! isset($orderData);
                            }
                            $list['clients'][$item['client_id']]['logs'][$item['order_id']]['logs'][] = $item;
                        } else {
                            $list['clients'][$item['client_id']]['logs'][] = $item;
                        }
                    } else if($item['order_id']) {
                        if(empty($list['orders'][$item['order_id']]['title'])) {
                            $orderData = Order::find($item['order_id']);
                            $list['orders'][$item['order_id']]['title'] = isset($orderData)
                                ? $orderData->category .' / '.$orderData->adv_type
                                : 'Видалена угода';
                            $list['orders'][$item['order_id']]['removed'] = ! isset($orderData);
                        }
                        $list['orders'][$item['order_id']]['logs'][] = $item;
                    } else {
                        $list['logs'] = $item;
                    }
                }
            }

            foreach ($list as &$v) {
                $v = $this->arrayValues($v);
            } unset($v);

            $response['list'] = $this->arrayValues($list);
        }

        return $response;
    }

    public function arrayValues($array) {
        foreach ($array as &$v) {
            if(!empty($v['logs'])) {
                $v['logs'] = $this->arrayValues($v['logs']);
            }
        } unset($v);

        return !empty($array['title']) ? $array : array_values($array);
    }
}
