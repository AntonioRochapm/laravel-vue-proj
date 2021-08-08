<div  row="col-12" class="teacherContentWrap" style="display:flex; flex-direction: column; justify-items: center;align-items: center; text-align: center">
    <h3>{{ $group->name }}</h3>
    {{ session()->get('message') }}
    <table class="table classListWrap">
        <thead class=" card-color-login ">
        <tr>

            <th scope="col" style="text-align: center">Name</th>
            <th scope="col" style="text-align: center">Student Number</th>
            <th scope="col" style="text-align: center">E-mail</th>
            <th scope="col" style="text-align: center">Action</th>
        </tr>
        </thead>
        <tbody class="classListWrap">
        @foreach($students as $student)

            <tr>
                <td>{{ $student->user->name }}</td>
                <td>{{ $student->student_number }}</td>
                <td>{{ $student->user->email }}</td>
                <td>
                    <div class="row myrow">
                        <form action="{{ url('students/' . $student->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            @if($errors->any())
                                <h4>{{$errors->first()}}</h4>
                            @endif
                            <button type="submit" class="btn buttonOrange">Delete</button>
                        </form>
                    </div>
                </td>
            </tr>

        @endforeach
        </tbody>
    </table>
</div>
