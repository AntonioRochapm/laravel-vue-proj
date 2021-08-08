<div  row="col-12" class="teacherContentWrap" style="display:flex; flex-direction: column; justify-items: center;align-items: center; text-align: center">
    <h3>ExamList</h3>

    <table class="table classListWrap">
        <thead class=" card-color-login ">
        <tr>
            <th scope="col" style="text-align: center">Author</th>
            <th scope="col" style="text-align: center">Exam Name</th>
            <th scope="col" style="text-align: center">Options</th>
        </tr>
        </thead>
        <tbody class="classListWrap">
        @foreach($exams as $exam)
            <tr>
                <td>{{$exam->teacher_id }}</td>
                <td>{{ $exam->name }}</td>
                <td>
                    <div class="row myrow">
                        <form action="{{ url('exam/'.$exam->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger buttonOrange">Delete</button>
                        </form>
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
