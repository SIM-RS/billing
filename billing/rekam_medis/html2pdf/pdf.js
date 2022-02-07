function printPDF(name) {
    const pdf = document.getElementById("pdf-area");
    var opt = {
        margin: 0,
        filename: name + ".pdf",
        image: { type: "JPEG", quality: 1 },
        html2canvas: { scale: 1 },
        jsPDF: { unit: "in", format: "a4", orientation: "portrait" }
    };
    html2pdf().from(pdf).set(opt).save();
} 