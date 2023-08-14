<?php

namespace App\Conversations;

use App\Models\User;
use App\Models\Position;
use App\Models\departure_time;
use App\Models\working_time;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Question;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use BotMan\BotMan\BotMan;
use Carbon\Carbon;
use BotMan\BotMan\Telegram\TelegramDriver;


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
        $this->say('¡Hola! Soy el bot de IconicMind para registrar tu trabajo .');

        $this->showMenu();
    }

    private function showMenu()
    {
        $question = Question::create('¿Qué deseas hacer?')
            ->fallback('Lo siento, no puedo ayudarte con eso')
            ->callbackId('menu')
            ->addButtons([
                //Button::create('Registro')->value('register'),
                Button::create('Login')->value('login')
            ]);

        $this->ask($question, function (Answer $answer) {
            $res = $answer->getValue();
            switch ($res){
                case 'login':
                    return $this->login();
                    break;
                default:
                    return $this->repeat('No puedo entenderte, ¿puedes intentarlo de nuevo?');
            }
        });
    }



   private function register($user)
    {
        $this->askForName($user);
    }

    private function askForName($user)
    {
        $this->ask('Por favor, ingresa el nombre completo', function (Answer $answer) use ($user) {
            $this->userData['name'] = $answer->getText();
            $this->askForEmail($user);
        });
    }

    private function askForEmail($user)
    {
        $this->ask('Ahora, ingresa el correo electrónico', function (Answer $answer) use ($user) {
            $email = $answer->getText();
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return $this->repeat('El correo electrónico ingresado no es válido. Por favor, ingresa un correo electrónico válido.');
            }
            $this->userData['email'] = $email;
            $this->askForRole($user);
        });
    }

    private function askForRole($user)
    {
        $question = Question::create('Roles')
            ->fallback('Lo siento, no puedo ayudarte con eso')
            ->callbackId('menu')
            ->addButtons([
                Button::create('Adminitrador')->value(1), //  Administrador
                Button::create('Usuario')->value(0), //  Administrador
            ]);

        $this->ask($question, function (Answer $answer) use ($user) {
            $this->userData['admin'] = $answer->getValue();
            $this->say('Hola' . $this->userData['admin']);
            $this->askForPosition($user);
        });
    }

    private function askForPosition($user)
    {
        $positions = Position::all();
        $buttons = [];
        foreach ($positions as $position) {
            $buttons[] = Button::create($position->name)->value($position->id);
        }

        $question = Question::create('Positions')
            ->fallback('Lo siento, no puedo ayudarte con eso')
            ->callbackId('menu')
            ->addButtons($buttons);

        $this->ask($question, function (Answer $answer) use ($user) {
            $this->userData['position_id'] = $answer->getValue();
            $this->say('Perfecto!' . $this->userData['position_id']);
            $this->askForPassword($user);
        });
    }

    private function askForPassword($user)
    {
        $this->ask('Por último, ingresa tu contraseña', function (Answer $answer) use  ($user) {
            $password = $answer->getText();
            if (strlen($password) < 8) {
                return $this->repeat('La contraseña debe tener al menos 8 caracteres. Por favor, ingresa una contraseña válida.');
            }
            $this->userData['password'] = bcrypt($password);
            $this->saveUser($user);
        });
    }

    private function saveUser($user)
    {
        //$this->say('Hola!' . $this->userData['position_id']);
        try {

            $usersr = new User();
            $usersr->name = $this->userData['name'];
            $usersr->email = $this->userData['email'];
            $usersr->position_id = $this->userData['position_id'];
            $usersr->admin = $this->userData['admin'];
            $usersr->password = $this->userData['password'];
            $usersr->save();

            $this->say('Perfecto! Tu registro ha sido completado. 🎉');
            $this->userData = [];
            $this->subMenu($user);
        } catch (\Exception $e) {
            $this->say('Lo siento, ha ocurrido un error al intentar guardar tu registro. Por favor, intenta de nuevo más tarde.');
            $this->subMenu($user);
        }

    }

    private function report($user)
    {
        $users = User::with('working')->get();
        $working = working_time::all();
        $this->say('📊 REPORTE DE TRABAJO Y PAGO 📊');

        $currentDay = Carbon::now()->day;
        $twoDaysAgo = Carbon::now()->subDays(2)->day;
        $yesterday = Carbon::now()->subDays(1)->day;


        foreach ($users as $use) {
            $firstPaymentDay = $use->position->first_payment;
            $secondPaymentDay = $use->position->second_payment;

            foreach ($use->working as $word){
            if ($this->isPaymentDay($currentDay, $twoDaysAgo, $yesterday, $firstPaymentDay) || $this->isPaymentDay($currentDay, $twoDaysAgo, $yesterday, $secondPaymentDay)) {
                $this->sayUserDetails($word);
            }
           }
        }

        $this->say('No hay mas reportes de pago');
        $this->subMenu($user);
    }

    private function isPaymentDay($currentDay, $twoDaysAgo, $yesterday, $paymentDay)
    {
        return in_array($currentDay, [$paymentDay, $paymentDay + 1, $paymentDay + 2]);
    }

    private function sayUserDetails($word)
    {

            $this->say('👤 ' . $word->user->name. ' 👤');
            $this->say('📅 ' . $word->entry_date . ' 📅');
            $this->say('🕐 ' . ($word->centry == 1 ? 'Entro a tiempo' : 'Entro tarde') . ' 🕐');
            $this->say('🕐 ' . 'Hora de almuerzo: ' . $word->lunch_time . ' 🕐');
            $this->say('🕐 ' . 'Hora de regreso del almuerzo: ' . $word->back_lunch . ' 🕐');

            if ($word->break == 1) {
                $this->say('🕐 ' . 'Primer de descanso: ' . $word->break_time . ' 🕐');
                $this->say('🕐 ' . 'Hora de regreso del descanso: ' . $word->back_break . ' 🕐');
            } else {
                $this->say('🕐 ' . 'Hora de descanso: ' . 'No tomó descanso' . ' 🕐');
            }

            if ($word->break_two == 1) {
                $this->say('🕐 ' . 'Segundo descanso: ' . $word->time_break_two . ' 🕐');
                $this->say('🕐 ' . 'Hora de regreso del descanso: ' . $word->back_break_two . ' 🕐');
            } else {
                $this->say('🕐 ' . 'Hora de descanso: ' . 'No tomó descanso' . ' 🕐');
            }

            if ($word->out == null) {
                $this->say('🕐 ' . 'Hora de salida: ' . 'No ha salido' . ' 🕐');
            } else {
                $this->say('🕐 ' . 'Hora de salida: ' . $word->out . ' 🕐');
            }

            $this->say($word->cout == 1 ? '🕐 Salio a tiempo 🕐' : '❌ Salio tarde ❌');

    }





    public function login()
    {
        $this->say('🔒 INICIO DE SESIÓN 🔒');
        $this->bot->typesAndWaits(1);

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

                if (Auth::attempt(['email' => $email, 'password' => $password])) {
                    $nombre = auth()->user()->name;
                    $user = auth()->user();
                    $this->say('Bienvenido | Welcome ✅'. ' ' .  $nombre);
                    $this->subMenu($user);


                } else {
                    $this->say('Las credenciales son inválidas. ❌');
                    $this->showMenu();
                }

            });

         });
     }

     private function subMenu($user)
     {
        if($user->admin == 1){
            $question = Question::create('¿Qué deseas hacer?')

            ->fallback('Lo siento, no puedo ayudarte con eso')
            ->callbackId('menu')
            ->addButtons([
                Button::create('Payment report | Reporte de pago')->value('report'),
                Button::create('Register user | Registrar usuario')->value('register'),
                Button::create('In | Entrada')->value('in'), //  Primera entrada del día.
            ]);

            $this->ask($question, function (Answer $answer) use ($user) {
                $res = $answer->getValue();
                switch ($res){
                    case 'report':
                        return $this->report($user);
                    break;

                    case 'register':
                        return $this->register($user);
                    break;

                    case 'in':
                         return $this->in($user);

                        break;
                    default:
                        return $this->repeat('No puedo entenderte, ¿puedes intentarlo de nuevo?');
                }
              });
            }else{
                $question = Question::create('¿Qué deseas hacer?')

                ->fallback('Lo siento, no puedo ayudarte con eso')
                ->callbackId('menu')
                ->addButtons([
                    Button::create('In | Entrada')->value('in'), //  Primera entrada del día.
                ]);

                $this->ask($question, function (Answer $answer) use ($user) {
                    $res = $answer->getValue();
                    switch ($res){
                        case 'in':

                                $this->say('¡Bienvenido al trabajo, ' . $user->name . '!');

                                $working = new working_time();
                                $working->user_id = $user->id;
                                $working->entry_date = Carbon::now()->format('y/m/d H:i:s');
                                $working->save();
                                $id_working = $working->id;
                                $this->say('Entrada al trabajo registrada con éxito. ✅');

                                $this->showPostmenu($user, $id_working);

                            break;
                        default:
                            return $this->repeat('No puedo entenderte, ¿puedes intentarlo de nuevo?');
                    }
                  });
                }

      }

    private function showPostmenu($user, $id_working)
    {


        $question = Question::create('¿Qué deseas hacer?')
        ->fallback('Lo siento, no puedo ayudarte con eso')
        ->callbackId('menu')
        ->addButtons([
            Button::create('Break | Descanso')->value('break'),  //  Descanso de 15 minutos. Los empleados Ɵenen 2 descansos diarios de 15 minutos obligatorios.
            Button::create('Lunch | Comer')->value('lunch'), // Salida para comer.
            Button::create('Out   | Salida')->value('out')    // Salida de la oficina.
        ]);

    $this->ask($question, function (Answer $answer) use ($user, $id_working){
        $res = $answer->getValue();
        switch ($res){
            case 'break':
                return $this->break($user, $id_working);
                break;
            case 'lunch':
                return $this->lunch($user, $id_working);
                break;
            case 'out':
                return $this->out($user, $id_working);
                break;
            default:
                return $this->repeat('No puedo entenderte, ¿puedes intentarlo de nuevo?');
        }
      });



}


    private function in($user){

        $this->say('¡Bienvenido al trabajo, ' . $user->name . '!');
        $this->say('Recuerda que tu hora de entrada es ' . $user->position->start_time . ' ' .  'Bienvenido. 👋');

        $working = new working_time();
        $working->user_id = $user->id;
        $working->entry_date = Carbon::now()->format('y/m/d H:i:s');
        $working->save();

        $id_working = $working->id;
        $workings = working_time::find($id_working);

        if($workings->entry_date <= $user->position->start_time ){
            $workings->centry = 1;
            $workings->save();

            $this->say('Entraste a tiempo al trabajo. ✅');
         }else if($workings->entry_date > $user->position->start_time){
            $workings->centry = 0;
            $workings->save();

            $this->say('Entraste tarde al trabajo. ❌');
          }


        $this->say('Entrada al trabajo registrada con éxito. ✅');

        $this->showPostmenu($user, $id_working);

    }



    public function break($user, $id_working)
    {

    $working = working_time::find($id_working);

    if($working->break == 1 && $working->break_two == 1){
        $this->say('Ya tomaste tus dos breaks, si necesitas descansar toma tu lunch'. ' '. '👋');
        $this->showPostmenu($user, $id_working);

    }else{
        $this->say('¡El break solo dura 15 minutos, procura regresar antes de tiempo.! 👋');
        if($working->break == 1){
            $working->break_two = 1;
            $working->time_break_two = Carbon::now()->format('H:i:s');
            $working->save();
        }else{
            $working->break = 1;
            $working->break_time = Carbon::now()->format('H:i:s');
            $working->save();
        }

        $question = Question::create('¿Qué deseas hacer?')
        ->fallback('Lo siento, no puedo ayudarte con eso')
        ->callbackId('menu')
        ->addButtons([
            Button::create('Back | Regresar del descanso')->value('back_break'),  //  Descanso de 15 minutos. Los empleados Ɵenen 2 descansos diarios de 15 minutos obligatorios.
        ]);
        $this->ask($question, function (Answer $answer) use ($user, $id_working){
            $res = $answer->getValue();
            switch ($res){
                case 'back_break':
                    return $this->back_break($user, $id_working);
                    break;
                default:
                    return $this->repeat('No puedo entenderte, ¿puedes intentarlo de nuevo?');
            }
          });

        }

        $this->bot->typesAndWaits(1);
    }

    public function back_break($user, $id_working)
    {
        $this->say('¡Hola ' . $user->name .  ' '. 'regresas del break! 👋');

        $working = working_time::find($id_working);
        if($working->break == 1 && $working->back_break == null){
            $working->back_break = Carbon::now()->format('H:i:s');
            $working->save();
        }
        else if($working->break_two == 1 && $working->back_break_two == null){
            $working->back_break_two = Carbon::now()->format('H:i:s');
            $working->save();
        }

        $this->showPostmenu($user, $id_working);


        $this->bot->typesAndWaits(1);

    }

    public function lunch($user, $id_working)
    {

        $working = working_time::find($id_working);
        if($working->lunch_time == null){

            $this->say('Buen provecho'. ' ' . $user->name . ' '. '👋');
            $working->lunch_time = Carbon::now()->format('H:i:s');
            $working->save();

            $question = Question::create('¿Qué deseas hacer?')
            ->fallback('Lo siento, no puedo ayudarte con eso')
            ->callbackId('menu')
            ->addButtons([
                Button::create('Back | Regresar del lunch')->value('back_lunch'),  //  Descanso de 15 minutos. Los empleados Ɵenen 2 descansos diarios de 15 minutos obligatorios.
            ]);
            $this->ask($question, function (Answer $answer) use ($user, $id_working){
                $res = $answer->getValue();
                switch ($res){
                    case 'back_lunch':
                        return $this->back_lunch($user, $id_working);
                        break;
                    default:
                        return $this->repeat('No puedo entenderte, ¿puedes intentarlo de nuevo?');
                }
              });


            $this->bot->typesAndWaits(1);

        }else{
            $this->say($user->name .  ' ' . 'Ya almorzaste, si necesitas descansar toma un break'. ' '. '👋');
            $this->showPostmenu($user, $id_working);
        }


    }


    public function back_lunch($user, $id_working)
    {
        $this->say('¡Hola ' . ' '. $user->name .  ' '. 'regresas del lunch! 👋');

            $working = working_time::find($id_working);

            $working->back_lunch = Carbon::now()->format('H:i:s');
            $working->save();


        $this->showPostmenu($user, $id_working);


        $this->bot->typesAndWaits(1);

    }


     public function out($user, $id_working)
    {

        $working = working_time::find($id_working);

        if ($working->entry_date == $working->out) {
            $this->say('Las horas de entrada y salida son iguales.');
            $this->showPostmenu($user, $id_working);


        }else{
            $this->say('¡Hasta luego!  ' . $user->name . ' '. 'Que descanses. 👋');
            $this->say('Recuerda que tu hora de salida es ' . $user->position->end_time . ' ' . 'Que descanses. 👋');

            if($working->out == null && $working->out >= $user->position->end_time ){
                $this->say('¡Saliste a tu hora!, Que descanses. 👋');
                $working->out = Carbon::now()->format('y/m/d H:i:s');
                $working->cout = 1;
                $working->save();

                $this->showMenu();
            }else if($working->out == null && $working->out < $user->position->end_time){
                $this->say('Saliste antes de tu hora de salida, por favor notifica a tu supervisor.');
                $working->out = Carbon::now()->format('y/m/d H:i:s');
                $working->cout = 0;
                $working->save();

                $this->showMenu();
            }

      }
    }

}
