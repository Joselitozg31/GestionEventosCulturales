<?php

namespace App\Utils;

use PDO;
use Mailjet\Client;
use Mailjet\Resources;

class Utils
{
    // Función para obtener una conexión a la base de datos
    public static function getConnection()
    {
        $dsn = $_ENV['DB_DATABASE'];
        $username = $_ENV['DB_USERNAME'];
        $password = $_ENV['DB_PASSWORD'];

        return new PDO($dsn, $username, $password);
    }

    // Función para obtener el tipo de parámetro
    public static function obtenerTipoParametro($valor)
    {
        if (is_int($valor)) {
            return PDO::PARAM_INT;
        } elseif (is_bool($valor)) {
            return PDO::PARAM_BOOL;
        } elseif (is_null($valor)) {
            return PDO::PARAM_NULL;
        } else {
            return PDO::PARAM_STR;
        }
    }

    // Función para renderizar una vista
    public static function render($view, $datos = [])
    {
        extract($datos);
        include __DIR__ . "/../../view/$view.php";
    }

    // Función para redirigir a una URL
    public static function redirect($url)
    {
        header("Location: $url");
        exit();
    }

    // Función para generar un código de validación
    public static function enviarEmailValidacion($correo, $nombre, $codigoValidacion)
    {
        $mj = new Client($_ENV['MAILJET_API_KEY'], $_ENV['MAILJET_API_SECRET'], true, ['version' => 'v3.1']);

        // Se envía un correo con el código de validación
        $body = [
            'Messages' => [
                [
                    'From' => [
                        'Email' => "joselitozg32@gmail.com",
                        'Name' => "Eventos Culturales"
                    ],
                    'To' => [
                        [
                            'Email' => $correo,
                            'Name' => $nombre
                        ]
                    ],
                    'Subject' => "Confirm your registration",
                    'TextPart' => "Hello $nombre,\n\nPlease use the following code to verify your email address: $codigoValidacion\n\nThank you!",
                    'HTMLPart' => "<h3>Hello $nombre,</h3><p>Please use the following code to verify your email address: <strong>$codigoValidacion</strong></p><p>Thank you!</p>"
                ]
            ]
        ];

        // Se envía el correo
        $response = $mj->post(Resources::$Email, ['body' => $body]);

        // Se verifica si el correo se envió correctamente
        if ($response->success()) {
            return true;
        } else {
            $errorInfo = $response->getData();
            echo "Error al enviar el correo: " . json_encode($errorInfo);
            return false;
        }
    }
}