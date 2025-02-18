<?php
class Formato extends Controller
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
	if ($_SESSION['rol'] == 1) {
        $data['title'] = 'Archivos';
        $data['menu'] = 'formato';
        $data['active'] = 'todos';
        $data['script'] = 'apps.js';
        $this->views->getView('formato','index', $data);
	}elseif ($_SESSION['rol'] == 2) {
	$data['title'] = 'Archivos';
        $data['menu'] = 'formato';
        $data['active'] = 'todos';
        $data['script'] = 'apps.js';
        $this->views->getView('formatoU','index', $data);
	}
    }
}

?>
