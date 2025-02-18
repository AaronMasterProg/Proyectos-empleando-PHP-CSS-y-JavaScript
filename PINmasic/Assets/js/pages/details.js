const id_carpeta = document.querySelector('#id_carpeta');
let tlb;
document.addEventListener('DOMContentLoaded', function(){
   tbl= $('#tblDetalle').DataTable({
        ajax: {
            url: base_url + 'Admin/listardetalle/' + id_carpeta.value,
            dataSrc: ''
        },
        columns: [
            {data: 'acciones'}, 
            {data: 'correo'  },
            {data: 'nombre' },
            {data: 'estado' },
            
        ],
        language: {
            url: 'https://cdn.datatables.net/plug-ins/1.13.1/i18n/es-ES.json'
        },
        responsive: true,
        destroy: true,
        order: [[1, 'desc']],
    });
})

function eliminarDetalle(id) {
    const url = base_url + 'archivos/eliminarCompartido/' + id;
    eliminarRegistro('¿Está seguro de eliminar?', 'El archivo se eliminará de forma permanente en 30 dias',
         'Sí, ELIMINAR', url, tbl)
}


