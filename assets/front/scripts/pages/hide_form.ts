
function hideShowFormProfile() {
    // Selector de "data-" attributes : entre crochets !
    const btnHideShow: NodeListOf<HTMLButtonElement> = document.querySelectorAll('[data-btn-hide-show]');
    if (btnHideShow) {
        btnHideShow.forEach((btn) => {
            btn.addEventListener('click', () => {
                const dataClassFirstElem: string = btn.getAttribute('data-class-first-element');
                const dataClassSecondElem: string = btn.getAttribute('data-class-second-element');
                const firstHtmlElement: HTMLElement = document.querySelector('.' + dataClassFirstElem);
                const secondHtmlElement: HTMLElement = document.querySelector('.' + dataClassSecondElem);
                firstHtmlElement.classList.toggle('d-none');
                secondHtmlElement.classList.toggle('d-none');
            });
        })
    }
}

window.addEventListener('load', () => {
    console.log(window.location.href);
    hideShowFormProfile();
});
