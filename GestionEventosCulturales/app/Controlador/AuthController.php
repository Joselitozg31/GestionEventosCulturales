<?php

namespace App\Controlador;

use App\Utils\Utils;
use App\Model\Usuario;
use PDO;

class AuthController
{
    public function mostrarLogin()
    {
        Utils::render('auth/login');
    }

    // Función para procesar el inicio de sesión
    public function procesarLogin()
    {
        // Obtener los datos del formulario
        $correo = $_POST['correo'];
        $password = $_POST['password'];

        $con = Utils::getConnection();
        $usuarioM = new Usuario($con);
        $usuario = $usuarioM->obtenerPorCorreo($correo);

        // Verificar si el usuario existe y la contraseña es correcta
        if ($usuario) {
            // Verificar si la contraseña es correcta
            if (password_verify($password, $usuario['Password'])) {
                if ($usuario['Codigo'] == null) {
                    session_start();
                    $_SESSION['user_id'] = $usuario['idUsuarios'];
                    header('Location: /');
                    // Si las credenciales son incorrectas, se redirige al login con un mensaje de error
                } else {
                    header('Location: /login?error=validacion');
                }
            } else {
                header('Location: /login?error=credenciales');
            }
        } else {
            header('Location: /login?error=correo');
        }
    }

    // Función para cerrar la sesión
    public function mostrarRegistro()
    {
        Utils::render('auth/register');
    }

    // Función para procesar el registro de un usuario
    public function procesarRegistro()
    {
        // Obtener los datos del formulario
        $nombre = $_POST['nombre'];
        $correo = $_POST['correo'];
        $password = $_POST['password'];
        $confirmPassword = $_POST['confirm_password'];

        // Verificar si las contraseñas coinciden
        if ($password !== $confirmPassword) {
            header('Location: /register?error=confirmacion');
            return;
        }

        // Verificar si la contraseña cumple con los requisitos de seguridad
        if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/', $password)) {
            header('Location: /register?error=seguridad');
            return;
        }

        // Verificar si el correo ya está registrado
        $con = Utils::getConnection();
        $usuarioM = new Usuario($con);
        if ($usuarioM->obtenerPorCorreo($correo)) {
            header('Location: /register?error=existe');
            return;
        }

        // Insertar el usuario en la base de datos
        $codigoValidacion = bin2hex(random_bytes(16));
        $datos = [
            'Nombre' => $nombre,
            'Correo' => $correo,
            'Password' => password_hash($password, PASSWORD_DEFAULT),
            'Fecha_Registro' => date('Y-m-d H:i:s'),
            'Codigo' => $codigoValidacion
        ];

        // Si se inserta el usuario, se envía un correo de validación
        if ($usuarioM->insertarUsuario($datos)) {
            // Enviar email de validación
            if (Utils::enviarEmailValidacion($correo, $nombre, $codigoValidacion)) {
                header('Location: /validacion?correo=' . urlencode($correo));
                // Si ocurre un error al enviar el correo, se muestra un mensaje
            } else {
                echo "Error al enviar el correo de validación.";
            }
        } else {
            echo "Error al insertar el usuario.";
        }
    }

    // Función para mostrar la validación de un usuario
    public function mostrarValidacion()
    {
        Utils::render('auth/validacion');
    }

    // Función para procesar la validación de un usuario
    public function procesarValidacion()
    {
        // Obtener los datos del formulario
        $correo = $_POST['correo'];
        $codigo = $_POST['codigo'];

        // Validar el usuario
        $con = Utils::getConnection();
        $usuarioM = new Usuario($con);
        // Si el usuario es válido, se redirige al login
        if ($usuarioM->validarUsuario($correo, $codigo)) {
            header('Location: /login?mensaje=validado');
        } else {
            header('Location: /validacion?error=invalid');
        }
    }
}