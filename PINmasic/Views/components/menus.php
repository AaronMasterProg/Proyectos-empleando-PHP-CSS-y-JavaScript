<a href="#" class="content-menu-toggle btn btn-primary"><i class="material-icons">menu</i> contenido</a>
    <div class="content-menu content-menu-right">
        <ul class="list-unstyled">
            <!--<li><a href="<?php //echo BASE_URL . 'archivos/pagina'; ?>" class="<?php //echo($data['active'] == 'todos') ? 'active' : '' ;?>" >Todos</a></li>-->
            <li><a href="<?php echo BASE_URL . 'Admin'; ?>" class="<?php echo($data['active'] == 'recent') ? 'active' : '' ;?>">Todos</a></li>
            <li><a href="<?php echo BASE_URL . 'archivos/recicle'; ?>" class="<?php echo($data['active'] == 'deleted') ? 'active' : '' ;?>">Eliminados</a></li>
            <li class="divider"></li>
            <li><a href="<?php echo BASE_URL . 'usuarios'; ?>" class="<?php echo($data['active'] == 'detail') ? 'active' : '' ;?>">Detalles</a></li>           
        </ul>
    </div>