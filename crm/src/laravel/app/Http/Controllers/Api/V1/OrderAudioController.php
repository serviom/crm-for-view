<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Offers\CreateOrderAudioRequest;
use App\Http\Requests\Offers\RemoveOrderAudioRequest;
use App\Services\Offers\OrderAudioService;
use App\Http\Resources\Offers\OrderAudioResource;

class OrderAudioController extends Controller
{
    protected $service;

    public function __construct(OrderAudioService $service)
    {
        $this->service = $service;
    }

    public function index($order_id)
    {
        $data = $this->service->getItems($order_id);

        return response()->json([
            'data' => OrderAudioResource::collection($data),
        ], 200);
    }

    public function store(CreateOrderAudioRequest $request)
    {
        $data = $this->service->createItem($request);

        return response()->json([
            'message' => 'Аудіо повідомлення успішно створене',
            'data' => new OrderAudioResource($data),
        ], 200);
    }

    public function remove(RemoveOrderAudioRequest $request)
    {
        $this->service->removeItem($request->route('id'));

        return response()->json([
            'message' => 'Аудіо повідомлення успішно видалине',
        ], 200);
    }

}
