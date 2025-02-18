<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Responsive Admin Dashboard Template">
    <meta name="keywords" content="Admin,dashboard">
    <meta name="author" content="stacks">
    <title><?php echo htmlspecialchars($data['title']); ?></title>

    <!-- Google Fonts and Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Material+Icons|Material+Icons+Outlined|Material+Icons+Two+Tone|Material+Icons+Round|Material+Icons+Sharp" rel="stylesheet">

    <!-- Stylesheets -->
    <link href="<?php echo BASE_URL . 'Assets/plugins/bootstrap/css/bootstrap.min.css'; ?>" rel="stylesheet">
    <link href="<?php echo BASE_URL . 'Assets/plugins/perfectscroll/perfect-scrollbar.css'; ?>" rel="stylesheet">
    <link href="<?php echo BASE_URL . 'Assets/plugins/pace/pace.css'; ?>" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css">
    <link href="<?php echo BASE_URL . 'Assets/plugins/DataTables/datatables.min.css'; ?>" rel="stylesheet">
    <link href="<?php echo BASE_URL . 'Assets/css/select2.min.css'; ?>" rel="stylesheet">
    <link href="<?php echo BASE_URL . 'Assets/css/select2-bootstrap-5-theme.rtl.min.css'; ?>" rel="stylesheet">
    <link href="<?php echo BASE_URL . 'Assets/css/main.css'; ?>" rel="stylesheet">
    <link href="<?php echo BASE_URL . 'Assets/css/custom.css'; ?>" rel="stylesheet">
    <link href="<?php echo BASE_URL . 'Assets/js/jspdf.min.js'; ?>" rel="stylesheet">


    <!-- Support for older versions of IE -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>
    <div class="app align-content-stretch d-flex flex-wrap">

        <!-- Sidebar -->
        <div class="app-sidebar">
            <div class="logo">
                <a href="#" class="logo-icon"><span class="logo-text">Inmasic</span></a>
                <div class="sidebar-user-switcher user-activity-online">
                    <a href="#">
                        <img src="<?php echo BASE_URL . 'Assets/images/logo.jpeg'; ?>" alt="Logo">
                        <span class="activity-indicator"></span>
                        <span class="user-info-text"><?php echo htmlspecialchars($_SESSION['nombre']); ?><br>
                            <span class="user-state-info"><?php echo htmlspecialchars($_SESSION['correo']); ?></span></span>
                    </a>
                </div>
            </div>

            <!-- Sidebar Menu -->
            <div class="app-menu">
                <ul class="accordion-menu">
                    <li class="sidebar-title">Aplicaciones</li>
                    <li class="<?php echo ($data['menu'] == 'usuarios') ? 'active-page' : ''; ?>">
                        <a href="<?php echo BASE_URL . 'usuarios'; ?>" class="<?php echo ($data['menu'] == 'usuarios') ? 'active' : ''; ?>">
                            <i class="material-icons">people_alt</i>Usuarios
                        </a>
                    </li>
                    <li class="<?php echo ($data['menu'] == 'share') ? 'active-page' : ''; ?>">
    <a href="<?php echo BASE_URL . 'compartidos'; ?>" class="<?php echo ($data['menu'] == 'share') ? 'active' : ''; ?>">
        <i class="material-icons-two-tone">inbox</i>Compartidos
        <span class="badge badge-danger badge-large float-end">1</span>
    </a>
</li>

                    <li class="<?php echo ($data['menu'] == 'Admin') ? 'active-page' : ''; ?>">
                        <a href="<?php echo BASE_URL . 'Admin'; ?>" class="<?php echo ($data['menu'] == 'Admin') ? 'active' : ''; ?>">
                            <i class="material-icons-two-tone">cloud_queue</i>Administradora de Archivos
                        </a>
                    </li>
                    <li class="<?php echo ($data['menu'] == 'documentos') ? 'active-page' : ''; ?>">
                        <a href="<?php echo BASE_URL . 'documentos'; ?>" class="<?php echo ($data['menu'] == 'documentos') ? 'active' : ''; ?>">
                            <i class="material-icons-two-tone" style="color: grey;">folder</i>Archivo Relacion
                        </a>
                    </li>
                    <li class="<?php echo ($data['menu'] == 'formato') ? 'active-page' : ''; ?>">
                        <a href="<?php echo BASE_URL . 'formato'; ?>" class="<?php echo ($data['menu'] == 'formato') ? 'active' : ''; ?>">
                            <i class="material-icons-two-tone" style="color: green;">folder</i>Formato Aclaracion
                        </a>
                    </li>

                    <li class="<?php echo ($data['menu'] == 'graficas') ? 'active-page' : ''; ?>">
                        <a href="<?php echo BASE_URL . 'graficas'; ?>" class="<?php echo ($data['menu'] == 'graficas') ? 'active' : ''; ?>">
                            <i class="material-icons-two-tone" style="color: red;">bar_chart</i>Graficas de publicaciones
                        </a>
                    </li>


                </ul>
            </div>
        </div>

        <!-- Main Container -->
        <div class="app-container">

            <!-- Search Bar -->
            <div class="search">
                <form>
                    <input class="form-control" id="inputBusqueda" type="text" placeholder="Buscar..." aria-label="Search">
                    <div id="container-result"></div>
                </form>
                <a href="#" class="toggle-search"><i class="material-icons">close</i></a>
            </div>

            <!-- Header -->
            <div class="app-header">
                <nav class="navbar navbar-light navbar-expand-lg">
                    <div class="container-fluid">
                        <div class="navbar-nav" id="navbarNav">
                            <ul class="navbar-nav">
                                <li class="nav-item">
                                    <a class="nav-link hide-sidebar-toggle-button" href="#"><i class="material-icons">first_page</i></a>
                                </li>
                            
                            </ul>
                        </div>
                        <div class="d-flex">
                            <ul class="navbar-nav">
                                <li class="nav-item">
                                    <a class="nav-link toggle-search" href="#"><i class="material-icons">search</i></a>
                                </li>
                                <li class="nav-item hidden-on-mobile">
                                    <a class="nav-link language-dropdown-toggle" href="#" id="languageDropDown" data-bs-toggle="dropdown"><img src="<?php echo BASE_URL . 'Assets/images/busqueda1.png'; ?>" alt=""></a>
                                    <ul class="dropdown-menu dropdown-menu-end language-dropdown" aria-labelledby="languageDropDown">
                                        <li><a class="dropdown-item" href="<?php echo BASE_URL . 'usuarios/profile'; ?>"><i class="material-icons">account_circle</i>Perfil</a></li>
                                        <li><a class="dropdown-item" href="<?php echo BASE_URL . 'usuarios/salir'; ?>"><i class="material-icons">power_settings_new</i>Salir</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
            </div>
           