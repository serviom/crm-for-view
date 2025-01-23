<?php

namespace App\Http\Controllers\Api\V1\Dictionaries;

use App\Http\Controllers\Controller;
use App\Http\Requests\LandOwnerships\CreateLandOwnershipsRequest;
use App\Http\Requests\LandOwnerships\GetLandOwnershipsRequest;
use App\Http\Requests\LandOwnerships\LandOwnershipsRequest;
use App\Http\Requests\LandOwnerships\UpdateLandOwnershipsRequest;
use App\Http\Resources\LandOwnerships\LandOwnershipResource;
use App\Models\LandOwnership;
use App\Services\LandOwnerships\LandOwnershipsService;

class LandOwnershipsController extends Controller
{
    protected $landOwnershipsService;

    public function __construct( LandOwnershipsService $landOwnershipsService)
    {
        $this->landOwnershipsService = $landOwnershipsService;
    }

    public function index(GetLandOwnershipsRequest $request)
    {
        $this->authorize('viewAny', LandOwnership::class);

        $result = $this->landOwnershipsService->getItems($request);

        return response()->json([
            'data' => LandOwnershipResource::collection($result['data']),
            'count' => $result['count'],
        ], 200);
    }

    public function show(LandOwnershipsRequest $request, $landOwnershipsId)
    {
        $this->authorize('view', $this->landOwnershipsService->getItem($landOwnershipsId));

        $data = $this->landOwnershipsService->getItem($landOwnershipsId);

        return new LandOwnershipResource($data);
    }

    public function store(CreateLandOwnershipsRequest $request)
    {
        $this->authorize('create', LandOwnership::class);

        $data = $this->landOwnershipsService->createItem($request);

        return response()->json([
            'message' => 'Запис успішно створено',
            'data' => new LandOwnershipResource($data),
        ], 200);
    }

    public function update(UpdateLandOwnershipsRequest $request, $landOwnershipsId)
    {
        $this->authorize('update', $this->landOwnershipsService->getItem($landOwnershipsId));

        $data = $this->landOwnershipsService->updateItem($landOwnershipsId, $request);

        return response()->json([
            'message' => 'Запис успішно оновлено',
            'data' => new LandOwnershipResource($data),
        ], 200);
    }

    public function destroy(LandOwnershipsRequest $request, $landOwnershipsId)
    {
        $this->authorize('delete', $this->landOwnershipsService->getItem($landOwnershipsId));

        $data = $this->landOwnershipsService->deleteItem($landOwnershipsId);

        return response()->json([
            'message' => 'Запис успішно видалено',
            'data' => $data,
        ], 200);
    }
}
