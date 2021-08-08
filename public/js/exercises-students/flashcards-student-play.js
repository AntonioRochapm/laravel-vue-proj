var solvedFlashCards=0;



function applyCss() {
    let cardsFlashCard = document.querySelectorAll('.card');
    let cards = document.querySelectorAll('.mycard');
    let length = cards.length;
    if(cardsFlashCard.length <= 8 && cardsFlashCard.length > 4){

        document.getElementById('card-wrapper').style.cssText= "grid-template-rows: repeat(2, 1fr)";
        document.getElementById('card-container').style.cssText= "justify-items:center; justify-content:center; align-items:center; align-content:center; padding-bottom:10px;";

    }
    if(cardsFlashCard.length === 4){

        document.getElementById('card-wrapper').style.cssText= "grid-template-rows: repeat(1, 1fr)";
        document.getElementById('card-container').style.cssText= "justify-items:center; justify-content:center; align-items:center; align-content:center; padding-bottom:10px;";

    }
    if(cardsFlashCard.length === 3){

        document.getElementById('card-wrapper').style.cssText= "grid-template-rows: repeat(1,1fr); grid-template-columns:repeat(3,20%); grid-column-gap: 20px;";
        for ( let i = 0 ; i < length; i++) {
            cards[i].style.cssText= "width:100%;"
        }
        document.getElementById('card-container').style.cssText= "justify-items:center; justify-content:center; align-items:center; align-content:center; padding-bottom:10px;";
        if (window.innerWidth <= 1011) {
            document.getElementById('card-wrapper').style.cssText= "grid-template-rows: repeat(1, 1fr); grid-template-columns:repeat(2,20%fr fit-content(100%)); grid-column-gap: 20px;";
        }
    }
    if(cardsFlashCard.length === 2){

        document.getElementById('card-wrapper').style.cssText= "grid-template-rows: repeat(1,1fr); grid-template-columns:repeat(2,30%); grid-column-gap: 20px;";
        for ( let i = 0 ; i < length; i++) {
            cards[i].style.cssText= "width:100%; color:white;"
        }
        document.getElementById('card-container').style.cssText= "justify-items:center; justify-content:center; align-items:center; align-content:center; padding-bottom:10px;";
        if (window.innerWidth <= 1011) {
            document.getElementById('card-wrapper').style.cssText= "grid-template-rows: repeat(1, 1fr); grid-template-columns:repeat(2,20%fr fit-content(100%)); grid-column-gap: 20px;";
        }
    }

    if(cardsFlashCard.length === 1) {
        document.getElementById('card-wrapper').style.cssText = "grid-template-rows: repeat(1,70%); grid-template-columns:repeat(1,20%);width:100%; height:100%; align-content:center;justify-content:center";
        cards[0].style.cssText = "width:100%;";
        if (window.innerWidth <= 1426 && window.innerWidth >= 841) {
            document.getElementById('card-wrapper').style.cssText = "grid-template-rows: repeat(1,1fr); grid-template-columns:repeat(1,35%);max-width:100%; max-height:100%;";
            cards[0].style.cssText= "width:100% !important; color:white;"
        }
        if (window.innerWidth <= 840 && window.innerWidth >= 451) {
            document.getElementById('card-wrapper').style.cssText = "grid-template-rows: repeat(1, 1fr); grid-template-columns:repeat(1,70%);width:100%; height:100%;";
            cards[0].style.cssText= "width:100% !important; color:white;"

        }
        if (window.innerWidth <= 450) {
            document.getElementById('card-wrapper').style.cssText = "grid-template-rows: repeat(1, 1fr); grid-template-columns:repeat(1,80%);width:100%; height:60%;";
            cards[0].style.cssText= "width:100% !important; color:white;"

        }
    }
}

window.onresize = applyCss;

window.onload = applyCss;



function checkAnswer(id) {
    let cardsFlashCard = document.querySelectorAll('.card');
    let correctAnswer=answers[id-1];

    let ua=document.getElementById("answer"+id)
    let userAnswer = ua.value.toLowerCase();

    if(userAnswer===correctAnswer){
        document.getElementById("input"+id).style.backgroundColor="#66bb6a";
        document.getElementById("answer"+id).readOnly=true;
        solvedFlashCards++;

        if(solvedFlashCards===cardsFlashCard.length){
            submit=document.querySelector("#solved-flash-card").innerHTML = "<input type='button' id='submitFlashcard' onclick='gameFlashCardIsOver()' value='Submit' class='buttonGreen btn btn-primary'/>";
        }
    }else{
        document.getElementById("input"+id).style.backgroundColor="#ffb347"
    }
}


function gameFlashCardIsOver(){

    let infoExerciseOverFlahsCard = `
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
                        <button class="memory-game-play-over-button-menu" onclick="siteRedirectFlashCard()">Menu</button>
                    </div>
                </div>
            `

    let clearHtml = document.querySelector('#card-container')
    setTimeout(() => {
        let gameIsOverCard = document.createElement('div');
        gameIsOverCard.innerHTML = infoExerciseOverFlahsCard;
        clearHtml.parentNode.appendChild(gameIsOverCard);
        clearHtml.parentNode.removeChild(clearHtml);
    },1500);
}

function siteRedirectFlashCard(){
    location.href="/student-side";
}
