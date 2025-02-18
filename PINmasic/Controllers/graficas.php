<?php
class graficas extends Controller
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
        $data['menu'] = 'graficas';
        $data['active'] = 'todos';
        $data['script'] = 'barra.js';
        $this->views->getView('graficas','barra', $data);
	}elseif ($_SESSION['rol'] == 2) {
	$data['title'] = 'Archivos';
        $data['menu'] = 'graficas';
        $data['active'] = 'todos';
        $data['script'] = 'barra.js';
        $this->views->getView('graficasU','barra', $data);
	}

    }

}

?>
