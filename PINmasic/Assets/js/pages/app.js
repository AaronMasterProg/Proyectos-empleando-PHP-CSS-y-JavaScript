// Función para cargar imagen
function loadImage(url) {
    return new Promise(resolve => {
        const xhr = new XMLHttpRequest();
        xhr.open('GET', url, true);
        xhr.responseType = "blob";
        xhr.onload = function () {
            const reader = new FileReader();
            reader.onload = function (event) {
                resolve(event.target.result);
            };
            reader.readAsDataURL(this.response);
        };
        xhr.send();
    });
}

let signaturePad = null;

window.addEventListener('DOMContentLoaded', async () => {
    const canvas = document.getElementById("signature-canvas");
    canvas.height = canvas.offsetHeight;
    canvas.width = canvas.offsetWidth;
    signaturePad = new SignaturePad(canvas);

    const form = document.getElementById('form');
    form.addEventListener('submit', (e) => {
        e.preventDefault();

        // Captura los valores del formulario
        let institucion = document.getElementById('institucion').value;
        let procedimiento = document.getElementById('procedimiento').value;
        let compranet = document.getElementById('compranet').value;
        let interno = document.getElementById('interno').value;
        let contrato = document.getElementById('contrato').value;
        let servicio = document.getElementById('servicio').value;
        let convenio = document.getElementById('convenio').value;
        let servicio1 = document.getElementById('servicio1').value;
        let contrato1 = document.getElementById('contrato1').value;
        let convenio1 = document.getElementById('convenio1').value;
        let servicio2 = document.getElementById('servicio2').value;
        let contrato2 = document.getElementById('contrato2').value;
        let servicio3 = document.getElementById('servicio3').value;
        let contrato3 = document.getElementById('contrato3').value;
        let servicio4 = document.getElementById('servicio4').value;
        let servicio5 = document.getElementById('servicio5').value;

        generatePDF(institucion, procedimiento, compranet, interno, contrato, servicio, convenio, servicio1, contrato1, convenio1, servicio2, contrato2, servicio3, contrato3, servicio4, servicio5)
            .then(() => {
                // Limpia los campos del formulario
                form.reset();
                // Limpia la firma en el canvas
                signaturePad.clear();
            })
            .catch(error => console.error("Error generando el PDF", error));
    });
});

async function generatePDF(institucion, procedimiento, compranet, interno, contrato, servicio, convenio, servicio1, contrato1, convenio1, servicio2, contrato2, servicio3, contrato3, servicio4, servicio5) {
    const { jsPDF } = window.jspdf;
    const pdf = new jsPDF('p', 'pt', 'letter');

    try {
        const image = await loadImage("Formulario2.jpeg");
        pdf.addImage(image, 'PNG', 0, 0, 600, 800);
    } catch (error) {
        console.error("Error cargando la imagen de fondo", error);
    }

    const signatureImage = signaturePad.toDataURL();
    pdf.addImage(signatureImage, 'PNG', 238, 588, 210, 50);

    pdf.setFontSize(11);
    pdf.text(institucion, 141, 186);

    // Usa toLocaleDateString() para obtener la fecha
    const date = new Date();
    const options = { day: 'numeric', month: 'numeric', year: 'numeric' };
    const localDate = date.toLocaleDateString('es-MX', options).split('/');

    const day = localDate[0];   // Día
    const month = localDate[1]; // Mes
    const year = localDate[2];   // Año

    pdf.text(day, 464, 138);         // Día
    pdf.text(month, 490, 138);      // Mes
    pdf.text(year, 521, 138);       // Año

    pdf.setFontSize(10);
    pdf.text(procedimiento, 217, 292);
    pdf.text(compranet, 235, 375);
    pdf.text(interno, 405, 375);
    pdf.text(contrato, 456, 430);
    pdf.text(servicio, 199, 444);
    pdf.text(servicio1, 371, 455);
    pdf.text(convenio, 249, 455);
    pdf.text(contrato1, 160, 467);
    pdf.text(servicio2, 279, 467);
    pdf.text(convenio1, 258, 480);
    pdf.text(servicio3, 374, 480);
    pdf.text(contrato2, 160, 492);
    pdf.text(servicio4, 281, 492);
    pdf.text(contrato3, 168, 504);
    pdf.text(servicio5, 285, 504);

    pdf.save("RELACIÓN CONTRACTUAL.pdf");

    
}
