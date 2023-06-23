function findPlants() {
    window.location.href = "PlantCollection.html";
}

function addPlants() {
    window.location.href = "AddPlant.html";
}

function myGarden() {
    window.location.href = "MyGarden.html";
}

function myProfile() {
    window.location.href = "UserProfile.html";
}

function clasament() {
    window.location.href = "Clasament.html";
}

function unsplash() {
    window.location.href = "UnsplashRecommendation.html";
}

const header = document.querySelector('.header');
const headerHeight = window.getComputedStyle(header).height;
document.documentElement.style.setProperty('--header-height', headerHeight);
