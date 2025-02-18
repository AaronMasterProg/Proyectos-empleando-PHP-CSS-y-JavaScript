const frm = document.querySelector('#formulario');
const btnNuevo = document.querySelector('#btnNuevo');
const title = document.querySelector('#title');
const modalRegistro = document.querySelector("#modalRegistro");
const myModal = new bootstrap.Modal(modalRegistro);

let tblUsuarios;

document.addEventListener('DOMContentLoaded', function () {
    tblUsuarios = $('#tblUsuarios').DataTable({
        ajax: {
            url: base_url + 'usuarios/listar',
            dataSrc: ''
        },
        columns: [
            { data: 'acciones' },
            { data: 'id' },
            { data: 'nombres' },
            { data: 'correo' },
            { data: 'telefono' },
            { data: 'direccion' },
            { data: 'perfil' },
            { data: 'fecha' },
        ],
        language: {
            url: 'https://cdn.datatables.net/plug-ins/2.1.3/i18n/es-MX.json'
        },
        responsive: true,
        order: [[1, 'desc']]
    });

    btnNuevo.addEventListener('click', function () {
        title.textContent = 'NUEVO USUARIO';
        frm.id_usuario.value = '';
        frm.reset();
        frm.clave.removeAttribute('readonly');
        myModal.show();
    });

    // REGISTRAR USUARIO POR AJAX
    frm.addEventListener('submit', function (e) {
        e.preventDefault();
        if (frm.nombre.value == '' || frm.apellido.value == '' ||
            frm.correo.value == '' || frm.telefono.value == '' ||
            frm.direccion.value == '' || frm.clave.value == '' ||
            frm.rol.value == '') {
            alertaPersonalizada('warning', 'TODOS LOS CAMPOS SON REQUERIDOS');
        } else {
            const data = new FormData(frm);
            const http = new XMLHttpRequest();
            const url = base_url + 'usuarios/guardar';

            http.open("POST", url, true);
            http.send(data);

            http.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    const res = JSON.parse(this.responseText);
                    alertaPersonalizada(res.tipo, res.mensaje);
                    if (res.tipo === 'success') {
                        myModal.hide();
                        frm.reset();
                        tblUsuarios.ajax.reload();  // Recargar la tabla después de guardar
                    }
                }
            };
        }
    });
});

function eliminar(id) {
    const url = base_url + 'usuarios/delete/' + id;
    eliminarRegistro('¿Está seguro de eliminar?', 'El usuario no se eliminará de forma permanente', 'Sí, eliminar', url, tblUsuarios);
}

function editar(id) {
    console.log('Editar usuario con ID:', id); 
    const http = new XMLHttpRequest();
    const url = base_url + 'usuarios/editar/' + id;
    http.open("GET", url, true);
    http.send();

    http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            const res = JSON.parse(this.responseText);
            title.textContent = 'EDITAR USUARIO';
            frm.id_usuario.value = res.id;
            frm.nombre.value = res.nombre;
            frm.apellido.value = res.apellido;
            frm.correo.value = res.correo;
            frm.telefono.value = res.telefono; 
            frm.direccion.value = res.direccion;
            frm.clave.value = '00000000000';
            frm.clave.setAttribute('readonly', 'readonly');
            frm.rol.value = res.rol;
            myModal.show();
        }
    };
}
