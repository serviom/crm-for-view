<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Offers\UpdateOfferRequest;
use App\Services\Offers\OfferService;
use App\Http\Requests\Offers\CreateOfferRequest;
use App\Http\Resources\Offers\OfferResource;

class OffersController extends Controller
{
    protected $service;

    public function __construct(OfferService $service)
    {
        $this->service = $service;
    }

    public function index($order_id)
    {
        $data = $this->service->getItems($order_id);

        return response()->json([
            'data' => OfferResource::collection($data),
        ], 200);
    }

    public function store(CreateOfferRequest $request)
    {
        $data = $this->service->createItem($request);

        return response()->json([
            'message' => 'Варіант успішно створений',
            'data' => new OfferResource($data),
        ], 200);
    }

    public function update(UpdateOfferRequest $request)
    {
        $data = $this->service->updateItem($request);

        return response()->json([
            'message' => 'Варіант успішно оновлений',
            'data' => new OfferResource($data),
        ], 200);
    }
}
