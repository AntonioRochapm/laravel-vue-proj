<div  row="col-12" class="teacherContentWrap" style="display:flex; flex-direction: column; justify-items: center;align-items: center; text-align: center">
    <h3>Teacher List</h3>
    {{ session()->get('message') }}
    <table class="table classListWrap">
        <thead class=" card-color-login ">
        <tr>
            <th scope="col" style="text-align: center">Name</th>
            <th scope="col" style="text-align: center">E-mail</th>
            <th scope="col" style="text-align: center">Action</th>
        </tr>
        </thead>
        <tbody class="classListWrap">
        @foreach($teachers as $teacher)

            <tr>
                <td>{{$teacher->user->name}}</td>
                <td>{{$teacher->user->email}}</td>
                <td>
                    <div class="row myrow">
                        <form action="{{ url('teacher-side/' . $teacher->id) }}" method="POST">
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
