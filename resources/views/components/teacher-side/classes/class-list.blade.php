<div row="col-12" class="teacherContentWrap" style="display:flex; justify-content: center;">

    <table class="table classListWrap" >
        <thead class="  card-color-login ">
        <tr>
            <th scope="col" style="text-align: center">Name</th>
            <th scope="col" style="text-align: center">Action</th>

        </tr>
        </thead>
        <tbody class="classListWrap">
        @foreach($groups as $group)
            <tr>
                <td>{{ $group->name }}</td>
                <td>
                    <div class="row myrow">
                        <div class="pr-1">
                            <a href="{{ url('classes/' . $group->id ) }}" type="button" class="btn btn-success buttonGreen">Show</a>
                        </div>
                        <div class="pr-1">
                            <a href="{{ url('classes/' . $group->id . '/edit' ) }}" type="button" class="btn btn-primary">Edit</a>
                        </div>
                        <form action="{{ url('classes/' . $group->id) }}" method="POST">
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
