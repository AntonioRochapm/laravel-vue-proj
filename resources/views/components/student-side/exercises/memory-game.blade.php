<div class="memory-game-student-play-title">
    <h3>Welcome to the Memory Game</h3>
</div>

<section class ="memory-game-student-play">
    @foreach($memoryGames as $memoryGame)
        <div class = "memory-card" data-framework = "{{$memoryGame[0]->name}}">
            <img  class = "front-face" src="{{asset($memoryGame[0]->url_image)}}" alt="EPS" />
            <img class = "back-face" src="{{ asset('storage/icons/marelita.png')}}" alt="EPS" />
        </div>
        <div class = "memory-card" data-framework = "{{$memoryGame[0]->name}}">
            <p class = "front-face card-names">{{$memoryGame[0]->name}}</p>
            <img class = "back-face" src="{{ asset('storage/icons/marelita.png')}}" alt="EPS" />
        </div>
    @endforeach
</section>


