<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Services\Telegram\TelegramService;
use Illuminate\Http\Request;

class TelegramController extends Controller
{
    private $service;

    public function __construct(TelegramService $service)
    {
        $this->service = $service;
    }

    public function setWebhook(Request $request)
    {
        $data = $this->service->setWebhook($request);

        return response()->json([
            'data' => $data,
        ], 200);
    }

    public function connect(Request $request)
    {
        $data = $this->service->connect($request);

        return response()->json([
            'data' => $data,
        ], 200);
    }

    public function disconnect(Request $request)
    {
        $data = $this->service->disconnect($request);

        return response()->json([
            'data' => $data,
        ], 200);
    }

    public function webhook(Request $request)
    {
        $this->service->webhook($request);

        return response()->json(true, 200);
    }

    public function sendMessage(Request $request)
    {
        $this->service->sendMessage($request);

        return response()->json(true, 200);
    }
}
