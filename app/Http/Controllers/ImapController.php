<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Fetch\Server;

class ImapController extends Controller
{
    private $driver;
    private $imap_cnx;

    public function __construct()
    {
        $imap_server = config('imap.imap_server');
        $imap_port = config('imap.imap_port');
        $imap_user = config('imap.imap_user');
        $imap_password = config('imap.imap_password');

        $this->driver = new Server($imap_server, $imap_port);

        dump($this->driver);

        $this->driver->setAuthentication($imap_user, $imap_password);

        dump($this->driver);
    }

    public function imap_check()
    {
        /** @var Message[] $message */
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
            $email = $message->getFrom()[0]["address"];
            $subject = $message->getSubject();
            $body = $message->getMessageBody();
            $body = preg_replace("/\r\n|\r|\n/", '', $body);
            $subject = explode(" ", $subject);
            $command = strtoupper(trim($subject[0]));

            //Delete this message and clean mailbox
            $message->delete();
            $server->expunge();

            //Get this User Data/Register if not
            //$user = 

            if ($user_data !== FALSE && is_object($user_data) && isset($user_data->id) && isset($user_data->quota)) {

                //Loggear el Hit OK
                //$this->load->model('log_model');
                //$log_id = $this->log_model->log($user_data->id, $subject, $body);
                file_put_contents("process_emails/" . $user_data->id . $subject . ".txt", $subject . "\n" . $body);

                $user_id = $user_data->id;
                $passwd = $user_data->email_passwd;
                $consecutive = $user_data->consecutive;
                $quota = $user_data->quota;
                $tags = "Email " . $subject[1];
                $my_topups = $this->numbers_model->get_total_numbers($user_id, 1, 0);
                $total_topups = $this->user_model->getTotaltopUP($user_id);
                $failed = "";

                if ($command == "R" && is_numeric($subject[1])) {

                    if ($subject[1] != $consecutive) {

                        echo "<h2>CONSECUTIVO INVÁLIDO</h2>";
                        $this->sendEmail($email, 'Consecutivo inválido', 'Ha enviado un correo con el número consecutivo no válido, verifique nuevamente. (' . $consecutive . ')');
                    } else {

                        if (strpos($body, $passwd) === FALSE) {

                            //Error no hay contraseña
                            echo "<h2>CONTRASEÑA INCORRECTA</h2>";
                            $this->sendEmail($email, 'Contraseña incorrecta', 'La contraseña introducida no es correcta, intente nuevamente o contacte con el 54663598.');
                        } else {

                            $numbers = explode(",", explode($passwd, $body)[0]);

                            if (isset($numbers) && count($numbers) > 0) {

                                $counter = 0;
                                $bad_number = 0;

                                foreach ($numbers as $num) {

                                    $row = trim($num, " \t\n\r\0\x0B");
                                    $amount_to_topup = 20;
                                    $number_exploded = explode("-", $row);
                                    $number_to_topup = $number_exploded[0];
                                    $valid_amounts = ['20'];
                                    $cant_numbers = $user_data->cant_numbers;

                                    //Fix for the comma after last number
                                    if ($number_to_topup == "")
                                        continue;

                                    //Amount to top up for the number
                                    if (isset($number_exploded[1]) && in_array($number_exploded[1], $valid_amounts))
                                        $amount_to_topup = 20;
                                    //$amount_to_topup = $number_exploded[1];

                                    //Possible comments
                                    $number_exploded_comments = explode("~", $number_to_topup);
                                    if (isset($number_exploded_comments[1]) && is_string($number_exploded_comments[1]) && $number_exploded_comments[1] != "")
                                        $tags = $number_exploded_comments[1];
                                    $number_to_topup = trim($number_exploded_comments[0], " \t\n\r\0\x0B");

                                    //Validar el numero
                                    if (Utils::checkCell($number_to_topup)) {

                                        //Comprobar que tiene recargas disponibles
                                        if ($cant_numbers > 0) {
                                            $this->numbers_model->save_number($user_id, $number_to_topup, $amount_to_topup, $tags, 1);
                                            $counter++;

                                            $this->user_model->sub_one_topup($user_id);
                                            $user_data->cant_numbers--;
                                        } else {
                                            $failed .= $number_to_topup . "<br>";
                                            continue;
                                        }
                                    } else {
                                        $bad_number++;
                                    }
                                }

                                //Increment Consecutivo
                                $consecutive++;
                                $this->user_model->set_consecutive($user_id, $consecutive);

                                $body_email = "";

                                //if ($bad_number > 0)
                                //    $body_email .= "Se encontraron " . $bad_number . " números incorrectos<br><br>";

                                $body_email .= "Listado:<br><br>";
                                foreach ($numbers as $num) {
                                    if ($num == "")
                                        continue;
                                    $body_email .= $num . " -> " . $quota . "<br>";
                                }

                                if ($failed != "") {
                                    $body_email .= "No posee saldo suficiente para las siguientes recargas, llame a su proveedor ";
                                }

                                $body_email .= "<br>Total: $ " . $quota * ($counter);
                                $body_email .= "<br>Mi Cierre: (" . $my_topups . ") - $ " . $quota * ($my_topups);
                                $body_email .= "<br>Cierre Total: (" . $total_topups . ") - $ " . $quota * ($total_topups);

                                $this->sendEmail($email, "Recarga #" . $subject[1] . " procesada", $body_email);
                            }
                        }
                    }
                } elseif ($command == "CIERRE") {

                    //Enviar el cierre del dia
                    //$today = new DateTime();
                    //$hoy = $today->format("Y-m-d");
                    $my = $this->numbers_model->get_my_numbers($user_id, []);

                    $body = "<h2>Cierre Recarga</h2>";
                    $total = 0;
                    foreach ($my as $number) {
                        $total++;
                        $body .= $number->number . " -> " . $number->amount;
                        if ($number->processing == 0) {
                            $status = "Sin Aprobar";
                        }
                        if ($number->processing == 1) {
                            $status = "Aprobado";
                        }
                        if ($number->recharged == 1) {
                            $status = "Recargado";
                        }
                        if ($number->fail == 1) {
                            $status = "PROCESANDO";
                        }
                        $body .= " -> " . $status . " -> " . $number->added . " -> " . $number->confirmation . " -> " . $number->tags . "<br>";
                    }
                    $body .= "<h4>Total: " . $total . "</h4>";
                    $body .= "<h4>Cuota: " . $quota . "</h4>";
                    $body .= "<h3>Cierre final: " . $total * $quota . "</h3>";

                    $this->sendEmail($email, 'Cierre de la recarga', $body);
                } else {
                    //Opción no valida, saludos!
                    $this->sendEmail($email, 'Comando NO válido', ":-O");
                }
            } else {
                //Bateo, el usuario no esta en la BD
                //echo "No USER EXISTENCE";
                //$this->sendEmail($email, 'ERROR 403', 'Contacte al administrador 54663598');
            }
        }
    }
}
