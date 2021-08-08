window.onload = function() {

    infoAdded.forEach(element => {
        element.value ='';
    });
}

infoAdded =  new Array();
// inputText = new Array();
fillArrayWitHTML_Classes(infoAdded);

setInterval(function(){
    fillGrid();
} , 1000);


function loadFile(event) {
    let image = document.querySelector(`.create-memory-game-pic-${event.target.id}`)
    image.innerHTML  = `<img class ="create-memory-game-img"src="${URL.createObjectURL(event.target.files[0])}">`;
};

function fillArrayWitHTML_Classes(array)
{
    let j=0;
    for(let i=1; i<7; i++){

        array[j] = document.querySelector('#create-memory-game-fname-' + i);
        j++;
        array[j] = document.querySelector('.create-memory-game-Gname-' + i);
        j++;
    }
}

function fillGrid(){
    infoAdded.forEach(function callback(element, i){
        if(element.className.includes("create-memory-game-Gname")) {
            element.innerHTML = infoAdded[i-1].value;
        };



    })
}



