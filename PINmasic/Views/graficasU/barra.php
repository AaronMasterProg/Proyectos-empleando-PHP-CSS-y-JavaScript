<?php include_once 'Views/template/headerU.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.0.2/dist/chart.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<div class="app-content">
    <?php include_once 'Views/components/menusU.php'; ?>
    <?php
    include_once 'php/conexion.php';

    // Consulta para obtener los datos de la tabla `publicaciones`
    $query = $con->query("
    SELECT titulo, id FROM publicaciones");

    // Procesamiento de los resultados
    $titulos = array();
    $valores = array();

    foreach ($query as $row) {
        $titulos[] = $row['titulo'];
        $valores[] = $row['id'];
    }
    ?>
    <div class="content-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <div class="page-description d-flex align-items-center">
                        <div class="page-description-content flex-grow-1">
                            <center>
                                <h1>Gráfica de licitaciones</h1>
                            </center>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">informe licitaciones</h3>
                        </div>
                        <div class="card-body">
                            <div class="chart">
                                <canvas id="myChart"
                                    style="min-height: 250px; height: 300px; max-height: 350px; width: 100%;">
                                </canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <script>
                // Datos dinámicos desde PHP
                const labels = <?php echo json_encode($titulos); ?>;
                const data = {
                    labels: labels,
                    datasets: [{
                        label: 'ID de Publicaciones',
                        data: <?php echo json_encode($valores); ?>,
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(153, 102, 255, 0.2)',
                            'rgba(255, 159, 64, 0.2)'
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)'
                        ],
                        borderWidth: 1
                    }]
                };

                // Configuración del gráfico
                const config = {
                    type: 'bar',
                    data: data,
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                            /*responsive: true,
                            plugins: {
                                legend: {
                                    position: 'top',
                                },
                            },
                            scales: {
                                y: {
                                    beginAtZero: true
                                }*/
                        }
                    },
                };

                // Creación del gráfico
                new Chart(
                    document.getElementById('myChart'),
                    config
                );
            </script>
        </div>
    </div>
</div>
</div>
</div>

<?php
include_once 'Views/components/modal.php';
include_once 'Views/template/footer.php';
?>