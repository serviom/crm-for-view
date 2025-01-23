<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Orders\OrderCreateRequest;
use App\Http\Requests\Orders\OrderRequest;
use App\Http\Requests\Orders\OrdersListRequest;
use App\Http\Requests\Orders\OrderUpdateRequest;
use App\Http\Resources\Orders\OrderResource;
use App\Services\Orders\OrderService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    protected $service;

    public function __construct(OrderService $service)
    {
        $this->service = $service;
    }

    public function index(OrdersListRequest $request)
    {
        $data = $this->service->getList($request);

        return response()->json([
            'list' => OrderResource::collection($data['list']),
            'total' => $data['total'],
        ], $data['code']);
    }

    public function show(OrderRequest $request, $id)
    {
        $data = $this->service->getItem($id);

        return new OrderResource($data);
    }

    public function save(OrderCreateRequest $request)
    {
        $data = $this->service->saveItem($request);

        return response()->json($data, $data['code']);
    }

    public function cancel(OrderUpdateRequest $request)
    {
        $data = $this->service->cancelItem($request);

        return response()->json($data, $data['code']);
    }

    public function remove($id)
    {
        $data = $this->service->removeItem($id);

        return response()->json($data, $data['code']);
    }

    public function addOrderComment($id, Request $request)
    {
        $data = $this->service->addItemComment($id, $request);

        return response()->json($data['data'], $data['statusCode']);
    }

    public function comments(Request $request)
    {
        $data = $this->service->getItemComments($request);

        return response()->json($data);
    }

    public function dynprops(Request $request)
    {
        $data = $this->service->getDynprops($request);

        return response()->json($data);
    }
}
