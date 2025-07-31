<h4 class="text-start fwt-bold mb-4">Edit Folder</h4>
<div class="row">
    <div class="col-12"> 
        <form id="editfolderform" method="post" autocomplete="off">
        @csrf
            <div class="row">
                <div class="col-lg-12 col-12">
                     <div class="form-group form-outline mb-3">
                        <label for="edit_folder_name" class="float-label">Folder Name</label>
                        <i class="fa-solid fa-folder-open"></i>
                        <input type="text" name="edit_folder_name" class="form-control" id="edit_folder_name" value="{{$folder['folder_name']}}">
                    </div>
                </div>
                <div class="btn_alignbox justify-content-end"> 
                    <a href="javascript:void(0);" onclick="hideEditFolderModal();" class="btn btn-outline-primary">Cancel</a>
                    <a href="javascript:void(0);" onclick="updateFolder('{{$folder['fc_user_folder_uuid']}}');" class="btn btn-primary">Update</a>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
    $(document).ready(function() {
        $("#editfolderform").validate({
            rules: {
                edit_folder_name: "required",
            },
            messages: {
                edit_folder_name: "Please enter folder name",
            }
        });
        // Add prevent default for enter key
        $("#editfolderform").on('keypress', function(e) {
            if (e.which === 13) { // Enter key code
                e.preventDefault();
                updateFolder('{{$folder['fc_user_folder_uuid']}}');
                // return false;
            }
        });
    });
    function hideEditFolderModal(){
        $("#editfoldermodal").modal('hide');
    }
    function updateFolder(key){
        if($("#editfolderform").valid()){
            let formdata = $("#editfolderform").serialize();
            $.ajax({
                url: '{{ url("/folder/update")}}',
                type: "post",
                data: {
                    'formdata': formdata,
                    'key': key,
                    '_token': $('input[name=_token]').val()
                },
                success: function(data) {
                    if (data.success == 1) {
                        swal({
                            title: "Success!",
                            text: data.message,
                            icon: "success",
                            timer: 1000,
                            buttons: false
                        }).then(() => {
                            $("#editfoldermodal").modal('hide');
                            showFolders();
                        }); 
                    } else {
                        swal("Error!", data.message, "error");
                    }
                },
                error: function(xhr) {
                    
                    handleError(xhr);
                },
            });
        }
    }
</script>