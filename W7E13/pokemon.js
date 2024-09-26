const apiUrl = 'https://pokeapi.co/api/v2/pokemon';
const pokemonCount = 1025;
let firstSelected = null;
let secondSelected = null;
let lockBoard = false;
let pokemonsGuessed = 0;
let startingScore = 1000;

document.addEventListener("DOMContentLoaded", initialize);

function initialize() {
    const pokemonBtn = document.getElementById('showPokemon');
    pokemonBtn.addEventListener('click', showPokemon);
    pokemonBtn.addEventListener('click', initGame);
}

function randomize(min, max) {
    return Math.floor((Math.random() * (max)) + min);
}

const shuffle = (array) => {
    for (let i = array.length - 1; i > 0; i--) {
        const j = Math.floor(Math.random() * (i + 1));
        [array[i], array[j]] = [array[j], array[i]];
    }
    return array;
};

function initGame() {
    lockBoard = false;
    pokemonsGuessed = 0;
    let gameTime = 30;
    startingScore = 1000;

    const score = document.getElementById('score');
    score.innerHTML = `Score: ${startingScore}`;
    const pokemonBtn = document.getElementById('showPokemon');
    pokemonBtn.classList.add('hidden');

    const intervalId = setInterval(function() {
        gameTime = handleGame(gameTime, pokemonBtn, intervalId);
    }, 1000);
}

function handleGame(time, pokemonBtn, intervalId) {
    const timer = document.getElementById('timer');

    if(pokemonsGuessed === 6){
        clearInterval(intervalId);
        alert("You won!");
        pokemonBtn.classList.remove("hidden");
        lockBoard = true;
        return time;
    }

    if (time <= 0) {
        clearInterval(intervalId);
        pokemonBtn.classList.remove("hidden");
        lockBoard = true;
        timer.innerHTML = "Time's up!";
        alert("You lost!")
        return time;
    }

    time -= 1;
    timer.innerHTML = `00:${time < 10 ? '0' + time : time}`;
    return time;
}


function getPokemonPicture(id) {
    return fetch(`${apiUrl}/${id}`)
        .then(response => response.json())
        .then(data => {
            if (data.sprites.front_default) {
                return data.sprites.front_default;
            }
        });
}



function showPokemon() {
    const pokemonList = document.getElementById('pokemonList');
    pokemonList.innerHTML = '';

    const placeholderImage = 'https://www.outcyders.net/images/quizzes/4/quizhead1.jpg';

    const pokemonIds = Array.from({ length: 6 }, () => randomize(1, pokemonCount));

    Promise.all(pokemonIds.map(id => getPokemonPicture(id)))
        .then(pokemonImgArray => {
            let doubledImgArray = [];
            pokemonImgArray.forEach(img => {
                doubledImgArray.push(img, img);
            });

            let pokemonShuffledImgArray = shuffle(doubledImgArray);

            let row = document.createElement('tr');

            for (let i = 0; i < pokemonShuffledImgArray.length; i++) {
                if (i % 3 === 0 && i !== 0) {
                    pokemonList.appendChild(row);
                    row = document.createElement('tr');
                }

                let td = document.createElement('td');
                td.innerHTML = `<div class='container'><img class='pokemon-img' src='${placeholderImage}' data-real-src='${pokemonShuffledImgArray[i]}' style='width: 100px; height: 100px;'></div>`;
                row.appendChild(td);
            }

            if (row.hasChildNodes()) {
                pokemonList.appendChild(row);
            }

            const pokemonImages = document.querySelectorAll('.pokemon-img');
            pokemonImages.forEach(img => {
                img.addEventListener('click', handleCardClick);
            });
        })
        .catch(error => {
            console.error("Error fetching Pokemon:", error);
        });
}

function handleCardClick() {
    const score = document.getElementById('score');
    if (lockBoard || this.getAttribute('src') !== 'https://www.outcyders.net/images/quizzes/4/quizhead1.jpg') {
        return;
    }

    this.src = this.getAttribute('data-real-src');

    if (!firstSelected) {
        firstSelected = this;
    } else {
        secondSelected = this;

        lockBoard = true;

        if (firstSelected.getAttribute('data-real-src') === secondSelected.getAttribute('data-real-src')) {
            firstSelected = null;
            secondSelected = null;
            lockBoard = false;
            pokemonsGuessed += 1;
        } else {
            setTimeout(() => {
                firstSelected.src = 'https://www.outcyders.net/images/quizzes/4/quizhead1.jpg';
                secondSelected.src = 'https://www.outcyders.net/images/quizzes/4/quizhead1.jpg';
                firstSelected = null;
                secondSelected = null;
                lockBoard = false;
                startingScore -= 50;
                score.innerHTML = `Score: ${startingScore}`;
            }, 1000);
        }
    }
}


