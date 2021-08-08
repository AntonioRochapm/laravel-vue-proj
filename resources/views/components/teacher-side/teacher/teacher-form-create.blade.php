<div class="teacherContentWrap">
    <div class="container card card-color-login card-header teacherFormHeader">
        <h3 style="color:white;">Add Teacher</h3>
        <div class="formWrapTeacher">
            <form method="POST" action="{{ url('teacher-side') }}" style="width: 40%">
                @csrf

                <div class="form-group form-group-align">
                    <label for="name">Name</label>
                    <input
                        type="text"
                        id="name"
                        name="name"
                        autocomplete="name"
                        placeholder="Type the name"
                        class="form-control
                @error('name') is-invalid @enderror"
                        value="{{ old('name') }}"
                        required
                        aria-describedby="nameHelp">

                    @error('name')
                    <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="name">{{ __('E-Mail Address') }}</label>
                    <input id="email"
                           type="email"
                           placeholder="Type the email"
                           class="form-control

                       @error('email') is-invalid @enderror"
                           name="email"
                           value="{{ old('email') }}"
                           required
                           autocomplete="email">

                    @error('email')
                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="state">Is the teacher an administrator?</label>
                    <div>
                        <input type="radio" id="is_admin" name="is_admin" value="1">
                        <label for="yes">Yes</label>
                        <input type="radio" id="is_admin" name="is_admin" value="0">
                        <label for="no">No</label>
                    </div>
                </div>


                <div class="form-group teacherAlign">
                    <label for="password" class="col-md-4 col-form-label text-md-center">{{ __('Password') }}</label>

                    <div class="col-md-6">
                        <input id="password"
                               type="password"
                               class="form-control
                       @error('password') is-invalid @enderror"
                               name="password"
                               required
                               autocomplete="new-password">

                        @error('password')
                        <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                    </span>
                        @enderror
                    </div>
                    <label for="password-confirm" class="col-md-4 col-form-label text-md-center">{{ __('Confirm Password') }}</label>

                    <div class="col-md-6">
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                    </div>
                </div>
                <button type="submit" class="mt-2 mb-5 btn btn-primary buttonGreen">Submit</button>
            </form>
        </div>
    </div>
</div>
