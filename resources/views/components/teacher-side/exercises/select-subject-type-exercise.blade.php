<div class="container">
    <div class="row">
        <div class="col-lg-9">
            <div class="row mt-4">
                <div class="card h-100">
                    <div class="card-body">
                            <div class="form-group">
                                <label>Select a Subject</label>
                                <select class="form-control" id="subject">
                                    <option value="0">Select Subject</option>
                                    @foreach($subjects as $subject)
                                        <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Select an Exercise Model</label>
                                <select class="form-control" id="types">
                                    <option value="0">Select Exercise Model</option>
                                    {@foreach($types as $type)
                                        <option value="{{ $type->slug }}">{{ $type->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        <button onclick="siteRedirect()" class="btn btn-submit">GO</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="application/javascript">
    function siteRedirect(){
        let selectedValue = document.querySelector('#types').value;
        let selectedSubject = document.querySelector('#subject').value;
        location.replace(selectedValue + "/" + selectedSubject);
    }
</script>


