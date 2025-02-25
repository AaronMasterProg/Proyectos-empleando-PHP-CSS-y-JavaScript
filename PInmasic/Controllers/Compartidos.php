<?php
class Compartidos extends Controller
{
    private $id_usuario,$correo;
    public function __construct()
    {
        parent::__construct();
        session_start();
        $this->id_usuario =  $_SESSION['id'];
        $this->correo=  $_SESSION['correo'];
          ## VALIDAR SESION
  if (empty($_SESSION['id'])) {
    header ('Location:' .BASE_URL);
    exit;
  }
    }

    public function index()
    {
	if ($_SESSION['rol'] == 1) {
        $data['title'] = 'Archivos compartidos';
        $data ['script'] = 'compartidos.js';
        $data['menu'] = 'share';
        $data['archivos'] = $this->model->getArchivosCompartidos($this->correo);
        $data ['shares'] = $this->model->verificarEstado($this->correo);
        $this->views->getView('Admin', 'compartidos', $data);
	}elseif ($_SESSION['rol'] == 2) {
	$data['title'] = 'Archivos compartidos';
        $data ['script'] = 'compartidos.js';
        $data['menu'] = 'share';
        $data['archivos'] = $this->model->getArchivosCompartidos($this->correo);
        $data ['shares'] = $this->model->verificarEstado($this->correo);
        $this->views->getView('Usuario', 'compartidos', $data);
	}
	
    }
    public function verDetalle($id_detalle){
        $data = $this->model->getDetalle($id_detalle);
        if (empty ($data)) {
            $this->model->cambiarEstado(2,$id_detalle);
        }
        $data['fecha'] = time_ago(strtotime($data['fecha_add']));
        echo json_encode($data);
        die();
    }

    public function eliminar($id){
        $data=$this->model->cambiarEstado(0,$id);
        if ($data ==1) {
            $res = array('mensaje'=>'ARCHIVO ELIMINADO', 'tipo'=>'success');
        } else {
            $res = array('mensaje'=>'ERROR AL ELIMINAR', 'tipo'=>'error');
        }
        echo json_encode($res, JSON_UNESCAPED_UNICODE);
        die();
        
    }
}
  ?> 