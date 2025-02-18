let tbArchivos;

document.addEventListener('DOMContentLoaded', function () {
    tbArchivos = $('#tbArchivos').DataTable({
        ajax: {
            url: base_url + 'archivos/listarHistorial',
            dataSrc: ''
        },
        columns: [
            { data: 'accion' },
            { data: 'id' },
            { data: 'nombre' },
            { data: 'tipo' },
            { data: 'fecha_create' },
            { data: 'elimina' }
        ],
        language: {
            url: 'https://cdn.datatables.net/plug-ins/1.13.1/i18n/es-ES.json'
        },
        responsive: true,
        order: [[1, 'desc']]
    });
})

function restaurar(id) {
    const url = base_url + 'archivos/delete/' + id;
    eliminarRegistro('¿Está seguro de restaurar?', 'El archivo se restablecera en el mismo directorio', 'Sí, restaurar', url, tbArchivos);
}