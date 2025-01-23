<?php
namespace App\Services\Telegram;

use App\Models\Event;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class TelegramService
{
    const TELEGRAM_WEBHOOK_URL = 'https://api.telegram.org/bot{TOKEN}/{METHOD}';

    private $url;

    public function __construct()
    {
        $this->url = strtr(self::TELEGRAM_WEBHOOK_URL, [
            '{TOKEN}' => config('telegram.token'),
        ]);
    }

    public function setWebhook(Request $request)
    {
        $data = Http::post(strtr($this->url, [
                '{METHOD}' => 'getWebhookInfo',
            ])
        );

        $data = json_decode((string)$data, true);

        if (empty($data['result']['url']) || !strlen($data['result']['url'])) {
            $data = Http::post(strtr($this->url, [
                '{METHOD}' => 'setWebhook?url=' . route('telegram-webhook'),
            ]));
        }

        return $data;
    }

    public function connect(Request $request)
    {
        return [
            'redirect' => 'https://t.me/'.config('telegram.username').'?start='.auth()->user()->id
        ];
    }

    public function disconnect(Request $request)
    {
        $user = User::where('id', auth()->user()->id)->first();
        $user->update(['telegram_id' => null]);

        return $user->refresh();
    }

    public function webhook(Request $request)
    {
        $data = $request->all();

        if(! empty($data['message'])) {
            $sendData = [];
            $telegram_id = $data['message']['chat']['id'];
            $user = User::where('telegram_id', '=', intval($telegram_id) )->first();
            $start = str_contains($data['message']['text'], '/start');

            if ($user) {
                $sendData['user_id'] = $user->id;
                $sendData['chat_id'] = $user->telegram_id;

                switch ($data['message']['text']) {
                    case 'Календар':
                        $sendData['parse_mode'] = 'html';
                        $sendData['text'] = "";
                        $events = Event::where('user_id', $user->id)->whereNull('closed_at')->orderBy('remind_at')->get();
                        if(count($events)) {
                            foreach ($events as $v) {
                                $sendData['text'] .= "<b>".Carbon::parse($v->remind_at)->format('d.m.Y H:i')."</b> ".$v->title.PHP_EOL;
                            }
                        } else {
                            $sendData['text'] .= 'Запланованих подій не знайдено';
                        }
                        break;
                    default:
                        $sendData['text'] = $start
                            ? 'Даний профіль Telegram вже підключений до іншого аккаунту!'
                            : 'Не відома команда';
                        break;
                }
            }
            else if($start) {
                $message = explode(' ', $data['message']['text']);

                if (! empty($message[1])) {
                    if ($user = User::findOrFail(intval($message[1]))) {
                        $user->update(['telegram_id' => $data['message']['chat']['id']]);

                        $sendData['chat_id'] = $data['message']['chat']['id'];
                        $sendData['text'] = 'Успішно підключилися!';

                        $markup = [
                            'keyboard' => [
                                [
                                    [
                                        'text' => 'Календар',
                                    ],
                                ],
                            ],
                            'resize_keyboard' => true,
                            'one_time_keyboard' => false,
                        ];
                        $sendData['reply_markup'] = json_encode($markup);
                    }
                }
            }

            $this->sendMessage($sendData);
        }
    }

    public function sendMessage($data = [])
    {
        if(! empty($data) && !empty($data['chat_id'])) {
            $url = strtr($this->url, [
                '{METHOD}'=> 'sendMessage',
            ]);

            if(! empty($data['user_id']) ) {
                unset($data['user_id']);

                $markup = [
                    'inline_keyboard' => [
                        [
                            [
                                'text' => 'Перейти на сайт',
                                'url' => config('app.external_url'),
                            ],
                        ],
                    ],
                ];
                $data['reply_markup'] = json_encode($markup);
            }

            Http::post($url, $data);
        }
    }
}
