<?php
session_start(); // Inicia la sesión

// Verificar si el id de la carpeta fue pasado correctamente por GET
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id_carpeta = $_GET['id'];

    // Verificar si el usuario está logueado
    if (empty($_SESSION['id'])) {
        header('Location: login.php'); // Redirigir si no está logueado
        exit;
    }

    $id_usuario = $_SESSION['id'];

    // Conectar a la base de datos
    try {
        $pdo = new PDO('mysql:host=localhost;dbname=gestion_archivos', 'root', 'root');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Preparar la consulta SQL para actualizar el estado de la carpeta
        $sql = "UPDATE carpetas SET estado = 0 WHERE id = :id_carpeta AND id_usuario = :id_usuario";
        
        // Preparar la sentencia
        $stmt = $pdo->prepare($sql);
        
        // Vincular los parámetros :id_carpeta y :id_usuario
        $stmt->bindParam(':id_carpeta', $id_carpeta, PDO::PARAM_INT);
        $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
        
        // Ejecutar la consulta
        $stmt->execute();
        
        // Redirigir al usuario a la página anterior
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit;

    } catch (PDOException $e) {
        // Manejo de errores
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "No se ha proporcionado un ID de carpeta válido.";
}
?>
