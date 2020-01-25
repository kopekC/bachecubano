<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\User;
use DateTime;
use Illuminate\Http\Request;

class SmsController extends Controller
{


    /**
     * Securize thi endpoint
     */
    public function __construct()
    {
        //Initialize some security steps here?
    }

    /**
     * Get a SMS delivery request and preoccess it.
     * 
     * Typically a POST request with:
     * 
     */
    public function send_sms(Request $request)
    {
        //Validate this input
        $request->validate([
            'phone' => 'bail|required|numeric',
            'message' => 'bail|required|min:1|max:150',
            'agree' => 'bail|required',
            'user_id' => 'bail|required|numeric',
            'api_token' => 'bail|required'              //Retrieved as GET or POST?
            //Google reCaptcha here?
        ]);

        // Check som security things, like te autenticity of this user
        $user = (new User())->getByToken($request->input('api_token'));

        //If this token doesn't belongs to the user->id give error 403
        if (is_null($user) || $user->id != $request->input('user_id')) {
            abort(403);
        }

        //Now check the user balance
        if ($user->wallet->credits >= config('sms.sms_value_nac')) {

            //has enough money, proceed
            $result = $this->send_request($request->input('phone'), $request->input('message'));

            //Now discount SMS price upon sent SMS based on the destination
            if (substr($request->input('phone'), 0, 4) == "+535" || substr($request->input('phone'), 0, 3) == "535") {
                $user->wallet->deduce(config('sms.sms_value_nac'));
            } else {
                $user->wallet->deduce(config('sms.sms_value_int'));
            }

            //Return JSON response
            return response()->json(['message' => 'Felicidades! Se ha enviado su SMS', 'result' => json_encode($result), 'status' => 200], 200);
        } else {
            return response()->json(['message' => 'Error, no tiene saldo suficiente', 'status' => 404], 200);
        }
    }

    /**
     * Send SMS to the coresponding server
     */
    private function send_request($number, $message)
    {
        //Clean the $message chars
        //Save this SMS?
        //Discount upon sent

        //Check first 4 chars, view if it's national or international
        if (substr($number, 0, 4) == "+535" || substr($number, 0, 3) == "535") {
            //SMS Nacional
            return (new Nacional(config('sms.sms_nacional_token')))->enviar_sms($number, $message);
        } else {
            //SMS internacional
            return (new Internacional(config('sms.sms_internacional_token')))->enviar_sms($number, $message);
        }
    }
}

/**
 * National provider Class
 * A simple CURL to the SMS Provider
 */
class Nacional
{
    //user credentials
    private $api_token;
    private $rest_base_url;
    private $rest_commands = [
        'send_sms' => ['url' => '/sms/send', 'method' => 'POST'],
        'get_sms_status' => ['url' => '/sms/report-status', 'method' => 'GET'],
        'get_balance' => ['url' => '/account/balance', 'method' => 'GET'],
    ];

    public function __construct($api_token = null)
    {
        $this->api_token = $api_token;
        $this->rest_base_url =  config('sms.sms_nacional_route');
    }

    /**
     * Enviar SMS
     */
    public function enviar_sms($destino, $mensaje)
    {
        //chequea el formato del destino
        if (!strstr($destino, '+')) {
            trigger_error('El formato del destinatario es inválido.');
            return false;
        }
        //chequea longitud del mensaje
        if (strlen($mensaje) > 160) {
            trigger_error('La longitud del mensaje sobrepasa los 160 caracteres.');
            return false;
        }
        $data = array(
            'destino' => $destino,
            'mensaje' => $mensaje
        );
        return $this->callApi('send_sms', $data);
    }

    /**
     * Obtener el balance de la cuenta
     */
    public function balance()
    {
        return $this->callApi('get_balance');
    }

    /**
     * Llamada a api de
     */
    private function callApi($command, $data = array())
    {
        $command_info = $this->rest_commands[$command];
        $url = $this->rest_base_url . $command_info['url'];
        $method = $command_info['method'];
        $params = array_merge($data, array('api_token' => $this->api_token));
        $params_query_string = http_build_query($params);
        if (function_exists('curl_version')) { //user curl
            $request = curl_init();
            if ($method == 'POST') {
                curl_setopt($request, CURLOPT_URL, $url);
                curl_setopt($request, CURLOPT_POST, true);
                curl_setopt($request, CURLOPT_POSTFIELDS, $params_query_string);
            } else {
                curl_setopt($request, CURLOPT_URL, $url . '?' . $params_query_string);
            }
            curl_setopt($request, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($request, CURLOPT_SSL_VERIFYPEER, false);
            $response = curl_exec($request);
            curl_close($request);
        } elseif (ini_get('allow_url_fopen')) { // No CURL available so try the awesome file_get_contents
            if ($method == 'POST') {
                $opts = array(
                    'http' =>
                    array(
                        'method' => 'POST',
                        'header' => 'Content-type: application/x-www-form-urlencoded',
                        'content' => $params_query_string
                    )
                );
                $context = stream_context_create($opts);
                $response = file_get_contents($url, null, $context);
            } else {
                $opts = array(
                    'http' =>
                    array(
                        'method' => 'GET',
                    )
                );
                $context = stream_context_create($opts);
                $response = file_get_contents($url . '?' . $params_query_string, null, $context);
            }
        } else {
            return false;
        }
        return $response;
    }
}

/**
 * Internacional Class for SMS sending
 */
class Internacional
{
    private $api_token;
    private $rest_base_url;

    /**
     * Initialice variables
     */
    public function __construct($api_token)
    {
        $this->api_token = $api_token;
        $this->rest_base_url = config('sms.sms_internacional_route');
    }

    /**
     * Send the international SMS
     */
    public function enviar_sms($to, $message)
    {
        $now = new DateTime();
        $now = $now->format(DateTime::ISO8601);

        $full_phone = str_ireplace("+", "", $to);
        $numbers = [$full_phone];

        $promo_txt = " enviado desde Bachecubano.com";
        if (strlen($message) < 120)
            $message = $message . $promo_txt;

        $data = array(
            'to' => $numbers,
            'from' => config('sms.international_from_number'),
            'body' => utf8_superencode($message),
            'delivery_report' => 'full',
            'send_at' => $now,
        );
        $payload = json_encode($data);

        /*
        $response = \Httpful\Request::post($url)
            ->sendsJson()
            ->expectsJSON()
            ->addHeader('Authorization', 'Bearer ' . $token)
            ->body($payload)
            ->send();
        $log_body = $response->body;
        */

        $client = new \GuzzleHttp\Client(['headers' => ['Authorization' => 'Bearer ' . $this->api_token]]);
        $response = $client->request('POST', config('sms.sms_internacional_route'), ['json' => $payload]);

        $response = $response->getBody()->getContents();
        echo '<pre>';
        print_r($response);
    }

    //Super encode this
    function utf8_superencode($text)
    {
        return utf8_encode($text);
    }
}
