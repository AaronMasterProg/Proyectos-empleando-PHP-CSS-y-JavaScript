<?php
class Archivos extends Controller
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
            header('Location:' . BASE_URL);
            exit;
        }
    }

    public function pagina($page)
    {
        $data['title'] = 'Archivos';
        $data['active'] = 'todos';
        $data['script'] = 'file.js';

        ##PAGINACION
        $pagina = (empty($page)) ? 1 : $page;
        $porPagina = 100;
        $desde = ($pagina - 1) * $porPagina;
        $carpetas = $this->model->getCarpetas($desde, $porPagina, $this->id_usuario);

        for ($i = 0; $i < count($carpetas); $i++) {
            $carpetas[$i]['color'] = substr(md5($carpetas[$i]['id']), 0, 6);
            $carpetas[$i]['fecha'] = time_ago(strtotime($carpetas[$i]['fecha_create']));
        }

        ##TOTAL CARPETAS
        $totalDir = $this->model->getTotalCarpetas($this->id_usuario);
        $data ['total']= ceil($totalDir['total']/$porPagina);
        $data ['pagina']= $pagina;

        $data['carpetas'] = $carpetas;
        $data['menu'] = 'Admin';
        $data['shares'] = $this->model->verificarEstado($this->correo);
        $this->views->getView('archivos', 'index', $data);
    }


    public function getUsuarios()
    {
        $valor = $_GET['q'];
        $data = $this->model->getUsuarios($valor, $this->id_usuario);
        for ($i = 0; $i < count($data); $i++) {
            $data[$i]['text'] = $data[$i]['correo'];
        }
        echo json_encode($data);
        die();
    }
    public function compartir()
    {
        $usuarios = $_POST['usuarios'];

        // Verificar si se enviaron archivos en el POST
        if (empty($_POST['archivos'])) {
            // Si no se seleccionaron archivos, enviar una respuesta de advertencia
            $res = array('tipo' => 'warning', 'mensaje' => 'SELECCIONE UN ARCHIVO');
        } else {
            $archivos = $_POST['archivos'];
            $res = 0; // Inicializar variable de control para el proceso de compartir

            for ($i = 0; $i < count($archivos); $i++) {
                for ($j = 0; $j < count($usuarios); $j++) {
                    // Obtener el usuario por el ID del array 'usuarios'
                    $dato = $this->model->getUsuario($usuarios[$j]);

                    // Verificar si el archivo ya ha sido compartido con este usuario
                    $result = $this->model->getDetalle($dato['correo'], $archivos[$i]);

                    if (empty($result)) {
                        // Si no existe registro previo, proceder a registrar el archivo compartido
                        $res = $this->model->registrarDetalle($dato['correo'], $archivos[$i], $this->id_usuario);
                    } else {
                        // Si ya existe el archivo compartido, indicarlo
                        $res = 1;
                    }
                }
            }

            // Revisar el estado de $res para enviar el mensaje adecuado
            if ($res > 0 && $res !== 1) {
                // Si se compartió exitosamente, enviar respuesta de éxito
                $res = array('tipo' => 'success', 'mensaje' => 'Archivos compartidos exitosamente');
            } elseif ($res == 1) {
                // Si el archivo ya había sido compartido
                $res = array('tipo' => 'info', 'mensaje' => 'Algunos archivos ya estaban compartidos');
            } else {
                // Si ocurrió un error durante el proceso
                $res = array('tipo' => 'error', 'mensaje' => 'Error al compartir los archivos');
            }

            // Devolver la respuesta como JSON
            echo json_encode($res, JSON_UNESCAPED_UNICODE);
            die();
        }
    }


    public function verArchivos($id_carpeta)
    {
        $data = $this->model->getArchivosCarpeta($id_carpeta);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function buscarCarpeta($id)
    {
        $data = $this->model->getCarpeta($id);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
   public function eliminar($id)
    {	    
        $fecha = date('Y-m-d H:i:s');
        $nueva = date("Y-m-d H:i:s", strtotime($fecha . '+1 month'));
        $data = $this->model->eliminar(0, $nueva, $id);	
        if ($data == 1) {
            $res = array('tipo' => 'success', 'mensaje' => 'Archivo compartido eliminado');
        } else {
            $res = array('tipo' => 'error', 'mensaje' => 'Error al eliminar');
        }
        echo json_encode($res);
        die();
    }   

    //ELIMINAR ARCHIVOS COMPARTIDOS 
    
    public function eliminarCompartido($id)
    {	    
        $fecha = date('Y-m-d H:i:s');
        $nueva = date("Y-m-d H:i:s", strtotime($fecha . '+1 month'));
        $data = $this->model->eliminar(0, $nueva, $id);	
        if ($data == 1) {
            $res = array('tipo' => 'success', 'mensaje' => 'Archivo compartido eliminado');
        } else {
            $res = array('tipo' => 'error', 'mensaje' => 'Error al eliminar');
        }
        echo json_encode($res);
        die();
    }   

    public function busqueda($valor)
    {
        $data = $this->model->getBusqueda($valor, $this->id_usuario);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function recicle()
    {
        $data['title'] = 'Archivos Eliminados';
        $data['active'] = 'deleted';
        $data['script'] = 'deleted.js';
        $data['menu'] = 'Admin';
        $data['shares'] = $this->model->verificarEstado($this->correo);
        $this->views->getView('archivos', 'deleted', $data);
    }

    public function listarHistorial()
    {
        $data = $this->model->getArchivos(0, $this->id_usuario);
        for ($i = 0; $i < count($data); $i++) {
            $data[$i]['accion'] = '<a href="#" class="btn btn-danger btn-sm" onclick="restaurar(' . $data[$i]['id'] . ')">
                Restaurar
                </a>';
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    function delete($id)
    {
        $data = $this->model->eliminar(1, null, $id);
        if ($data == 1) {
            $res = array('tipo' => 'success', 'mensaje' => 'Archivo Restaurado');
        } else {
            $res = array('tipo' => 'error', 'mensaje' => 'Error al Restaurar');
        }
        echo json_encode($res, JSON_UNESCAPED_UNICODE);
        die();
    }   
    
}