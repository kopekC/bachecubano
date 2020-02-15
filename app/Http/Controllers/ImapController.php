<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Api\SmsController;
use App\Mail\ImapResponse;
use App\User;
use Fetch\Server;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ImapController extends Controller
{
    private $driver;
    private $imap_cnx;
    private $user;

    public function __construct()
    {
        $imap_server = config('imap.imap_server');
        $imap_port = config('imap.imap_port');
        $imap_user = config('imap.imap_user');
        $imap_password = config('imap.imap_password');

        $this->driver = new Server($imap_server, $imap_port);
        $this->driver->setAuthentication($imap_user, $imap_password);
    }

    /**
     * Check for new email
     */
    public function imap_check()
    {
        $messages = $this->driver->getMessages(10);

        if (count($messages) > 0) {
            $this->process_messages($messages, $this->driver);
        } else {
            echo "No mail";
        }
    }

    /**
     * Manage the email object processing
     *
     * @param type $messages
     * @param $server
     */
    private function process_messages($messages, $server)
    {
        /** @var $message \Fetch\Message */
        foreach ($messages as $message) {

            //Email headers
            $email = $message->getHeaders()->fromaddress;
            $subject = $message->getSubject();
            $body = $message->getMessageBody();
            $body = preg_replace("/\r\n|\r|\n/", '', $body);
            $subject = explode(" ", $subject);
            $command = strtolower(trim($subject[0]));

            dump($message);

            //Delete this message and clean mailbox
            $message->delete();
            $server->expunge();

            //Get this User Data/Register if not
            $this->user = User::where('email', $email)->first();
            if (!$this->user) {
                $this->user = User::create([
                    'name'     => explode('@', $email)[0],
                    'email'    => $email,
                    'password' => Hash::make(Str::random(60)),
                    'api_token' => Str::random(60),
                ]);
            }

            //Method verification
            if (method_exists($this, $command)) {
                echo "Calling this->" . $command . "()";
                $response = $this->$command($body);
                return Mail::to($email)->send(new ImapResponse($response['subject'], $response['body']));
            } else {
                //Error, el metodo solicitado no existe.
                $subject = "Comando o solicitud no válida";
                $body = "Al parecer utilizó un comando o solitud errónea en su correo. Verifique que esté correctamente escrito. Para dudas llamar al 54663598";
                return Mail::to($email)->send(new ImapResponse($subject, $body));
            }
        }
    }

    /**
     * Send SMS from this user
     */
    private function sms($body)
    {
        echo "<h1>ENVIAR SMS</h1>";

        $values = explode("|$|", $body);

        if ($this->user->wallet->credits >= config('sms.sms_value_nac')) {
            //Send SMS
            SmsController::send_request($values[1], $values[2]);

            //Now discount SMS price upon sent SMS based on the destination
            if (substr($values[1], 0, 4) == "+535" || substr($values[1], 0, 3) == "535") {
                $this->user->wallet->deduce(config('sms.sms_value_nac'));
            } else {
                $this->user->wallet->deduce(config('sms.sms_value_int'));
            }
        } else {
            return ['subject' => 'Lo sentimos, no tiene saldo suficiente', 'body' => 'Puede recargar su cuenta transfiriendo al 55149081'];
        }
    }

    /**
     * Top Up Account
     */
    private function topup($body)
    {
        echo "<h1>TOPUP</h1>";

        return ['subject' => 'Lo sentimos, estamos trabajando en este módulo aún', 'body' => 'Lo corregimos en breve'];
    }

    /**
     * Top Up Account
     */
    private function publicar($body)
    {
        echo "<h1>PUBLICAR</h1>";

        return ['subject' => 'Lo sentimos, estamos trabajando en este módulo aún', 'body' => 'Lo corregimos en breve'];
    }
}
