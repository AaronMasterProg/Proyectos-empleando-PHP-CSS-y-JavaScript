<?php
if (isset($_GET['archivo'])) {
    $archivo = urldecode($_GET['archivo']);
    $ruta = '../../Assets/archivos/' . $archivo;

    if (file_exists($ruta)) {
        $extension = pathinfo($ruta, PATHINFO_EXTENSION);
        $tipos_visibles = ['pdf', 'jpg', 'jpeg', 'png']; // Extensiones compatibles

        if (in_array(strtolower($extension), $tipos_visibles)) {
            $tipo = mime_content_type($ruta);
            header("Content-Type: $tipo");
            header("Content-Disposition: inline; filename=\"" . basename($archivo) . "\"");
            readfile($ruta);
            exit;
        } else {
            echo "Este tipo de archivo no es compatible para visualizarse.";
        }
    } else {
        echo "El archivo no existe.";
    }
} else {
    echo "No se ha proporcionado un archivo.";
}
?>
