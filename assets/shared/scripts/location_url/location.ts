
window.addEventListener('load', () => {
    let aPrevious: HTMLLinkElement = document.querySelector('.my-useless-previous-btn');
    aPrevious.href = document.referrer;
    console.log(document.referrer); // previous loc
    console.log(window.location.href); // current loc
});