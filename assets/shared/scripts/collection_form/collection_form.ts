
window.addEventListener('load', function () {
    const buttonsAddForm: NodeListOf<HTMLButtonElement> = document.querySelectorAll('[data-btn-selector]');
    if (buttonsAddForm) {
        buttonsAddForm.forEach((btnElt) => {
            btnElt.addEventListener('click', () => {
                const dataValueSelector: string = btnElt.getAttribute('data-btn-selector');
                let list: HTMLElement = document.querySelector('[data-list-selector="'+dataValueSelector+'"]');
                let counter: number = list.children.length;
                let newWidget: string = list.getAttribute('data-prototype');
                newWidget = newWidget.replace(/__name__/g, counter.toString());
                counter++;
                list.setAttribute('widget-counter', counter.toString());
                let newDiv = document.createElement('div');
                newDiv.innerHTML = newWidget;
                list.appendChild(newDiv);
            });
        });
    }
});


