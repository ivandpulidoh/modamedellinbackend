<?php

namespace App\Http\Controllers;

use App\Entidades\Cliente;
use App\Entidades\Sucursal;
use Illuminate\Http\Request;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

require app_path() . '/start/constants.php';
class ControladorWebContacto extends Controller
{
	public function index()
	{

		$sucursal = new Sucursal();
		$aSucursales = $sucursal->obtenerTodos();
		return view("web.contacto", compact('aSucursales'));
	}

	    public function enviar(Request $request)
    {
        $titulo = 'Contacto';
        $nombre = $request->input('txtNombre'); // Corrected input name
        $telefono = $request->input('txtTelefono');
        $correo = $request->input('txtCorreo');
        $comentario = $request->input('txtComentario');

        $sucursal = new Sucursal();
        $aSucursales = $sucursal->obtenerTodos();

        if ($nombre != "" && $telefono != "" && $correo != "" && $comentario != "") {
            $mail = new PHPMailer(true);
            try {
                // SMTP Configuration
                $mail->isSMTP();
                $mail->Host = env('MAIL_HOST');
                $mail->SMTPAuth = true;
                $mail->Username = env('MAIL_USERNAME');
                $mail->Password = env('MAIL_PASSWORD');
                $mail->SMTPSecure = env('MAIL_ENCRYPTION');
                $mail->Port = env('MAIL_PORT');

                // Email content
                $mail->setFrom(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
                $mail->addAddress($correo);
                $mail->addReplyTo('no-reply@fmed.uba.ar');
                $mail->isHTML(true);
                $mail->Subject = 'Gracias por contactarte';
                $mail->Body = "Los datos del formulario son:
                    Nombre: $nombre<br>
                    Telefono: $telefono<br>
                    Correo: $correo<br>
                    Comentario: $comentario<br>";

                // Send email
                $mail->send();

                // Return success view
                return view('web.contacto-gracias', compact('aSucursales'));
            } catch (Exception $e) {
                // Log the error for debugging
                \Log::error($e->getMessage());

                // Return error view with a message
                $msg["ESTADO"] = MSG_ERROR;
                $msg["MSG"] = "Hubo un error al enviar el correo";
                return view('web.contacto', compact('aSucursales', 'msg'));
            }
        } else {
            // Return error view with a message
            $msg["ESTADO"] = MSG_ERROR;
            $msg["MSG"] = "Complete los datos";
            return view('web.contacto', compact('aSucursales', 'msg'));
        }
    }
}

