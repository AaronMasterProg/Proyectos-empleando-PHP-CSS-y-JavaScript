const frm = document.querySelector('#formulario');
const correo = document.querySelector('#correo');
const clave = document.querySelector('#clave');

const inputReset = document.querySelector('#inputReset');
const btnProcesar = document.querySelector('#btnProcesar');
const myModal = new bootstrap.Modal(document.querySelector("#myModal"));

document.addEventListener('DOMContentLoaded', function () {
    // Envío del formulario de login
    frm.addEventListener('submit', function (e) {
        e.preventDefault();
        if (correo.value === "" || clave.value === "") {
            alertaPersonalizada('warning', 'Todos los campos son requeridos');
        } else {
            const data = new FormData(frm);
            const url = base_url + "principal/Validar";

            fetch(url, {
                method: 'POST',
                body: data
            })
            .then(response => response.json())
            .then(res => {
                alertaPersonalizada(res.tipo, res.mensaje);
                if (res.tipo === 'success') {
                    let timerInterval;
                    Swal.fire({
                        title: res.mensaje,
                        html: 'Serás redirigido en <b></b> milisegundos.',
                        timer: 2000,
                        timerProgressBar: true,
                        didOpen: () => {
                            Swal.showLoading();
                            const b = Swal.getHtmlContainer().querySelector('b');
                            timerInterval = setInterval(() => {
                                b.textContent = Swal.getTimerLeft();
                            }, 100);
                        },
                        willClose: () => {
                            clearInterval(timerInterval);
                        }
                    }).then((result) => {
                        if (result.dismiss === Swal.DismissReason.timer) {
                            window.location = base_url + 'Admin';
                        }
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alertaPersonalizada('error', 'Ocurrió un error durante el proceso de inicio de sesión.');
            });
        }
    });

    // Procesar el restablecimiento de contraseña
    btnProcesar.addEventListener('click', function () {
        if (inputReset.value == '') {
            alertaPersonalizada('warning', 'Ingrese el correo');
        } else {
            const url = base_url + 'Principal/enviarCorreo/' + inputReset.value;
            
            fetch(url)
                .then(response => response.json())
                .then(res => {
                    alertaPersonalizada(res.tipo, res.mensaje);
                    if (res.tipo === 'success') {
                        inputReset.value = '';
                        myModal.hide();
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alertaPersonalizada('error', 'Ocurrió un error al enviar el correo');
                });
        }
    });
});
