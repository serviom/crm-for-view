<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Clients\ClientRequest;
use App\Http\Requests\Clients\CreateClientsRequest;
use App\Http\Requests\Clients\GetClientsRequest;
use App\Http\Requests\Clients\UpdateClientsRequest;
use App\Http\Resources\Clients\AllClientsResource;
use App\Http\Resources\Clients\AllEventsResource;
use App\Http\Resources\Clients\AllUsersResource;
use App\Http\Resources\Clients\ClientResource;
use App\Models\Client;
use App\Models\Event;
use App\Models\User;
use App\Services\Clients\ClientsService;
use App\Services\Microservices\SiteLogger;
use App\Services\Orders\OrderService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ClientsController extends Controller
{
    protected $clientsService;

    public function __construct( ClientsService $clientsService)
    {
        $this->clientsService = $clientsService;
    }

    public function index(GetClientsRequest $request)
    {
        if(auth()->user()->hasRole('SuperAdmin')
        || auth()->user()->hasPermissionTo('clients.viewAny')
        || auth()->user()->hasPermissionTo('clients.viewMyOnly')
        ) {
            $filter = $request;
            if(
                auth()->user()->hasPermissionTo('clients.viewMyOnly') &&
                empty($filter['filterUser'])
            ){
                $filter['filterUser'] = auth()->user()->id;
            }
            if(! empty($filter['free'])) {
                $filter['filterUser'] = '-';
            }
            if(! empty($filter['archive'])) {
                $filter['filterUser'] = '-';
            }

            $result = $this->clientsService->getItems($filter);

            return response()->json([
                'data' => ClientResource::collection($result['data']),
                'count' => $result['count'],
            ], 200);
        }

        abort(403);
    }

    public function show(ClientRequest $request, $clientId)
    {
        $this->authorize('view', $this->clientsService->getItem($clientId));

        $data = $this->clientsService->getItem($clientId);

        return new ClientResource($data);
    }

    public function store(CreateClientsRequest $request)
    {
        $this->authorize('create', Client::class);

        $data = $this->clientsService->createItem($request);

        $message = 'Клієнт успішно створений';

        if(! empty($request->order) && isset($request->order)) {
            $saveData = [
                'client_id' => $data->id,
                'fields' => array_merge($request->order, ['client_id'=>$data->id])
            ];
            (new OrderService)->saveItem((object)$saveData);
            $message = 'Клієнт та угода успішно створені';
        }

        return response()->json([
            'message' => $message,
            'data' => new ClientResource($data),
        ], 200);
    }

    public function update(UpdateClientsRequest $request, $clientId)
    {
        $this->authorize('update', $this->clientsService->getItem($clientId));

        $data = $this->clientsService->updateItem($clientId, $request);

        return response()->json([
            'message' => 'Клієнт успішно оновлений',
            'data' => new ClientResource($data),
        ], 200);
    }

    public function destroy($clientId)
    {
        $this->authorize('delete', $this->clientsService->getItem($clientId));

        $data = $this->clientsService->deleteItem($clientId);

        return response()->json([
            'message' => 'Клієнт успішно видалений',
            'data' => $data,
        ], 200);
    }

    public function allUsersList(Request $request)
    {
        $this->authorize('viewAny', User::class);
        $result = User::all();

        return response()->json([
            'data' => AllUsersResource::collection($result),
        ], 200);
    }

    public function allEventsList(Request $request)
    {
        //$this->authorize('viewAny', User::class);

        $events = Event::select('events.title','events.user_id','clients.fio','events.id')->where('remind_at', '<', Carbon::now())
            ->join('clients', 'events.client_id', '=', 'clients.id')
            ->whereNull('closed_at')
            ->get();

        return response()->json([
            'data' => AllEventsResource::collection($events),
        ], 200);
    }

    public function allClientsList(Request $request)
    {
        $this->authorize('viewAny', Client::class);

        $result = Client::when($request->user_id, function ($query) use ($request) {
            $query->where('user_id', $request->user_id);
        })->get();

        return response()->json([
            'data' => AllClientsResource::collection($result),
        ], 200);
    }

    public function getLogList(Request $request, SiteLogger $logger)
    {
        $response = [
            'code' => 200,
            'message' => 'Лог лист пустий',
        ];

        if ( ! empty($request->client_id)) {
            $filter = [
                'tags' => ['entity' => 'clients', 'id' => $request->client_id]
            ];
            if( ! empty($request->limit)) $filter['limit'] = $request->limit;
            if( ! empty($request->orderBy)) $filter['orderby'] = $request->orderBy;
            if( ! empty($request->sort)) $filter['dir'] = $request->sort;

            $list = $logger->getLogsList($filter);

            $response['list'] = (! empty($list['data']['total']) && $list['data']['total']) ? $list['data']['data'] : [];
            $response['message'] = '';
        }

        return $response;
    }

    public function comments(Request $request)
    {
        return $this->clientsService->comments($request);
    }

    public function addComment($id, Request $request)
    {
        $data = $this->clientsService->addComment($id, $request);
        return response()->json($data['data'], $data['statusCode']);
    }

    public function checkPhoneNumber(Request $request)
    {
        return $this->clientsService->checkPhoneNumber($request);
    }
}
