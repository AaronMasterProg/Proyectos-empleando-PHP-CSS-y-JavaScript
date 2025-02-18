<?php include_once 'Views/template/headerU.php'; ?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/signature_pad@2.3.2/dist/signature_pad.min.js"></script>
<script src="apps.js" defer></script>

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

            <center><h3>FORMATO DE ACLARACIÓN A LA CONVOCATORIA</h3></center>
                <hr>
                <form id="form">
                    <div class="mb-3">
                        <label for="convocatoria" class="form-label">Convocatoria No.</label>
                        <input type="text" class="form-control" id="convocatoria">
                    </div>

                    <div class="mb-3">
                        <label for="institucion" class="form-label">Institucion</label>
                        <input type="text" class="form-control" id="institucion">
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="preguntas" class="form-label">Preguntas de carácter administrativo</label>
                            <input type="text" class="form-control" id="preguntas">
                        </div>
                        <div class="col-md-6">
                            <label for="respuestas" class="form-label">Respuestas de carácter administrativo</label>
                            <input type="text" class="form-control" id="respuestas">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="preguntas2" class="form-label">Preguntas de carácter técnico</label>
                            <input type="text" class="form-control" id="preguntas2">
                        </div>
                        <div class="col-md-6">
                            <label for="respuestas2" class="form-label">Respuestas de carácter técnico</label>
                            <input type="text" class="form-control" id="respuestas2">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="preguntas3" class="form-label">Preguntas de carácter legal</label>
                            <input type="text" class="form-control" id="preguntas3">
                        </div>
                        <div class="col-md-6">
                            <label for="respuestas3" class="form-label">Respuestas de carácter legal</label>
                            <input type="text" class="form-control" id="respuestas3">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="cargo" class="form-label">Cargo</label>
                        <input type="text" class="form-control" id="cargo">
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