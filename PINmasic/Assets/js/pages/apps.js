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
        let convocatoria = document.getElementById('convocatoria').value;
        let institucion = document.getElementById('institucion').value;
        let preguntas = document.getElementById('preguntas').value;
        let respuestas = document.getElementById('respuestas').value;
        let preguntas2 = document.getElementById('preguntas2').value;
        let respuestas2 = document.getElementById('respuestas2').value;
        let preguntas3 = document.getElementById('preguntas3').value;
        let respuestas3 = document.getElementById('respuestas3').value;
        let cargo = document.getElementById('cargo').value;

        generatePDF(convocatoria, institucion, preguntas, respuestas, preguntas2, respuestas2, preguntas3, respuestas3, cargo);
    });
});

async function generatePDF(convocatoria, institucion, preguntas, respuestas, preguntas2, respuestas2, preguntas3, respuestas3, cargo) {
    const { jsPDF } = window.jspdf; // Asegura que jsPDF esté correctamente importado

    const pdf = new jsPDF('p', 'pt', 'letter');

    // Verifica si la imagen está cargada correctamente
    try {
        const image = await loadImage("Formulario.jpeg");
        pdf.addImage(image, 'PNG', 0, 0, 600, 800);
    } catch (error) {
        console.error("Error cargando la imagen de fondo", error);
    }

    const signatureImage = signaturePad.toDataURL();
    pdf.addImage(signatureImage, 'PNG', 400, 540, 210, 50);

    pdf.setFontSize(11);
    pdf.text(convocatoria, 181, 164);

    const date = new Date();
    pdf.text(date.getUTCDate().toString(), 185, 215);
    pdf.text((date.getUTCMonth() + 1).toString(), 226, 215);
    pdf.text(date.getUTCFullYear().toString(), 273, 215);

    pdf.setFontSize(9.5);
    pdf.text(institucion, 139, 240);
    pdf.text(preguntas, 127, 381);
    pdf.text(respuestas, 337, 381);
    pdf.text(preguntas2, 127, 446);
    pdf.text(respuestas2, 337, 446);
    pdf.text(preguntas3, 127, 512);
    pdf.text(respuestas3, 337, 512);
    pdf.text(cargo, 342, 576);

    pdf.save("FORMATO_DE_ACLARACION_A_LA_CONVOCATORIA.pdf");
}
