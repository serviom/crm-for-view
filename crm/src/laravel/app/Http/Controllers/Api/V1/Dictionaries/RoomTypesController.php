<?php

namespace App\Http\Controllers\Api\V1\Dictionaries;

use App\Http\Controllers\Controller;
use App\Http\Requests\RoomTypes\CreateRoomTypesRequest;
use App\Http\Requests\RoomTypes\GetRoomTypesRequest;
use App\Http\Requests\RoomTypes\RoomTypesRequest;
use App\Http\Requests\RoomTypes\UpdateRoomTypesRequest;
use App\Http\Resources\RoomTypes\RoomTypeResource;
use App\Services\RoomTypes\RoomTypesService;

class RoomTypesController extends Controller
{
    protected $roomTypesService;

    public function __construct( RoomTypesService $roomTypesService)
    {
        $this->roomTypesService = $roomTypesService;
    }

    public function index(GetRoomTypesRequest $request)
    {
        $this->authorize('viewAny', RoomType::class);

        $result = $this->roomTypesService->getItems($request);

        return response()->json([
            'data' => RoomTypeResource::collection($result['data']),
            'count' => $result['count'],
        ], 200);
    }

    public function show(RoomTypesRequest $request, $roomTypesId)
    {
        $this->authorize('view', $this->roomTypesService->getItem($roomTypesId));

        $data = $this->roomTypesService->getItem($roomTypesId);

        return new RoomTypeResource($data);
    }

    public function store(CreateRoomTypesRequest $request)
    {
        $this->authorize('create', RoomType::class);

        $data = $this->roomTypesService->createItem($request);

        return response()->json([
            'message' => 'Тип приміщення успішно створено',
            'data' => new RoomTypeResource($data),
        ], 200);
    }

    public function update(UpdateRoomTypesRequest $request, $roomTypesId)
    {
        $this->authorize('update', $this->roomTypesService->getItem($roomTypesId));

        $data = $this->roomTypesService->updateItem($roomTypesId, $request);

        return response()->json([
            'message' => 'Тип приміщення успішно оновлено',
            'data' => new RoomTypeResource($data),
        ], 200);
    }

    public function destroy(RoomTypesRequest $request, $roomTypesId)
    {
        $this->authorize('delete', $this->roomTypesService->getItem($roomTypesId));

        $data = $this->roomTypesService->deleteItem($roomTypesId);

        return response()->json([
            'message' => 'Тип приміщення успішно видалене',
            'data' => $data,
        ], 200);
    }
}
