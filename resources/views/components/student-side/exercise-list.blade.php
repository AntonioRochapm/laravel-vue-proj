<div row="col-12" class="studentContentWrap">
    <div class="studentListWrap " style="display:flex; justify-content: center;">
        <table class="table studentListForm ">
            <thead class=" card-color-login studentListFormHeader">
            <tr>
                <th scope="col">Title</th>
                <th scope="col">Subject</th>
                <th scope="col"></th>
            </tr>
            </thead>
            <tbody>
            @foreach($exercises as $exercise)
                <tr>
                    <td>{{$exercise->title}}</td>
                    <td>{{$exercise->subject->name}}</td>
                    <td><a href="{{url('exercises/'.$exercise->type->slug.'/solve/'. $exercise->id)}}" type="button" class="btn btn-success buttonGreen">Play</a></td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>

