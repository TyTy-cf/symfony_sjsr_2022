
function hideShowFormProfile() {
    const btnHideShow: NodeListOf<HTMLButtonElement> = document.querySelectorAll('.btn-hide-show');
    if (btnHideShow) {
        btnHideShow.forEach((btn) => {
            btn.addEventListener('click', () => {
                const dataClassFirstElem: string = btn.getAttribute('data-class-first-element');
                const dataClassSecondElem: string = btn.getAttribute('data-class-second-element');
                const firstHtmlElement: HTMLElement = document.querySelector('.' + dataClassFirstElem);
                const secondHtmlElement: HTMLElement = document.querySelector('.' + dataClassSecondElem);
                if (secondHtmlElement.classList.contains('d-none')) {
                    secondHtmlElement.classList.remove('d-none')
                    firstHtmlElement.classList.add('d-none')
                } else {
                    secondHtmlElement.classList.add('d-none')
                    firstHtmlElement.classList.remove('d-none')
                }
            });
        })
    }
}

window.addEventListener('load', () => {
    console.log(window.location.href);
    hideShowFormProfile();
});