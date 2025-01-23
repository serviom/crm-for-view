<?php

namespace App\Http\Controllers\Api\V1\Dictionaries;

use App\Http\Controllers\Controller;
use App\Http\Requests\RoomPurposes\CreateRoomPurposesRequest;
use App\Http\Requests\RoomPurposes\GetRoomPurposesRequest;
use App\Http\Requests\RoomPurposes\RoomPurposesRequest;
use App\Http\Requests\RoomPurposes\UpdateRoomPurposesRequest;
use App\Http\Resources\RoomPurposes\RoomPurposeResource;
use App\Models\RoomPurpose;
use App\Services\RoomPurposes\RoomPurposesService;

class RoomPurposesController extends Controller
{
    protected $roomPurposesService;

    public function __construct( RoomPurposesService $roomPurposesService)
    {
        $this->roomPurposesService = $roomPurposesService;
    }

    public function index(GetRoomPurposesRequest $request)
    {
        $this->authorize('viewAny', RoomPurpose::class);

        $result = $this->roomPurposesService->getItems($request);

        return response()->json([
            'data' => RoomPurposeResource::collection($result['data']),
            'count' => $result['count'],
        ], 200);
    }

    public function show(RoomPurposesRequest $request, $roomPurposesId)
    {
        $this->authorize('view', $this->roomPurposesService->getItem($roomPurposesId));

        $data = $this->roomPurposesService->getItem($roomPurposesId);

        return new RoomPurposeResource($data);
    }

    public function store(CreateRoomPurposesRequest $request)
    {
        $this->authorize('create', RoomPurpose::class);

        $data = $this->roomPurposesService->createItem($request);

        return response()->json([
            'message' => 'Цільове призначення успішно створено',
            'data' => new RoomPurposeResource($data),
        ], 200);
    }

    public function update(UpdateRoomPurposesRequest $request, $roomPurposesId)
    {
        $this->authorize('update', $this->roomPurposesService->getItem($roomPurposesId));

        $data = $this->roomPurposesService->updateItem($roomPurposesId, $request);

        return response()->json([
            'message' => 'Цільове призначення успішно оновлено',
            'data' => new RoomPurposeResource($data),
        ], 200);
    }

    public function destroy(RoomPurposesRequest $request, $roomPurposesId)
    {
        $this->authorize('delete', $this->roomPurposesService->getItem($roomPurposesId));

        $data = $this->roomPurposesService->deleteItem($roomPurposesId);

        return response()->json([
            'message' => 'Цільове призначення успішно видалене',
            'data' => $data,
        ], 200);
    }
}

