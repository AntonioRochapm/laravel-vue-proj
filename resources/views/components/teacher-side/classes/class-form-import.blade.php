<div class="createClassWrapper">
    <div class="container card card-header card-color-login chooseTypeHeader">
        <h3>Create Class</h3>
        <div class="form-group card-body chooseTypeCard">
            @if(count($errors)>0)
                <div class="alert alert-danger">
                    Upload validation error
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if($message = Session::get('success'))
                <div class="alert alert-success alert-block">
                    <button type="button" class="close" data-dismiss="alert"></button>
                    <strong>{{ $message }}</strong>
                </div>
            @endif

            <form method="POST" enctype="multipart/form-data" action="{{ url('classes/import-excel/import') }}">
                @csrf
                <div class="form-group">
                    <label for="name" style="font-weight: bold">Class Name</label>
                    <input
                        type="text"
                        id="class_name"
                        name="class_name"
                        autocomplete="class_name"
                        placeholder="Type the class name"
                        class="form-control
                    @error('class_name') is-invalid @enderror"
                        value="{{ old('class_name') }}"
                        required
                        aria-describedby="nameHelp">

                    @error('class_name')
                    <span class="invalid-feedback" role="alert">
                        <stron>{{ $message }}</stron>
                    </span>
                    @enderror
                </div>

                <div class="form-group">
                    <table class="table">
                        <tr>
                            <td width="40%" align="right"><label for="">Select file to upload</label></td>
                            <td width="30%">
                                <input type="file" name="select_file">
                            </td>
                            <td width="30%" align="left">
                                <input type="submit" name="upload" class="btn btn-primary buttonGreen" value="Upload" required>
                            </td>
                        </tr>
                        <tr>
                            <td width="40%" align="right"></td>
                            <td width="30%"><span class="text-muted">.xls, .xlsx</span></td>
                            <td width="30%" align="left"></td>
                        </tr>
                    </table>
                </div>
            </form>

        </div>

    </div>
</div>
