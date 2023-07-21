<?php

namespace App\Conversations;

use App\Models\User;
use App\Models\departure_time;
use App\Models\working_time;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Question;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

class RegisterConversation extends Conversation


{
    /**
     * Start the conversation.
     *
     * @return mixed
     *
     */

     public function run()
    {
        $this->start();

        //$this->register();
        //$this->saveUser();
        //$user = new User;
    }

    protected $userData = [];


    public function start()
    {
        $this->say('¡Hola! Soy el bot de IconicMind para autenticación y registro en Laravel.');

        $this->showMenu();
    }

    private function showMenu()
    {
        $question = Question::create('¿Qué deseas hacer?')
            ->fallback('Lo siento, no puedo ayudarte con eso')
            ->callbackId('menu')
            ->addButtons([
                Button::create('Registro')->value('register'),
                Button::create('Login')->value('login')
            ]);

        $this->ask($question, function (Answer $answer) {
            $res = $answer->getValue();
            switch ($res){
                case 'register':
                    return $this->register();
                    break;
                case 'login':
                    return $this->login();
                    break;
                default:
                    return $this->repeat('No puedo entenderte, ¿puedes intentarlo de nuevo?');
            }
        });
    }

    private function register()
    {
        $this->ask('Por favor, ingresa tu nombre completo', function (Answer $answer) {

            $this->userData['name'] = $answer->getText();

            $this->ask('Ahora, ingresa tu correo electrónico', function (Answer $answer) {

                $email = $answer->getText();

                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    return $this->repeat('El correo electrónico ingresado no es válido. Por favor, ingresa un correo electrónico válido.');
                }

                $this->userData['email'] = $email;

                $this->ask('Por último, ingresa tu contraseña', function (Answer $answer) {

                    $password = $answer->getText();

                    if (strlen($password) < 8) {
                        return $this->repeat('La contraseña debe tener al menos 8 caracteres. Por favor, ingresa una contraseña válida.');
                    }

                    $this->userData['password'] = bcrypt($password);

                    try {
                        $user = User::create($this->userData);

                        $this->say('Perfecto! Tu registro ha sido completado. 🎉');

                        $this->userData = [];

                        $this->showMenu();
                    } catch (\Exception $e) {
                        $this->say('Lo siento, ha ocurrido un error al intentar guardar tu registro. Por favor, intenta de nuevo más tarde.');
                    }
                });
            });
        });
    }

    private function showPostmenu()
    {
        $question = Question::create('¿Qué deseas hacer?')
        ->fallback('Lo siento, no puedo ayudarte con eso')
        ->callbackId('menu')
        ->addButtons([
            Button::create('In | Entrada')->value('in'),         //  Primera entrada del día.
            //Button::create('Break | ')->value('break'),  //  Descanso de 15 minutos. Los empleados Ɵenen 2 descansos diarios de 15 minutos obligatorios.
            //Button::create('Lunch')->value('lunch'), // Salida para comer.
            //Button::create('Back')->value('back'),  //  Regreso de break o lunch.
            Button::create('Out | Salida')->value('out')    // Salida de la oficina.
        ]);

    $this->ask($question, function (Answer $answer) {
        $res = $answer->getValue();
        switch ($res){
            case 'in':
                return $this->in();
                break;
            case 'out':
                return $this->login();
                break;
            default:
                return $this->repeat('No puedo entenderte, ¿puedes intentarlo de nuevo?');
        }
      });

    }

    private function login()
    {
        $this->say('🔒 INICIO DE SESIÓN 🔒');
        $this->bot->typesAndWaits(2);

        $this->ask('Por favor ingresa tu email:', function (Answer $answer) {
            $email = $answer->getText();

            // Validar el correo electrónico
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $this->say('El correo electrónico es inválido. ❌');
                $this->showMenu();
                return;
            }

            $this->ask('Por favor ingresa tu contraseña:', function (Answer $answer) use ($email) {
                $password = $answer->getText();

                // Validar la contraseña
                if (strlen($password) < 8) {
                    $this->say('La contraseña debe tener al menos 8 caracteres. ❌');
                    $this->showMenu();
                    return;
                }

                // Buscar al usuario en la base de datos y verificar sus credenciales
                $user = User::where('email', $email)->first();
                if ($user && password_verify($password, $user->password)) {
                    Auth::login($user);
                    session(['user_id' => $user->id]);
                    $user = auth()->user();
                    $nombre = $user->name;
                    $this->say('Bienvenido | Welcome ✅'. ' ' .  $nombre);
                    $this->showPostmenu();
                }

            });

         });
     }

    private function in()
    {
        Auth::login();
        // Obtener el usuario autenticado
       /*  $user_id = session('user_id');
        $user = User::find($user_id); */
        $user = auth()->user();

        //$id = $user->id;

        $this->say('🔒 ENTRADA AL TRABAJO 🔒');
        $this->say('La hora de ingreso y la fecha de ingreso registrada es ' .  Carbon::now());
        // Obtener la hora y fecha actual
        $now = Carbon::now();

        $date = $now->toDateString();
        $time = $now->toTimeString();

        // Guardar la entrada en la base de datos
        $entry = new working_time();
        $entry->user_id = $user->id;
        $entry->entry_date = $now;
        $entry->save();

        // Mostrar un mensaje al usuario
    /*     $this->say('La hora de ingreso y la fecha de ingreso registrada es ' . $now);
        $this->say('¡Hola ' . $user->name .  '!'); */

    }




}
