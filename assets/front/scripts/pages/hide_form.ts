
function hideShowFormProfile() {
    const btnHideShow: HTMLButtonElement = document.querySelector('.btn-edit-profile');
    if (btnHideShow) {
        btnHideShow.addEventListener('click', () => {
            const formProfile: HTMLDivElement = document.querySelector('.form-profile-user');
            const tableProfile: HTMLTableElement = document.querySelector('.table-account');
            if (formProfile.classList.contains('d-none')) {
                formProfile.classList.remove('d-none')
                tableProfile.classList.add('d-none')
            } else {
                formProfile.classList.add('d-none')
                tableProfile.classList.remove('d-none')
            }
        });
    }
}

window.addEventListener('load', () => {
    hideShowFormProfile();
});