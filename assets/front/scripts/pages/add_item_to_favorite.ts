
interface GameId {
    gameId: string;
}

interface ResponseFavorite {
    OK: string;
}

function setUpClickEventAddFavorite(): void {
    const buttons: NodeListOf<HTMLButtonElement> = document.querySelectorAll('[data-game-favorite-id]');
    if (buttons) {
        buttons.forEach((btn) => {
            btn.addEventListener('click', () => {
                const gameId: string = btn.getAttribute('data-game-favorite-id');
                let datasToSend: GameId = {
                    gameId,
                };
                fetch('/ajax/addToFavorite/' + JSON.stringify(datasToSend))
                .catch((e) => {
                    console.log('error' + e);
                })
                .then((response: Response) => {
                    return response.json() as Promise<ResponseFavorite>;
                })
                .then((data) => {
                    if (data.OK) {
                        alert('Favoris ajouté <3');
                    } else {
                        alert('Favoris supprimé </3');
                    }
                });
            });
        });
    }
}

window.addEventListener('load', () => {
    setUpClickEventAddFavorite();
});
