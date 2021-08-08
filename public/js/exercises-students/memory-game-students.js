const cards = document.querySelectorAll('.memory-card');

let hasFlippedCard = false;
let lockBoard = false;
let firstCard, secondCard;
let totalCorrectAnswers = 0;
let infoExerciseOver = `
        <div class="memory-game-play-over-dialog">
            <div class="memory-game-play-over-header">
                <h2 class = "memory-game-play-over-h2">Congratulations!!</h2>
            </div>
            <section class="memory-game-play-over-message">
                <p>You did it!</p>
                <p>Choose what to do next.</p>
            </section>
            <div class = "memory-game-play-over-menu">
                <button class="memory-game-play-over-button-challenge" >Next Challenge</button>
                <button class="memory-game-play-over-button-menu" onclick="siteRedirectMemoryGame()">Menu</button>
            </div>
        </div>
    `


function flipCard() {
    if (lockBoard) return;
    if (this === firstCard) return;

    this.classList.add('flip');

    if (!hasFlippedCard) {
        // first click
        hasFlippedCard = true;
        firstCard = this;

        return;
    }

    // second click
    secondCard = this;

    checkForMatch();
}

function checkForMatch() {
    let isMatch = firstCard.dataset.framework === secondCard.dataset.framework;

    isMatch ? disableCards() : unflipCards();

}

function disableCards() {
    firstCard.removeEventListener('click', flipCard);
    secondCard.removeEventListener('click', flipCard);
    totalCorrectAnswers ++;
    resetBoard();
    if(totalCorrectAnswers === 6){
        gameIsOver();
    }
}

function unflipCards() {
    lockBoard = true;

    setTimeout(() => {
        firstCard.classList.remove('flip');
        secondCard.classList.remove('flip');

        resetBoard();
    }, 1500);
}

function resetBoard() {
    [hasFlippedCard, lockBoard] = [false, false];
    [firstCard, secondCard] = [null, null];
}

function gameIsOver(){
    let clearHtml = document.querySelector('.memory-game-student-play')
    setTimeout(() => {
        let gameIsOverCard = document.createElement('div');
        gameIsOverCard.innerHTML = infoExerciseOver;
        clearHtml.parentNode.appendChild(gameIsOverCard);
        clearHtml.parentNode.removeChild(clearHtml);
    },4000);
}

(function shuffle() {
    cards.forEach(card =>{
        let randomPos = Math.floor(Math.random() * 12);
        card.style.order = randomPos;
    });
})(); // This function gets called right after its definition

cards.forEach(card => card.addEventListener('click', flipCard));


function siteRedirectMemoryGame(){
    location.href="/student-side";
}
