<form id="uploadfile" action="{{ url('file/upload') }}" method="post" enctype="multipart/form-data" autocomplete="off">
    @csrf <!-- Include CSRF token -->
    <input type="file" name="file" required accept=".xls,.xlsx,application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"> <!-- Add the required attribute for better UX -->
    <input type="hidden" name="type" value="{{$type}}">
    <button type="submit">Upload</button>
</form>