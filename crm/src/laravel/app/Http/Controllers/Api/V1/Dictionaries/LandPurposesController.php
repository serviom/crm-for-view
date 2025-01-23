<?php

namespace App\Http\Controllers\Api\V1\Dictionaries;

use App\Http\Controllers\Controller;
use App\Http\Requests\LandPurposes\CreateLandPurposeRequest;
use App\Http\Requests\LandPurposes\GetLandPurposesRequest;
use App\Http\Requests\LandPurposes\LandPurposesRequest;
use App\Http\Requests\LandPurposes\UpdateLandPurposeRequest;
use App\Http\Resources\LandPurpose\LandPurposeResource;
use App\Models\LandPurpose;
use App\Services\LandPurposes\LandPurposesService;

class LandPurposesController extends Controller
{
    protected $landPurposesService;

    public function __construct( LandPurposesService $landPurposesService)
    {
        $this->landPurposesService = $landPurposesService;
    }

    public function index(GetLandPurposesRequest $request)
    {
        $this->authorize('viewAny', LandPurpose::class);

        $result = $this->landPurposesService->getItems($request);

        return response()->json([
            'data' => LandPurposeResource::collection($result['data']),
            'count' => $result['count'],
        ], 200);
    }

    public function show(LandPurposesRequest $request, $landPurposesId)
    {
        $this->authorize('view', $this->landPurposesService->getItem($landPurposesId));

        $data = $this->landPurposesService->getItem($landPurposesId);

        return new LandPurposeResource($data);
    }

    public function store(CreateLandPurposeRequest $request)
    {
        $this->authorize('create', LandPurpose::class);

        $data = $this->landPurposesService->createItem($request);

        return response()->json([
            'message' => 'Цільове призначення успішно створено',
            'data' => new LandPurposeResource($data),
        ], 200);
    }

    public function update(UpdateLandPurposeRequest $request, $landPurposesId)
    {
        $this->authorize('update', $this->landPurposesService->getItem($landPurposesId));

        $data = $this->landPurposesService->updateItem($landPurposesId, $request);

        return response()->json([
            'message' => 'Цільове призначення успішно оновлено',
            'data' => new LandPurposeResource($data),
        ], 200);
    }

    public function destroy(LandPurposesRequest $request, $landPurposesId)
    {
        $this->authorize('delete', $this->landPurposesService->getItem($landPurposesId));

        $data = $this->landPurposesService->deleteItem($landPurposesId);

        return response()->json([
            'message' => 'Цільове призначення успішно видалене',
            'data' => $data,
        ], 200);
    }
}
