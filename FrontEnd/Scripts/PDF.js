document.addEventListener('DOMContentLoaded', function() {

  const pdfButton = document.getElementById('pdfButton');
  pdfButton.addEventListener('click', () => {
    fetch('../../php/generate_pdf.php')
      .then(response => response.blob())
      .then(blob => {
        const url = URL.createObjectURL(blob);
        const link = document.createElement('a');
        link.href = url;
        link.download = 'my_pdf.pdf';
        link.style.display = 'none';
        document.body.appendChild(link);
        
        link.click();
        
        URL.revokeObjectURL(url);
        document.body.removeChild(link);
      })
      .catch(error => console.error('Error:', error));
  });

});
