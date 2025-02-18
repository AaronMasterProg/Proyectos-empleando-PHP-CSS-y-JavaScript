<?php
class CompartidosModel extends Query
{
    public function __construct()
    {
        parent::__construct();
    }

    

    public function getDetalle($id_detalle)
    {
        $sql = "SELECT d.id, d.fecha_add, d.correo, a.nombre, a.tipo, a.id_carpeta, u.correo AS compartido, u.nombre AS usuario
                FROM detalle_archivos d 
                INNER JOIN archivos a ON d.id_archivo = a.id 
                INNER JOIN carpetas c ON a.id_carpeta = c.id INNER JOIN  usuarios u ON d.id_usuario= u.id
                WHERE d.id = $id_detalle";
        return $this->select($sql);
    }
    public function cambiarEstado($estado,$id) {
        $sql="UPDATE detalle_archivos SET estado = ? WHERE id = ?";
       return $this->save($sql, [$estado,$id]);
        
    }
   ###VER TOTAL ARCHIVOS COMPARTIDOS
   public function verificarEstado($correo) {
    $sql = "SELECT COUNT(id) AS total FROM detalle_archivos d WHERE correo = '$correo' AND estado=1";
    return $this->select($sql);
}
}

