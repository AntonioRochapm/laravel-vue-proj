<section class = "main-page-students">
    <div class = "main-page-students-themes">
        <h3 class ="main-page-students-title">Exercises</h3>
        <div class="grid-wrapper">
            <div id="subject-wrapper">
                @foreach($subjects as $subject)
                    <a id="subject" href="student-side/{{$subject->id}}"><img class="subject-icon" src="{{ asset('storage/icons/'.$subject->id.'.png')}}"><h6 class="main-page-students-exams-themes-titles">{{$subject->name}}</h6></a>
                @endforeach
            </div>
        </div>
    </div>
    <div class = "main-page-students-exams">
        <h3 class ="main-page-students-title">Exams</h3>
        <div class="main-page-students-exams-vue-comp">
            <exam-list></exam-list>
        </div>
    </div>
</section>
<img class = "main-page-students-marelita-img" src="{{ asset('storage/icons/marelita.png')}}" alt="EPS" />


