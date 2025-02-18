const btnUpload = document.querySelector('#btnUpload');
const btnNuevaCarpeta = document.querySelector("#btnNuevaCarpeta");
const myModal = new bootstrap.Modal(document.querySelector("#modalFile"));
const myModal1 = new bootstrap.Modal(document.querySelector("#modalCarpeta"));
const frmCarpeta = document.querySelector('#frmCarpeta');

const btnSubirArchivo = document.querySelector('#btnSubirArchivo');
const file = document.querySelector('#file');

const myModal2 = new bootstrap.Modal(document.querySelector("#modalCompartir"));
const id_carpeta = document.querySelector('#id_carpeta');

const carpetas = document.querySelectorAll('.carpetas');
const btnSubir = document.querySelector('#btnSubir');

//eliminar carpeta
const btnEliminar = document.querySelector('#btnEliminar');

// Ver Archivos
const btnVer = document.querySelector('#btnVer');

// Compartir
const compartir = document.querySelectorAll('.compartir');
const myModalUser = new bootstrap.Modal(document.querySelector("#modalUsuarios"));
const frmCompartir = document.querySelector('#frmCompartir');
const usuarios = document.querySelector('#usuarios');

const btnCompartir = document.querySelector('#btnCompartir');
const container_archivos = document.querySelector('#container-archivos');
const btnVerDetalle = document.querySelector('#btnVerDetalle');
const content_acordeon = document.querySelector('#accordionFlushExample');

// Eliminar archivo recientes
const eliminar = document.querySelectorAll('.eliminar');
const modalArchivos = new bootstrap.Modal(document.querySelector("#modalArchivos"));

// Función genérica para realizar solicitudes AJAX
function hacerSolicitud(url, method, data, callback) {
    const http = new XMLHttpRequest();
    http.open(method, url, true);

    // Si es una solicitud POST con datos
    if (method === 'POST') {
        http.send(data);
    } else {
        http.send();
    }

    http.onreadystatechange = function () {
        if (this.readyState === 4) {
            callback(this);
        }
    };
}

document.addEventListener('DOMContentLoaded', function () {
    btnUpload.addEventListener('click', function () {
        myModal.show();
    });

    btnNuevaCarpeta.addEventListener('click', function () {
        myModal.hide();
        myModal1.show();
    });

    frmCarpeta.addEventListener('submit', function (e) {
        e.preventDefault();
        if (!frmCarpeta.nombre || frmCarpeta.nombre.value === '') {
            alertaPersonalizada('warning', 'EL NOMBRE ES REQUERIDO');
        } else {
            const data = new FormData(frmCarpeta);
            
            hacerSolicitud(base_url + 'Admin/crearcarpeta', 'POST', data, function (res) {
                if (res.status === 200) {
                    try {
                        const resultado = JSON.parse(res.responseText);
                        alertaPersonalizada(resultado.tipo, resultado.mensaje);
                        if (resultado.tipo === 'success') {
                            setTimeout(() => {
                                window.location.reload();
                            }, 1500);
                        }
                    } catch (error) {
                        console.error("Error al parsear la respuesta:", error);
                    }
                } else {
                    console.error("Error al crear la carpeta:", res.statusText);
                }
            });
        }
    });

    // Subir Archivo
    btnSubirArchivo.addEventListener('click', function () {
        myModal.hide();
        modalArchivos.show();
    })

    carpetas.forEach(carpeta => {
        carpeta.addEventListener('click', function (e) {
            id_carpeta.value = e.target.id;
            myModal2.show();
        });
    });

    btnSubir.addEventListener('click', function () {
        myModal2.hide();
        modalArchivos.show();
    });

    btnVer.addEventListener('click', function () {
        window.location = base_url + 'Admin/ver/' + id_carpeta.value;
    });

    //ELIminar carpetas 
    /*btnEliminar.addEventListener('click', function () {
       
            let id = btnEliminar.getAttribute('data-id');
            const url = base_url + 'archivos/eliminarCarpetas' + id;
            eliminarRegistro('¿Está seguro de eliminar?', 'El archivo se eliminará de forma permanente en 30 días',
                'Sí, ELIMINAR', url, null);

    });*/


    // Se ve el cuadro de compartir
    $(".js-states").select2({
        theme: 'bootstrap-5',
        placeholder: 'Buscar y agregar usuarios',
        maximumSelectionLength: 5,
        minimumInputLength: 2,
        dropdownParent: $('#modalUsuarios'),
        ajax: {
            url: base_url + 'archivos/getUsuarios',
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return { q: params.term };
            },
            processResults: function (data) {
                return { results: data };
            },
            cache: true
        }
    });

    // Agregar click al enlace compartido
    compartir.forEach(enlace => {
        enlace.addEventListener('click', function (e) {
            compartirArchivo(e.target.id);
        });
    });

    frmCompartir.addEventListener('submit', function (e) {
        e.preventDefault();
        if (usuarios.value === '') {
            alertaPersonalizada('warning', 'TODOS LOS CAMPOS SON REQUERIDOS');
        } else {
            const data = new FormData(frmCompartir);
            hacerSolicitud(base_url + 'archivos/compartir', 'POST', data, function (res) {
                if (res.status === 200) {
                    const resultado = JSON.parse(res.responseText);
                    alertaPersonalizada(resultado.tipo, resultado.mensaje);
                    if (resultado.tipo === 'success') {
                        $('.js-states').val(null).trigger('change');
                        myModalUser.hide();
                    }
                } else {
                    console.error("Error al compartir:", res.statusText);
                }
            });
        }
    });

    // Compartir archivos por carpeta
    btnCompartir.addEventListener('click', function () {
        verArchivos();
    });

    // VER DETALLE COMPARTIDO
    btnVerDetalle.addEventListener('click', function () {
        window.location = base_url + 'Admin/verdetalle/' + id_carpeta.value;
    });

    // Eliminar archivo reciente
    eliminar.forEach(enlace => {
        enlace.addEventListener('click', function (e) {
            let id = e.target.getAttribute('data-id');
            const url = base_url + 'archivos/eliminar/' + id;
            eliminarRegistro('¿Está seguro de eliminar?', 'El archivo se eliminará de forma permanente en 30 días',
                'Sí, ELIMINAR', url, null);
        });
    });
});

