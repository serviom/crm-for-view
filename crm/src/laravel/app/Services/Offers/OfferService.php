<?php
namespace App\Services\Offers;

use App\Events\CreateCommentOrder;
use App\Models\Event;
use App\Models\Order;
use App\Models\Offers;
use App\Services\Microservices\SiteLogger;
use Carbon\Carbon;
use DOMDocument;
use DOMXPath;
use Exception;

class OfferService
{
    protected $model;
    private $fields;
    private $siteLogger;

    public function __construct(Offers $model)
    {
        $this->model = $model;
        $this->fields = $model->getFillable();
        $this->siteLogger = new SiteLogger;
    }

    public function getItems($order_id)
    {
        $data = $this->model->where('order_id', $order_id)
            ->orderBy('archive', 'asc')->orderBy('order', 'desc')->orderBy('id', 'desc')->get();

        foreach ($data as &$v) {
            $v->created = Carbon::parse($v->created_at)->format('Y-m-d H:i');

            if($v->show_date)
                $v->show_date = Carbon::parse($v->show_date)->format('Y-m-d H:i');

            $linkData = $this->getLinkData($v->link);
            if(isset($linkData)) {
                $v->domain = $linkData['domain'];
                $v->img = $linkData['img'];
            }
        }

        return $data;
    }

    public function createItem($request)
    {
        $item = $this->model->create($request->only($this->fields));

        $linkData = $this->getLinkData($item->link, false);
        $item->domain = $linkData['domain'];

        $log = [
            'title' => 'Запропоновано варіант',
            'action' => 'OfferService.createItem',
            'type' => 'ORDER_COMMENT',
            'tags' => [
                ['entity' => 'order', 'id' => intval($item->order_id)],
                ['entity' => 'clients', 'id' => intval($request->client_id)]
            ],
            'log' => ['data' => $item]
        ];

        $this->siteLogger->createLog($log);

        CreateCommentOrder::dispatch($item->realstate);

        return $item;
    }

    public function updateItem($request)
    {
        $item = $this->model->findOrFail($request->id);

        if($item->show_date != $request->show_date) {
            $this->addEvents($request);
        }

        $item->update($request->only($this->fields));

        CreateCommentOrder::dispatch($item->realstate);

        return $item;
    }

    private function addEvents($request) {
        $order  = Order::where('id', $request->order_id)->with('rooms')->first();
        $rooms = collect($order->rooms)->pluck('rooms')->toArray();
        $title  = $order->adv_type . ', ' .
            $order->category . ' ' . (!empty($rooms) ? (implode(',', $rooms) . 'к') : '') . ', ' .
            'запланований показ ' . Carbon::parse($request->show_date)->format('d.m.Y H:i');

        for($i=0; $i<2; $i+=1) {
            $remind_at = $i ? Carbon::parse($request->show_date)->subDay() : Carbon::parse($request->show_date)->subHour();

            if(Carbon::now() > $remind_at) continue;

            Event::create([
                'user_id' => auth()->user()->id,
                'client_id' => $order->client_id,
                'order_id' => $request->order_id,
                'title' => $title,
                'remind_at' => $remind_at,
                'type' => Event::EVENT_TYPE_NOTIFY,
            ]);
        }
    }

    /**
     * @param string $link
     * @param bool $withImg
     * @return array
     */
    private function getLinkData(string $link, bool $withImg = true) :array
    {
        if(! empty($link)) {
            $temp = strtr($link, ['http://'=>'', 'https://'=>'', 'www.'=>'']);

            $data = [
                'domain' => explode('/', $temp)[0],
            ];

            if($withImg) {
                $data['img'] = null;

                if($img = $this->parser($link)) {
                    $data['img'] = $img;
                }
            }

            return $data;
        }

        return [];
    }

    private function parser($link, $expression = '//*[contains(@property, "og:image")]')
    {
        $img = null;

        if(! empty($link) && !empty($expression)) {
            $context = [
                'ssl' => [
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                ],
            ];

            try {
                $html = file_get_contents($link, false, stream_context_create($context));
                $dom = new DomDocument();

                libxml_use_internal_errors(true);
                $dom->loadHTML($html);
                libxml_use_internal_errors(false);

                $path = new DomXPath($dom);
                $nodes = $path->query($expression);

                if ($nodes->count()) {
                    $img = $nodes->item(0)->getAttribute('content');
                }
            } catch (Exception $e) {
//                \Log::debug($e->getMessage());
            }
        }

        return $img;
    }
}
