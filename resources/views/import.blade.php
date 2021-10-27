<form method="post" enctype="multipart/form-data" action="{{url('import')}}">
    @csrf
    <div class="form-group">
        <label for="exampleFormControlFile1">Example file input</label>
        <input type="file" name="file" class="form-control-file" id="exampleFormControlFile1">
    </div>

    <button type="submit">Submit</button>
</form>
