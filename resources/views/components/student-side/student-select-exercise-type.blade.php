<div class="chooseTypeWrap">
    <div class="container card card-header card-color-login chooseTypeHeader">
        <label class="student-side-select-a-type-label">Select a type</label>
        <div class="form-group card-body chooseTypeCard">
            <select class="form-control" id="types">
                <option value="0">Select exercise type</option>
                @foreach($types as $type)
                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                @endforeach
            </select>
            <button id="chooseTypeButton" onclick="siteRedirect()" class="btn btn-primary buttonGreen">GO!</button>
        </div>
    </div>
</div>

<script type="application/javascript">
    function siteRedirect(){

        let selectedValue = document.querySelector('#types').value;
        let selectedSubject = {{$subject}};
        location.replace(selectedSubject + "/" + selectedValue);
    }
</script>
