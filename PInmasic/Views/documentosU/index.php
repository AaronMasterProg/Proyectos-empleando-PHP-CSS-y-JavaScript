<?php include_once 'Views/template/headerU.php'; ?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/signature_pad@2.3.2/dist/signature_pad.min.js"></script>
<script src="app.js" defer></script>

<div class="app-content">
    <?php include_once 'Views/components/menusU.php'; ?>
    <div class="content-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <div class="page-description d-flex align-items-center">
                        <div class="page-description-content flex-grow-1">
                            <!--<h1>Generar Documento</h1>-->
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
            <div class="col-md-12 offset-md-0 bg-white p-5 rounded">

                    <center><h3>RELACIÓN CONTRACTUAL</h3></center>
                    <hr>
                    <form id="form">
                        <div class="mb-3">
                            <label for="institucion" class="form-label">Institucion.</label>
                            <input type="text" class="form-control" id="institucion">
                        </div>

                        <div class="mb-3">
                            <label for="procedimiento" class="form-label">Tipo de procedimiento</label>
                            <input type="text" class="form-control" id="procedimiento">
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="compranet" class="form-label">Numero de Compranet</label>
                                <input type="text" class="form-control" id="compranet">
                            </div>
                            <div class="col-md-6">
                                <label for="interno" class="form-label">Numero Interno</label>
                                <input type="text" class="form-control" id="interno">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="contrato" class="form-label">Numero de contrato</label>
                                <input type="text" class="form-control" id="contrato">
                            </div>
                            <div class="col-md-6">
                                <label for="servicio" class="form-label">Descripcion de servicio</label>
                                <input type="text" class="form-control" id="servicio">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="convenio" class="form-label">Convenio modificado al numero de contrato</label>
                                <input type="text" class="form-control" id="convenio">
                            </div>
                            <div class="col-md-6">
                                <label for="servicio1" class="form-label">Descripcion de servicio</label>
                                <input type="text" class="form-control" id="servicio1">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="contrato1" class="form-label">Numero de contrato</label>
                                <input type="text" class="form-control" id="contrato1">
                            </div>
                            <div class="col-md-6">
                                <label for="servicio2" class="form-label">Descripcion de servicio</label>
                                <input type="text" class="form-control" id="servicio2">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="convenio1" class="form-label">Convenio modificado al numero de contrato</label>
                                <input type="text" class="form-control" id="convenio1">
                            </div>
                            <div class="col-md-6">
                                <label for="servicio3" class="form-label">Descripcion de servicio</label>
                                <input type="text" class="form-control" id="servicio3">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="contrato2" class="form-label">Numero de contrato</label>
                                <input type="text" class="form-control" id="contrato2">
                            </div>
                            <div class="col-md-6">
                                <label for="servicio4" class="form-label">Descripcion de servicio</label>
                                <input type="text" class="form-control" id="servicio4">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="contrato3" class="form-label">Numero de contrato</label>
                                <input type="text" class="form-control" id="contrato3">
                            </div>
                            <div class="col-md-6">
                                <label for="servicio5" class="form-label">Descripcion de servicio</label>
                                <input type="text" class="form-control" id="servicio5">
                            </div>
                        </div>

                        <span class="d-block pb-2">Firma digital aquí</span>
                        <div class="signature mb-2" style="width: 100%; height: 200px;">
                            <canvas id="signature-canvas" style="border: 2px dashed rgb(0, 30, 255); width: 100%; height: 200px;"></canvas>
                        </div>

                        <center><button type="submit" class="btn btn-primary mb-4">Generar PDF</button></center>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php 
include_once 'Views/components/modal.php'; 
include_once 'Views/template/footer.php'; 
?>