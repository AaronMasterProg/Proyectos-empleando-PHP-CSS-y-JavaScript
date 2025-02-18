<?php
session_start(); // Inicia la sesión
// Verificar que el ID está presente en la URL
if (isset($_GET['id'])) {
    $id_carpeta = $_GET['id'];
    echo $id_carpeta;    
    if (is_numeric($id_carpeta)) {

        // Fecha actual y fecha futura (1 mes después)
        $fecha = date('Y-m-d H:i:s');
        $nueva = date("Y-m-d H:i:s", strtotime($fecha . '+1 month'));

        // Conexión a la base de datos usando PDO
        try {
            $pdo = new PDO('mysql:host=localhost;dbname=gestion_archivos', 'root', 'root');
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Consulta SQL con parámetros preparados
            $sql = "UPDATE archivos SET estado = 0, elimina = :nueva WHERE id = :id_carpeta";
            $stmt = $pdo->prepare($sql);

            // Asignación de parámetros
            $stmt->bindParam(':nueva', $nueva);
            $stmt->bindParam(':id_carpeta', $id_carpeta, PDO::PARAM_INT);

            // Ejecutar la consulta
            $stmt->execute();

            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit;
        } catch (PDOException $e) {
            // Manejo de errores en la conexión o consulta
            echo "Error: " . $e->getMessage();
        }

    } else {
        echo "ID de carpeta no válido.";
    }
} else {
    echo "ID de carpeta no especificado.";
}
?>
