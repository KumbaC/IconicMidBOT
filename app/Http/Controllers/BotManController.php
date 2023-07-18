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

      /*   $botman->hears('start|/start', function (BotMan $bot) {
            $bot->startConversation(new QuizConversation());
        })->stopsConversation(); */


      /*   $botman->hears('login', function (BotMan $bot) {   //Logueo con el bot de telegram
            $bot->startConversation(new RegisterConversation());
        });

        $botman->hears('register', function (BotMan $bot) {  // Registrar usuario con el bot de telegram
            $bot->startConversation(new RegisterConversation());
        }); */



       /*  $botman->hears('in|/in', function (BotMan $bot) {  //Primera entrada a la empresa
            $bot->startConversation(new RegisterConversation());
        })->stopsConversation();

        $botman->hears('/out|out', function (BotMan $bot) {  //Salida de la empresa
            $bot->startConversation(new HighscoreConversation());
        })->stopsConversation();

        $botman->hears('/break|break', function (BotMan $bot) {  //Descanso de 15 minutos
            $bot->reply('This is a BotMan and Laravel 8 project by Ejimadu Prevail.');
        })->stopsConversation();

        $botman->hears('/lunch|lunch', function (BotMan $bot) {  //Descanso para comer
            $bot->reply('This is a BotMan and Laravel 8 project by Ejimadu Prevail.');
        })->stopsConversation();

        $botman->hears('/back|back', function (BotMan $bot) {  //Regreso de break o lunch.
            $bot->reply('This is a BotMan and Laravel 8 project by Ejimadu Prevail.');
        })->stopsConversation();

        $botman->hears('/deletedata|deletedata', function (BotMan $bot) {
            $bot->startConversation(new PrivacyConversation());
        })->stopsConversation(); */

        $botman->hears('/hola|hola', function (BotMan $bot) {
            $bot->reply('Hola mamaguevo');
        })->stopsConversation();

        // $botman->fallback(function ($bot) {
        //     $bot->reply("Sorry, I am just a Laravel quiz bot. Type 'start' or click on '/start to begin. See menu for other commands");
        // });

        $botman->listen();
    }
}
