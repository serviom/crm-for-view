<?php

namespace App\Services\Offers;

use App\Events\CreateCommentOrder;
use App\Http\Requests\Offers\CreateOrderAudioRequest;
use App\Models\OrderAudio;
use App\Services\Microservices\SiteLogger;
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use InvalidArgumentException;

class OrderAudioService
{
    protected $model;
    private $fields;
    private $siteLogger;

    const AUDIO_PATH = 'audious';
    const TIMEPARTFORMAT = 'Y-m-d--H-i-s-u';

    public function __construct(OrderAudio $model)
    {
        $this->model = $model;
        $this->fields = $model->getFillable();
        $this->siteLogger = new SiteLogger;
    }

    static public function makePathAudio(string $audioFilename)
    {
        $audioPath = self::getPathForAudio(self::getFullTimeFromName($audioFilename)) . DIRECTORY_SEPARATOR . $audioFilename;
        return self::AUDIO_PATH . DIRECTORY_SEPARATOR . $audioPath;
    }

    static public function makeUrlPathAudio(string $audioFilename)
    {
        return Storage::url(self::makePathAudio($audioFilename));
    }

    public function getItems($order_id)
    {
        return  $this->model->where('order_id', $order_id)->withoutTrashed()->orderBy('id', 'desc')->get();
    }

    public function removeItem($itemId)
    {
        $orderAudio = $this->model->where('id', $itemId)->first();

        $log = [
            'title' => 'Видалили audio',
            'action' => 'OrderAudioService.removeItem',
            'type' => 'ORDER_REMOVE_AUDIO',
            'tags' => [
                ['entity' => 'audio', 'id' => $itemId],
                ['entity' => 'order', 'id' => intval($orderAudio->order_id)],
                ['entity' => 'clients', 'id' => intval($orderAudio->order->client->id)],
                ['entity' => 'users', 'id' => intval(Auth::user()->id)]
            ]
        ];

        $this->siteLogger->createLog($log);

        $orderAudio->delete();
    }

    public function createItem(CreateOrderAudioRequest $request)
    {
        if (!$request->hasFile('source')) {
            throw new InvalidArgumentException('Не вказаний файл.');
        }

        $user = Auth::user();
        $fields = $request->only($this->fields);
        $parTimeName = $this->generatePartTimeName();
        $extension = $request->file('source')->getClientOriginalExtension();
        $filename = $this->makeFileName($request->order_id, $parTimeName, $extension);
        $request->file('source')->storeAs(self::AUDIO_PATH . DIRECTORY_SEPARATOR . self::getPathForAudio($parTimeName), $filename);
        $fields['filename'] = $filename;
        $fields['user_id'] = $user->id;
        $item = $this->model->create($fields);

        $log = [
            'title' => 'Завантажено аудіо',
            'action' => 'OrderAudioService.createItem',
            'type' => 'ORDER_COMMENT',
            'tags' => [
                ['entity' => 'order', 'id' => intval($item->order_id)],
                ['entity' => 'clients', 'id' => intval($request->client_id)],
                ['entity' => 'users', 'id' => intval(Auth::user()->id)]
            ]
        ];

        $this->siteLogger->createLog($log);

        CreateCommentOrder::dispatch($item->order);

        return $item;
    }


    /**
     * @return array
     */

    static private function getFullTimeFromName(string $filename): string
    {
        $parts = explode('__', $filename);
        return isset($parts[0]) ? $parts[0] : '';
    }

    function getFileExtension()
    {
        $fileInfo = pathinfo($this->model->filename);
        return isset($fileInfo['extension']) ? $fileInfo['extension'] : '';
    }


    static public function getPathForAudio($fullTime): string
    {
        $dateTime = DateTime::createFromFormat(self::TIMEPARTFORMAT, $fullTime);
        if (!$dateTime) {
            throw new InvalidArgumentException('Невірний формат дати та часу. $fullTime = ' . $fullTime);
        }

        $year = $dateTime->format('Y');
        $month = $dateTime->format('m');
        $day = $dateTime->format('d');

        return  $year . DIRECTORY_SEPARATOR . $month . DIRECTORY_SEPARATOR . $day;
    }

    public function generatePartTimeName(): string
    {
        return now()->format(self::TIMEPARTFORMAT);
    }

    public function makeFileName(string $orderId, string $parTimeName, string $extension): string
    {
        return $parTimeName . '__' . $orderId . '.' . $extension;
    }

}
