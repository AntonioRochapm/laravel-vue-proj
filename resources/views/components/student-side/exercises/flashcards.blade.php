
<div class="card-container" id="card-container" onload="cardCount()">
    <h3 class="flash-card-student-play-title">Welcome to the FlashCards Game</h3>
    <div id="card-wrapper">
        <?php
        $i=1;
        ?>
        @foreach($flashcards as $flashcard)

            <div class="card mycard" id="card{{$i}}">
                <img src="{{asset($flashcard[0]->url_image)}}" class="card-img-top flashcard-image" alt="flash">
                <div id="input{{$i}}" class="card-body mycard-body">
                    <label for="answer">Answer:</label>
                    <input type="text" id="answer{{$i}}" class="flashcard-textbox" name="answer" oninput="checkAnswer({{$i}})">
                </div>
            </div>
            <?php
            $i++;
            ?>
        @endforeach

    </div>
    <div id="solved-flash-card">
    </div>
</div>

<script type="application/javascript">

    var flashcards = {!! json_encode($flashcards, JSON_HEX_TAG) !!};
    var answers =[];

    for(let i=0; i<flashcards.length;i++){
        answers.push(flashcards[i][0].correct_answer);
    }

</script>
<script type="application/javascript" src='{{asset('/js/exercises-students/flashcards-student-play.js')}}'> </script>



