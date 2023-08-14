<?php

namespace App\Http\Controllers;

use BotMan\BotMan\BotMan;
use App\Conversations\QuizConversation;
use App\Conversations\PrivacyConversation;
use App\Conversations\HighscoreConversation;
use App\Conversations\LoginConversation;
use App\Conversations\RegisterConversation;
use App\Http\Middleware\PreventDoubleClicks;
use BotMan\BotMan\BotManFactory;
use BotMan\BotMan\Cache\LaravelCache;
use BotMan\BotMan\Drivers\DriverManager;



class BotManController extends Controller
{
    /**
     * Place your BotMan logic here.
     */
    public function handle()
    {
        DriverManager::loadDriver(\BotMan\Drivers\Telegram\TelegramDriver::class);

        // $botman = app('botman');

        // $config = [
        // 'telegram' => [
        //     'token' => config('botman.telegram.token'),
        // ]
        // ];
        $config = [
            'user_cache_time' => 720,

            'config' => [
                'conversation_cache_time' => 720,
            ],

            // Your driver-specific configuration
            "telegram" => [
                "token" => env('TELEGRAM_TOKEN'),
            ]
        ];


        $botman = BotManFactory::create($config, new LaravelCache());

        $botman->middleware->captured(new PreventDoubleClicks);



        $botman->hears('start|/start', function (BotMan $bot) {  //Primera entrada a la empresa
            $bot->startConversation(new RegisterConversation());
        })->stopsConversation();



        $botman->hears('/hola|hola', function (BotMan $bot) {
            $bot->reply('👋 Hola bienvenido al bot de Iconic Mind. Para comenzar escribe /start si necesitas ayuda escribe /help');
        })->stopsConversation();

        $botman->hears('/help|help', function (BotMan $bot) {
            $bot->reply('¿En que puedo ayudarte?, recuerda que para comenzar escribe /start en caso de que no estes registrado, habla con tu supervisor. 👔');
        })->stopsConversation();

        $botman->hears('/commands|commands', function (BotMan $bot) {
            $bot->reply('Comandos disponibles: /start, /help, /hola, /commands');
        })->stopsConversation();






        $botman->listen();
    }
}
