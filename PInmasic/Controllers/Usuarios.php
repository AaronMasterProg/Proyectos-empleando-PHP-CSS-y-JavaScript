<?php
class Usuarios extends Controller
{
    private $id_usuario, $correo;
    public function __construct()
    {
        parent::__construct();
        session_start();
        $this->id_usuario =  $_SESSION['id'];
        $this->correo =  $_SESSION['correo'];
          ## VALIDAR SESION
  if (empty($_SESSION['id'])) {
    header ('Location:' .BASE_URL);
    exit;
  }
    }

    public function index()
    {
        $data['title'] = 'Gestión de usuarios';
        $data['script'] = 'usuarios.js';
        $data['menu'] = 'usuarios';
        $data['shares'] = $this->model->verificarEstado($this->correo);
        $this->views->getView('Usuarios', 'index', $data);
    }

    public function listar()
    {
        $data = $this->model->getUsuarios();
        for ($i = 0; $i < count($data); $i++) {
            if ($data[$i]['id'] == 1) {
                $data[$i]['acciones'] = 'SUPER ADMIN';
            } else {
                $data[$i]['acciones'] = '<div>
                <a href="#" class="btn btn-info btn-sm" onclick="editar(' . $data[$i]['id'] . ')">
                Editar
                </a>
                <a href="#" class="btn btn-danger btn-sm" onclick="eliminar(' . $data[$i]['id'] . ')">
                Eliminar
                </a>
                </div>';
            }
            $data[$i]['nombres'] = $data[$i]['nombre'] . ' ' . $data[$i]['apellido'];
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function guardar()
    {
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $correo = $_POST['correo'];
        $telefono = $_POST['telefono'];
        $direccion = $_POST['direccion'];
        $clave = $_POST['clave'];
        $rol = $_POST['rol'];
        $id_usuario = $_POST['id_usuario'];

        if (empty($nombre) || empty($apellido) || empty($correo) || empty($telefono) || empty($direccion) || empty($clave) || empty($rol)) {
            $res = array('tipo' => 'warning', 'mensaje' => 'TODOS LOS CAMPOS SON REQUERIDOS');
        } else {
            if ($id_usuario == '') {
                // Verificar si el correo ya existe
                $verificarCorreo = $this->model->getVerificar('correo', $correo, 0);
                if (empty($verificarCorreo)) {
                    // Verificar si el teléfono ya existe
                    $verificarTel = $this->model->getVerificar('telefono', $telefono, 0);
                    if (empty($verificarTel)) {
                        $hash = password_hash($clave, PASSWORD_DEFAULT);

                        // Guardar datos
                        $data = $this->model->registrar($nombre, $apellido, $correo, $telefono, $direccion, $hash, $rol);
                        if ($data > 0) {
                            $res = array('tipo' => 'success', 'mensaje' => 'Usuario registrado exitosamente.');
                        } else {
                            $res = array('tipo' => 'error', 'mensaje' => 'Error al registrar el usuario.');
                        }
                    } else {
                        $res = array('tipo' => 'warning', 'mensaje' => 'El teléfono ya existe');
                    }
                } else {
                    $res = array('tipo' => 'warning', 'mensaje' => 'El correo ya existe');
                }
            } else {
                // Editar usuario existente
                $verificarCorreo = $this->model->getVerificar('correo', $correo, $id_usuario);
                if (empty($verificarCorreo)) {
                    // Verificar si el teléfono ya existe
                    $verificarTel = $this->model->getVerificar('telefono', $telefono, $id_usuario);
                    if (empty($verificarTel)) {
                        $hash = password_hash($clave, PASSWORD_DEFAULT);

                        // Modificar datos
                        $data = $this->model->modificar($nombre, $apellido, $correo, $telefono, $direccion, $rol, $id_usuario);
                        if ($data == 1) {
                            $res = array('tipo' => 'success', 'mensaje' => 'Usuario modificado exitosamente.');
                        } else {
                            $res = array('tipo' => 'error', 'mensaje' => 'Error al modificar el usuario.');
                        }
                    } else {
                        $res = array('tipo' => 'warning', 'mensaje' => 'El teléfono ya existe');
                    }
                } else {
                    $res = array('tipo' => 'warning', 'mensaje' => 'El correo ya existe');
                }
            }
        }
        echo json_encode($res, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function delete($id)
    {
        $data = $this->model->delete($id);
        if ($data == 1) {
            $res = array('tipo' => 'success', 'mensaje' => 'USUARIO DADO DE BAJA');
        } else {
            $res = array('tipo' => 'warning', 'mensaje' => 'ERROR AL ELIMINAR');
        }
        echo json_encode($res, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function editar($id)
    {
        $data = $this->model->getUsuario($id);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function profile()
    {
        $data['title'] = 'Perfil del usuario';
        $data['script'] = 'profile.js';
        $data['menu'] = 'usuarios';
        $data['usuario'] = $this->model->getUsuario($this->id_usuario);
        $data['shares'] = $this->model->verificarEstado($this->correo);
        $this->views->getView('usuarios', 'perfil', $data);
    }
    public function cambiarPass()
    {
        $actual = $_POST['clave_actual'];
        $nueva = $_POST['clave_nueva'];
        $confirmar = $_POST['clave_confirmar'];
        if (empty($actual) || empty($nueva) || empty($confirmar)) {
            $res = array('tipo' => 'warning', 'mensaje' => 'Todos los campos son requeridos');
        } else {
            if ($nueva != $confirmar) {
                $res = array('tipo' => 'warning', 'mensaje' => 'Las contraseñas no coincden');
            } else {
                $consulta = $this->model->getUsuario($this->id_usuario);
                if (password_verify($actual, $consulta['clave'])) {
                    $hash = password_hash($nueva, PASSWORD_DEFAULT);
                    $data = $this->model->cambiarPass($hash, $this->id_usuario);
                    if ($data == 1) {
                        $res = array('tipo' => 'success', 'mensaje' => 'CONTRASEÑA MODIFICADA.');
                    } else {
                        $res = array('tipo' => 'error', 'mensaje' => 'ERROR AL MODIFICAR.');
                    }
                } else {
                    $res = array('tipo' => 'warning', 'mensaje' => 'CONTRASEÑA ACTUAL INCORRECTA');
                }
            }
            echo json_encode($res, JSON_UNESCAPED_UNICODE);
            die();
        }
}
public function cambiarProfile()
{
    $correo = $_POST['correo'];
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $telefono = $_POST['telefono'];
    $direccion = $_POST['direccion'];
    
    if (empty($correo) || empty($nombre) || empty($apellido) || empty($telefono) || empty($direccion)) {
        $res = array('tipo' => 'warning', 'mensaje' => 'Todos los campos son requeridos');
    } else {
        $usuario = $this->model->getUsuario($this->id_usuario);
        $data = $this->model->modificar($nombre, $apellido, $correo, $telefono, $direccion, $usuario['rol'], $this->id_usuario);
        
        if ($data == 1) {
            $res = array('tipo' => 'success', 'mensaje' => 'DATOS MODIFICADOS');
        } else {
            $res = array('tipo' => 'error', 'mensaje' => 'ERROR AL MODIFICAR.');
        }
    }
    
    echo json_encode($res, JSON_UNESCAPED_UNICODE);
    die();
}

        public function salir ()
        {
            session_destroy();
            header('Location: '. BASE_URL);
        }
    
}
