<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

class Principal extends Controller
{
    public function __construct()
    {
        parent::__construct();
        session_start();
        set_time_limit(300);
    }

    public function index()
    {
        $data['title'] = 'Iniciar Sesion';
        $this->views->getView('principal', 'index', $data);
    }

    ###login###
    public function Validar()
    {
        $correo = $_POST['correo'];
        $clave = $_POST['clave'];

        $data = $this->model->getUsuario($correo);

        if (!empty($data)) {
            if (password_verify($clave, $data['clave'])) {
                $_SESSION['id'] = $data['id'];
                $_SESSION['correo'] = $data['correo'];
                $_SESSION['nombre'] = $data['nombre'];
		$_SESSION['rol'] = $data['rol'];				
                if ($_SESSION['rol'] == 1) {
   		 // Redirigir al área de administrador
   		 $res = array(
    		    'tipo' => 'success',
     		    'mensaje' => 'BIENVENIDO, ADMINISTRADOR',
      		    'redirect' => BASE_URL . 'Admin'
    			);
		}		
		elseif ($_SESSION['rol'] == 2) {
   		 // Redirigir al área de usuario
    			$res = array(
        		'tipo' => 'success',
        		'mensaje' => 'BIENVENIDO, USUARIO',
        		'redirect' => BASE_URL . 'Usuario'
    		);
		}
            } else {
                $res = array('tipo' => 'warning', 'mensaje' => 'CONTRASEÑA INCORRECTA');
            }
        } else {
            $res = array('tipo' => 'warning', 'mensaje' => 'EL CORREO NO EXISTE');
        }
        echo json_encode($res, JSON_UNESCAPED_UNICODE);
        die();
    }

    ###restablecer clave####
    public function enviarCorreo($correo)
    {
        $consulta = $this->model->getUsuario($correo);
        if (!empty($consulta)) {
            $mail = new PHPMailer(true);
            try {
                $token = md5(date('YmdHis'));
                $this->model->updateToken($token, $correo);
                
                //Server settings
                $mail->SMTPDebug = 0; 
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'roseygabriela21@gmail.com';
                $mail->Password = 'orduzgmibgddeuml'; 
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587; 

             
                $mail->SMTPOptions = array(
                    'ssl' => array(
                        'verify_peer' => false,
                        'verify_peer_name' => false,
                        'allow_self_signed' => true
                    )
                );

                //Recipients
                $mail->setFrom('diana.villapaz@gmail.com', 'Inmasic');
                $mail->addAddress($correo);

                //Content
                $mail->isHTML(true);
                $mail->Subject = 'Restablecer clave';
                $mail->Body = 'Has pedido restablecer tu contraseña, si no has sido tú, omite este mensaje.<br><a href="' . BASE_URL . 'principal/reset/' . $token . '"> CLICK AQUÍ PARA CAMBIAR CONTRASEÑA </a>';

                $mail->send();
                $res = array('tipo' => 'success', 'mensaje' => 'CORREO ENVIADO');
            } catch (Exception $e) {
                
                $res = array('tipo' => 'error', 'mensaje' => 'Error al enviar el correo: ' . $mail->ErrorInfo);
            }
        } else {
            $res = array('tipo' => 'warning', 'mensaje' => 'EL CORREO NO EXISTE');
        }
        echo json_encode($res, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function reset($token)
    {
        $data['title'] = 'Restablecer clave';
        $data['usuario'] = $this->model->getToken($token);
        if ($data['usuario']['token'] == $token) {
            $this->views->getView('principal', 'reset', $data);
        } else {
            header('Location:' . BASE_URL . 'errors');
        }
    }

    public function cambiarPass()
    {
        $nueva = $_POST['clave_nueva'];
        $confirmar = $_POST['clave_confirmar'];
        $token = $_POST['token'];

        if (empty($nueva) || empty($confirmar) || empty($token)) {
            $res = array('tipo' => 'warning', 'mensaje' => 'Todos los campos son requeridos');
        } else {
            if ($nueva != $confirmar) {
                $res = array('tipo' => 'warning', 'mensaje' => 'Las contraseñas no coinciden');
            } else {
                $result = $this->model->getToken($token);
                if ($result && $token == $result['token']) {
                    $hash = password_hash($nueva, PASSWORD_DEFAULT);
                    $data = $this->model->cambiarPass($hash, $token);
                    if ($data == 1) {
                        $res = array('tipo' => 'success', 'mensaje' => 'CONTRASEÑA RESTABLECIDA.');
                    } else {
                        $res = array('tipo' => 'error', 'mensaje' => 'ERROR AL RESTABLECER LA CONTRASEÑA.');
                    }
                } else {
                    $res = array('tipo' => 'warning', 'mensaje' => 'TOKEN INVÁLIDO');
                }
            }
        }
        echo json_encode($res, JSON_UNESCAPED_UNICODE);
        die();
    }
}
