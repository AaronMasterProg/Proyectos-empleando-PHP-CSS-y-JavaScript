<?php include_once 'Views/template/header.php'; 
?>

<?php
// Verificar si el usuario está logueado
if (empty($_SESSION['id'])) {
    header('Location: login.php'); // Redirigir si no está logueado
    exit;
}

$id_usuario = $_SESSION['id'];

// Conectar a la base de datos
$pdo = new PDO('mysql:host=localhost;dbname=gestion_archivos', 'root', 'root');
$sql = "SELECT * FROM carpetas WHERE id_usuario = :id_usuario AND estado = 1 AND id != 1 ORDER BY id DESC";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
$stmt->execute();
$carpetas = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="app-content">
    <?php include_once 'Views/components/menus.php'; ?>
    <div class="content-wrapper">
        <div class="container-fluid">
            <div class="section-description">
                <h1>Archivos Recientes</h1>
            </div>
            <div class="row">
                <?php foreach ($data['archivos'] as $archivo) { ?>
                    <div class="col-md-6">
                        <div class="card file-manager-recent-item">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <i class="material-icons-outlined text-danger align-middle m-r-sm">description</i>
                                    <a href="<?php echo BASE_URL . 'Views/archivos/ver_archivo.php?archivo=' . urlencode($archivo['id_carpeta'] . '/' . $archivo['nombre']); ?>"
                                        target="_blank" class="file-manager-recent-item-title flex-fill">
                                        <?php echo $archivo['nombre']; ?>
                                    </a>
                                    <span class="p-h-sm">167kb</span>
                                    <span class="p-h-sm text-muted">09.14.21</span>
                                    <a href="#" class="dropdown-toggle file-manager-recent-file-actions"
                                        id="file-manager-recent-<?php echo $archivo['id']; ?>" data-bs-toggle="dropdown"
                                        aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                    <ul class="dropdown-menu dropdown-menu-end"
                                        aria-labelledby="file-manager-recent-<?php echo $archivo['id']; ?>">
                                        <li><a class="dropdown-item compartir" href="#"
                                                id="<?php echo $archivo['id']; ?>">Compartir</a></li>
                                        <li><a class="dropdown-item"
                                                href="<?php echo BASE_URL . 'Assets/archivos/' . $archivo['id_carpeta'] . '/' . $archivo['nombre']; ?>"
                                                download="<?php echo $archivo['nombre']; ?>">Descargar</a></li>                                			
					<li><a class="dropdown-item eliminar" href="#" data-id="<?php echo $archivo['id']; ?>">Eliminar</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>

            </div>

            <div class="row">
                <div class="col">
                    <div class="page-description d-flex align-items-center">
                        <div class="page-description-content flex-grow-1">
                            <h1>Archivos</h1>
                        </div>
                        <div class="page-description-actions">
                            <a href="#" class="btn btn-primary" id="btnUpload"><i
                                    class="material-icons">add</i>Carpetas</a>			    
                        </div>
                    </div>
                </div>
            </div>

            <div id="container_progress" class="mb-3"></div>
            <div class="row">
                <?php foreach ($data['carpetas'] as $carpeta) { ?>
                    <div class="col-md-4">
                        <div class="card file-manager-group">
                            <div class="card-body d-flex align-items-center">
                                <i class="material-icons" style="color: #<?php echo $carpeta['color']; ?>;">folder</i>
                                <div class="file-manager-group-info flex-fill">
                                    <a href="#" id="<?php echo $carpeta['id']; ?>"
                                        class="file-manager-group-title carpetas"><?php echo $carpeta['nombre']; ?></a>					    
                                    <span class="file-manager-group-about"><?php echo $carpeta['fecha']; ?></span>
				    <button type="button" id="btnEliminar" class="btn btn-outline-danger btn-sm m-r-xs" onclick="window.location.href='http://localhost/PInmasic/Views/Extra/Eliminar.php?id=<?php echo $carpeta['id']; ?>'">
		    <i class="material-icons">delete</i>Eliminar
		    </button>		    		    
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
	    </div>


    </div>
</div>

<?php 
include_once 'Views/components/modal.php';
include_once 'Views/template/footer.php';
?>


