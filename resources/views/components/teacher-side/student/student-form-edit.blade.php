<div>
    <form method="POST" class="container d-flex justify-content-between" style="" action="{{ url('students/' . $student->id . '/edit/reset-password') }}">
        @csrf
        <h3>Edit Student</h3>
        <button type="submit" class="btn btn-danger">Reset Password</button>
    </form>

    <form method="POST" class="container" action="{{ url('students/' . $student->id) }}">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="name">Name</label>
            <input
                type="text"
                id="name"
                name="name"
                autocomplete="name"
                placeholder="Type the name of the student"
                class="form-control
                @error('name') is-invalid @enderror"
                value="{{ $student->user->name }}"
                required
                aria-describedby="nameHelp">

            @error('name')
            <span class="invalid-feedback" role="alert">
                    <stron>{{ $message }}</stron>
                </span>
            @enderror
        </div>

        <div class="form-group">
            <label for="group">Class</label>
            <select class="form-control" name="group_id" id="group_id" autocomplete="group_id">
                @foreach($groups as $group)
                    <option @if($group->id == $student->group_id) selected @endif value="{{ $group->id }}">{{ $group->name }}</option>
                @endforeach
            </select>

            @error('group')
            <span class="invalid-feedback" role="alert">
                    <stron>{{ $message }}</stron>
                </span>
            @enderror
        </div>

        <div class="form-group">
            <label for="name" >E-mail</label>
            <input
                type="email"
                id="email"
                name="email"
                autocomplete="email"
                placeholder="Type the email"
                class="form-control
                @error('email') is-invalid @enderror"
                value="{{ $student->user->email }}"
                aria-describedby="nameHelp">

            @error('email')
            <span class="invalid-feedback" role="alert">
                <stron>{{ $message }}</stron>
            </span>
            @enderror
        </div>

        <button type="submit" class="mt-2 mb-5 btn btn-primary">Submit</button>
    </form>
</div>