// INICIAR DROPZONE
Dropzone.options.uploadForm = { 
    dictDefaultMessage: 'ARRASTRAR Y SOLTAR ARCHIVO',
    dictRemoveFile: 'ELIMINAR',
    autoProcessQueue: false,
    uploadMultiple: true,
    parallelUploads: 10,
    maxFiles: 10,
    addRemoveLinks: true,

    init: function() {
        var myDropzone = this;
        document.querySelector("#btnProcesar").addEventListener("click", function(e) {
            e.preventDefault();
            e.stopPropagation();
            myDropzone.processQueue();
        });
        this.on("successmultiple", function(files, response) {
            setTimeout(() => {
                window.location.reload();
            }, 1500);
        });
    }
}

// FIN DROPZONE

// Función para compartir archivo
function compartirArchivo(id) {
    const http = new XMLHttpRequest();
    const url = base_url + 'archivos/buscarCarpeta/' + id; // Usar id aquí
    http.open("GET", url, true);
    http.send();
    http.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            const res = JSON.parse(this.responseText);
            console.log(this.responseText);
            id_carpeta.value = res.id_carpeta; // Asegúrate de que res.id_carpeta exista
            content_acordeon.classList.add('d-none');
            container_archivos.innerHTML = `<input type="hidden" value="${res.id}" name="archivos[]">`;
            myModalUser.show();
        } else if (this.readyState === 4) {
            console.error("Error al buscar carpeta:", this.statusText);
        }
    };
}

// Función para ver archivos
function verArchivos() {
    const http = new XMLHttpRequest();
    const url = base_url + 'archivos/verArchivos/' + id_carpeta.value;
    http.open("GET", url, true);
    http.send();
    http.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            const res = JSON.parse(this.responseText);
            let html = '';
            if (res.length > 0) {
                content_acordeon.classList.remove('d-none');
                res.forEach(archivo => {
                    html += `<div class="form-check">
                        <input class="form-check-input" type="checkbox" value="${archivo.id}"
                        name="archivos[]"
                        id="flexCheckDefault_${archivo.id}">
                        <label class="form-check-label" for="flexCheckDefault_${archivo.id}">
                        ${archivo.nombre}
                        </label>
                    </div>`;
                });
                container_archivos.innerHTML = html;
            } else {
                alertaPersonalizada('info', 'No hay archivos en esta carpeta');
            }
        } else if (this.readyState === 4) {
            console.error("Error al ver archivos:", this.statusText);
        }
    };

    
}
