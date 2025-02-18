<?php
class Documentos extends Controller
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
        $data['menu'] = 'documentos';
        $data['active'] = 'todos';
        $data['script'] = 'app.js';
        $this->views->getView('documentos','index', $data);
	}elseif ($_SESSION['rol'] == 2) {
	$data['title'] = 'Archivos';
        $data['menu'] = 'documentos';
        $data['active'] = 'todos';
        $data['script'] = 'app.js';
        $this->views->getView('documentosU','index', $data);
	}
    }

}

?>
