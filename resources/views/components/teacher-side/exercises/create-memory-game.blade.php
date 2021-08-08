<div class="create-memory-game-main-div">
    <section class="md-layout-table-our-header-teacher-side md-card-our-header-teacher-side">
        <div class="tab-content-our-header-teacher-side">
            <div class="nav nav-tabs md-tabs-navigation-our-header-teacher-side">
                <div name="header">
                    <h2 class="h2-our-header-teacher-side">Memory Game</h2>
                </div>
            </div>
            <div>
                <div name="body">
                    <section class="create-memory-game-form">
                        <div class="create-memory-game-container">

                            <form id="createMemoryGame" method="POST" action="{{ url('exercises/memory-game') }}" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="subject" value="{{ $subject }}">

                                <label for="title">Exercise name:</label>
                                <input  id="title" type="text" name="title" placeholder="Write here" class="form-control" required>
                                <label for="description">Description:</label>
                                <input  id="description" type="text" name="description" placeholder="Write here" class="form-control" required>

                                @for($i=1; $i<7; $i++)
                                    <div class = "create-memory-game-container-info">
                                        <label for="fname">Card Title {{$i}}</label>
                                        <input type="text" id="create-memory-game-fname-{{$i}}" name="question{{$i}}" placeholder="Type here" required>
                                        <input type="file"  accept="image/*" name="image{{$i}}" id="MG{{$i}}"  onchange="loadFile(event)" style="display: none;" required>
                                        <label class ="create-memory-game-Upload-box" for="MG{{$i}}" style="cursor: pointer;">Upload Img {{$i}} Here</label>
                                    </div>
                                @endfor

                                <input class="create-memory-game-button-submit" type="submit" value="Submit">
                            </form>

                        </div>
                        <div class="grid-create-memory-game-preview">
                            @for($i=1; $i<7; $i++)
                                <div class="create-memory-game-box-Preview create-memory-game-pic-MG{{$i}}"></div>
                                <div class="create-memory-game-box-Preview create-memory-game-Gname-{{$i}}"></div>
                            @endfor
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </section>
</div>



<script type="application/javascript" src="{{ asset('js/teacher-side/exercises/create-memory-game.js') }}"> </script>



