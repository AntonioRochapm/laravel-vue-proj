<div class="container" style="width: 40%">
    <form method="POST" action="{{ route('change.password') }}" >
        @csrf

        @foreach ($errors->all() as $error)
            <p class="text-danger">{{ $error }}</p>
        @endforeach

        <div class="form-group">
            <label for="password">Password</label>

            <div>
                <input
                    id="password"
                    type="password"
                    class="form-control @error('password') is-invalid @enderror"
                    name="current_password"
                    required
                    autocomplete="current-password">

                @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>

        <div class="form-group">
            <label for="password">New Password</label>

            <div>
                <input
                    id="new_password"
                    type="password"
                    class="form-control @error('password') is-invalid @enderror"
                    name="new_password"
                    required
                    autocomplete="current-password">

                @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>

        <div class="form-group">
            <label for="password">Confirm New Password</label>

            <div>
                <input
                    id="new_confirm_password"
                    type="password"
                    class="form-control"
                    name="new_confirm_password"
                    required
                    autocomplete="current-password">
            </div>
        </div>

        <button type="submit" class="mt-2 mb-5 btn btn-primary">Submit</button>
    </form>
</div>


