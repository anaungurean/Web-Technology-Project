function showMoreNames() {
    const hiddenElements = document.querySelectorAll('.criteria .elements li.hidden');
    hiddenElements.forEach((element) => {
        element.classList.add('visible');
        element.classList.remove('hidden');
    });

    const showMoreButton = document.getElementById('showMoreButton');
    showMoreButton.style.display = 'none';
}

function showMoreScientific() {
    const hiddenElements = document.querySelectorAll('.criteria-scientific .elements li.hidden');
    hiddenElements.forEach((element) => {
        element.classList.add('visible');
        element.classList.remove('hidden');
    });

    const showMoreButton = document.getElementById('showMoreButtonScientific');
    showMoreButton.style.display = 'none';
}
