<?php

namespace App\Http\Controllers;

use App\Ad;
use App\AdDescription;
use App\Http\Controllers\Api\SmsController;
use App\Mail\ImapResponse;
use App\User;
use Fetch\Server;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\CategoryDescription;
use Carbon\Carbon;

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
            $email = $message->getHeaders()->from[0]->mailbox . "@" . $message->getHeaders()->from[0]->host;
            $subject = $message->getSubject();
            $body = $message->getMessageBody();
            $body = preg_replace("/\r\n|\r|\n/", '', $body);
            $subject = explode(" ", $subject);
            $command = strtolower(trim($subject[0]));

            dump($email);

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

            //Banned User
            if ($this->user->enabled == 0) {
                //Error, el metodo solicitado no existe.
                $subject = "Cuenta bloqueada";
                $body = "Lo sentimos pero su cuenta ha sido bloqueada, contacte con un administrador.";
                echo "Banned User";
                Mail::to($email)->send(new ImapResponse($subject, $body));
                continue;
            }

            //Method verification
            if (method_exists($this, $command)) {
                echo "Calling this->" . $command . "()";
                $response = $this->$command($body);
                Mail::to($email)->send(new ImapResponse($response['subject'], $response['body']));
            } else {
                //Error, el metodo solicitado no existe.
                $subject = "Comando o solicitud no válida";
                $body = "Al parecer utilizó un comando o solitud errónea en su correo. Verifique que esté correctamente escrito. Para dudas llamar al 54663598";
                Mail::to($email)->send(new ImapResponse($subject, $body));
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

        dump($values);

        if ($this->user->wallet->credits >= config('sms.sms_value_nac')) {

            //Send SMS
            SmsController::send_request($values[1], $values[2], $this->user->id);

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
     * Pubklish Ad
     * This is temporal, try to do it woth API post data
     */
    private function publicar($body)
    {
        echo "<h1>PUBLICAR</h1>";

        $values = explode("|$|", $body);

        //Process all data here
        if (is_array($values) && count($values) > 7) {

            /**
             * |$|Vendo Skoda del 63 buen estado técnico.|$|erich|$|53055125|$|erichvalcarcelv@gmail.com|$|compra/venta de autos|$|13500|$|Vendo auto Skoda 1963, motor bueno original con distribuidor electrónico, carrocería buena con 
             * línea de fábrica, gomas R13, diferencial de Lada. Todo le funciona.|$|1.15|$|android|$|lachopi|$|737586|$|Enviado desde mi smartphone Samsung Galaxy
             */

            $header = trim($values[1]);
            $name = trim($values[2]);
            $phone = trim($values[3]);
            $email = trim($values[4]);
            if ($email == "")
                $email = $this->user->email;

            //Parse this
            $cat = strtolower($values[5]);
            $sub_category =  CategoryDescription::where('slug', $this->parse_new_categories($cat))->first();

            $price = $values[6];
            $body = nl2br($values[7]);

            if (isset($values[8]))
                $version = $values[8];
            if (isset($values[9]))
                $platform = $values[9];
            if (isset($values[10]))
                $app = $values[10];
            if (isset($values[11]))
                $province = $values[11];

            dump($header);
            dump($name);
            dump($phone);
            dump($email);
            dump($cat);
            dump($sub_category);
            dump($price);
            dump($body);

            //Now try to publish it
            //Now + 3 months
            $now = Carbon::now();
            $plus_3_months = $now->addMonths(3);

            //Ad Basic Elements elements
            $ad = new Ad;

            //Basic Table
            $ad->user_id = $this->user->id;
            $ad->category_id = $sub_category->category_id;
            $ad->price = $price;
            $ad->contact_name = $name;
            $ad->contact_email = $email;
            $ad->premium = 0;
            $ad->enabled = 1;
            $ad->active = 1;
            $ad->spam = 0;
            $ad->secret = Str::random(20);
            $ad->expiration = $plus_3_months->format("Y-m-d H:i:s");
            $ad->phone = $phone;
            $ad->region_id = $province;
            $ad->save();

            //Description related table
            $description = new AdDescription();
            $description->ad_id = $ad->id;
            $description->title = $header;
            $description->description = $body;
            $description->save();

            dump($ad->id);
            dump($description);

            return ['subject' => 'Se ha publicado su anuncio correctamente ID: ' . $ad->id, 'body' => 'Estamos realizando tareas para mejorar la plataforma, espere novedades pronto.'];
        } else {
            return ['subject' => 'Lo sentimos, ha ocurrido un error con su anuncio', 'body' => 'Estamos investigando'];
        }
    }

    /**
     * Category transalator
     */
    private function parse_new_categories($cat)
    {
        $new_cats_map = [
            "pc de escritorio" => "pc-de-escritorio",
            "portátiles y tablets" => "portatiles-y-tablets",
            "monitores" => "monitores",
            "microprocesadores" => "microprocesadores",
            "motherboards" => "motherboards",
            "memorias" => "memorias",
            "disco duros" => "disco-duros",
            "chasis y fuentes" => "chasis-y-fuentes",
            "tarjetas de video" => "tarjetas-de-video",
            "unidad de cd y dvd" => "unidad-de-cd-y-dvd",
            "audio y bocinas" => "audio-y-bocinas",
            "backups" => "backups",
            "impresoras y cartuchos" => "impresoras-y-cartuchos",
            "redes y wifi" => "redes-y-wifi",
            "teclados y mouse" => "teclados-y-mouse",
            "webcam y otros" => "webcam-y-otros",
            "compra/venta de autos" => "compraventa-de-autos",
            "bicicletas" => "bicicletas",
            "alquiler de autos" => "alquiler-de-autos",
            "talleres" => "talleres",
            "motos" => "motos",
            "accesorios y piezas" => "piezasaccesorios",
            "celulares" => "celulares",
            "cámaras fotográficas" => "camaras",
            "televisores" => "televisor",
            "consolas de videojuegos" => "consolas",
            "audio y video multimedia" => "reproductores",
            "aire acondicionado" => "aires",
            "alquiler de casas" => "alquiler-de-casas",
            "electrodomésticos" => "electrodomesticos",
            "mascotas" => "mascotas",
            "muebles y decoración" => "muebles",
            "permuta" => "permuta",
            "compra/venta de casas" => "compraventa-de-casas",
            "bisutería y relojes" => "joyasrelojes",
            "gimnasios y masajistas" => "gimnasio",
            "implementos deportivos" => "deportivos",
            "vestuario y calzado" => "ropazapatos",
            "albañilería" => "albanileria",
            "clases" => "clases",
            "diseño y decoración" => "diseno-y-decoracion",
            "reparación electrónica" => "reparacion-electronica",
            "entretenimiento" => "entretenimiento",
            "espectáculos" => "espectaculos",
            "fotografía y video" => "fotografia-y-video",
            "gastronomía" => "gastronomia",
            "idiomas" => "traduccion",
            "informática" => "informatica",
            "peluquerías y barberías" => "peluquerias-y-barberias",
            "relojerías y joyeros" => "relojerojoyero",
            "servicios domésticos" => "limpieza",
            "cambio de moneda" => "divisas",
            "empleos" => "ofertastrabajo",
            "libros y revistas" => "librosrevistas",
            "regalos" => "regalos",
            "objetos perdidos" => "perdidoyencontrado"
        ];

        $translated = isset($new_cats_map[$cat]) ? $new_cats_map[$cat] : "perdidoyencontrado";
        return $translated;
    }
}
