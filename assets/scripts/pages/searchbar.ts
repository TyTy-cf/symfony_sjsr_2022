
function doSomething() {
    // HTMLInputElement peut changer en fonction du type d'élément HTML que vous souhaitez récupérer
    const input: HTMLInputElement = document.querySelector('#search');
    // On vérifit s'il existe, afin de ne pas avoir d'erreur JS sur la page
    if (input) {

    }
}

window.addEventListener('load', () => {
    console.log('Au chargement de la page !');
    doSomething();
});