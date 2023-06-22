document.addEventListener('DOMContentLoaded', function() {
  // ...

  const pdfButton = document.getElementById('pdfButton');
  pdfButton.addEventListener('click', () => {
    // Fetch the PDF file directly
    fetch('../../php/generate_pdf.php')
      .then(response => response.blob())
      .then(blob => {
        // Create a download link for the PDF file
        const url = URL.createObjectURL(blob);
        const link = document.createElement('a');
        link.href = url;
        link.download = 'my_pdf.pdf';
        link.style.display = 'none';
        document.body.appendChild(link);
        
        // Trigger the download
        link.click();
        
        // Clean up the temporary link
        URL.revokeObjectURL(url);
        document.body.removeChild(link);
      })
      .catch(error => console.error('Error:', error));
  });

  // ...
});
