<?php $__env->startSection('title', 'Medical History'); ?>
<?php $__env->startSection('content'); ?>

<section class="details_wrapper">
    <div class="container">
        <div class="row">
            <div class="col=12 mb-3">
                <div class="web-card h-100 mb-3">

                    <h4>Medical History</h4>
                    <hr>
                    <div class="row">
                        <div class="col-12">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h5 class="fwt-medium">Note</h5>
                                <div class="btn_alignbox">
                                    <a class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-dismiss="modal"
                                        data-bs-target="#appointmentNotes">Edit Note</a>
                                </div>
                            </div>
                        </div>
                        <?php if(empty($patient->notes)): ?>
                            <div class="nofiles_body text-center w-100">
                                <img src="<?php echo e(asset('frontend/images/no_files.png')); ?>" class="">
                                <p>No Notes Added</p>
                            </div>
                        <?php endif; ?>
                        <div class="col-12">
                            <p><?php echo nl2br($patient->notes ?? ""); ?></p>
                        </div>
                        <div class="col-12">
                            <div class="d-flex justify-content-between">
                                <h5 class="fwt-medium">Files</h5>
                                <div class="btn_alignbox justify-content-end">
                                    <a class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-dismiss="modal"
                                        data-bs-target="#appointmentDoc">
                                        Add Files
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="files-container mt-3">
                                <?php if(empty($patientDocument)): ?>
                                    <div class="nofiles_body text-center w-100">
                                        <img src="<?php echo e(asset('frontend/images/no_files.png')); ?>" class="">
                                        <p>No Files Added</p>
                                    </div>
                                <?php endif; ?>
                                <?php $__currentLoopData = $patientDocument; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $patientDoc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <?php
                                                                    // Determine the image path based on the file extension
                                                                    $imagePath = '';
                                                                    if ($patientDoc['doc_ext'] == 'png') {
                                                                        $imagePath = asset('images/png_icon.png');
                                                                    } elseif ($patientDoc['doc_ext'] == 'jpg') {
                                                                        $imagePath = asset('images/jpg_icon.png');
                                                                    } elseif ($patientDoc['doc_ext'] == 'pdf') {
                                                                        $imagePath = asset('images/pdf_img.png');
                                                                    } elseif ($patientDoc['doc_ext'] == 'xlsx') {
                                                                        $imagePath = asset('images/excel_icon.png');
                                                                    } else {
                                                                        $imagePath = asset('images/doc_image.png');
                                                                    }
                                                                ?>

                                                                <div id="img_div" class="fileBody">
                                                                    <div class="file_info" id="appenddocs">
                                                                        <img id="editpatientimage" src="<?php echo e($imagePath); ?>">
                                                                        <span><?php echo e($patientDoc['orginal_name']); ?></span>
                                                                    </div>
                                                                    <a onclick="removeDoc('<?php echo e($patientDoc['patient_doc_uuid']); ?>')"><span
                                                                            class="material-symbols-outlined">close</span></a>
                                                                </div>

                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>



<!-- Dropzone -->
<div class="modal fade" id="appointmentDoc" tabindex="-1" aria-labelledby="appointmentNotesLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-body">
                <h4 class="modal-title" id="appointmentNotesLabel">Upload Documents</h4>
                <form method="post" id="doc_form">
                    <div class="dropzone-wrapper mt-3 dropzone custom-dropzone" id="patientDocs">

                    </div>
                    <div id="img_div">
                        <div class="files-container mb-3" id="appenddocsmodal">

                        </div>
                    </div>

                    <div class="btn_alignbox justify-content-end mt-4">

                        <button type="button" id="close_doc_modal" onclick="closeDocsModal()"
                            class="btn btn-primary">Close</button>
                        <button type="button" id="save_doc_btn" onclick="saveDocs()"
                            class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>




<!-- Notes Modal-->

<div class="modal fade" id="appointmentNotes" tabindex="-1" aria-labelledby="appointmentNotesLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-body">
                <h4 class="modal-title mb-3" id="appointmentNotesLabel">Appointment Notes</h4>
                <form method="post" action="<?php echo e(route('frontend.noteUpdate')); ?>">
                    <?php echo csrf_field(); ?>

                    <textarea name="notes" id="notes"
                        class="form-control  tinymce-editor tinymce_notes"><?php echo e($patient->notes); ?></textarea>
                    <input type="hidden" id="has_notes" name="has_notes">

                    <div class="btn_alignbox justify-content-end mt-4">
                        <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



<script>
    $(document).ready(function () {
        initiateEditorwithSomeMainPlugin('notes');
    });

    Dropzone.autoDiscover = false;
    // Dropzone Configurations
    var dropzone = new Dropzone('#patientDocs', {
        url: '<?php echo e(url('/patient/uploaddocument')); ?>',
        addRemoveLinks: true,
        dictDefaultMessage: '<span class="material-symbols-outlined icon-add">add</span> Add patient files', // Add class for styling
        headers: {
            'X-CSRF-TOKEN': "<?php echo e(csrf_token()); ?>"
        },
        init: function () {
            this.on("sending", function (file, xhr, formData) {
                // Extra data to be sent with the file
                formData.append("formdata", $('#createinquiry').serialize());
            });
            this.on("removedfile", function (file) {
                $(".remv_" + file.filecnt).remove();
            });
            var filecount = 1;
            this.on('success', function (file, response) {
                if (response.success == 1) {

                    this.removeFile(file);
                    file.filecnt = filecount;
                    if (response.ext == 'png') {
                        var imagePath = "<?php echo e(asset('images/png_icon.png')); ?>";
                    } else if (response.ext == 'jpg') {
                        var imagePath = "<?php echo e(asset('images/jpg_icon.png')); ?>";
                    } else if (response.ext == 'pdf') {
                        var imagePath = "<?php echo e(asset('images/pdf_img.png')); ?>";
                    } else if (response.ext == 'xlsx') {
                        var imagePath = "<?php echo e(asset('images/excel_icon.png')); ?>";
                    } else {
                        var imagePath = "<?php echo e(asset('images/doc_image.png')); ?>";
                    }
                    console.log(response.ext)
                    var appnd = '<div class="fileBody" id="doc_' + filecount + '"><div class="file_info"><img src="' + imagePath + '"><span>' + response.docname + '</span>' +
                        '</div><a onclick="removeImageDoc(' + filecount + ')"><span class="material-symbols-outlined">close</span></a></div>' +
                        '<input type="hidden" name="patient_docs[' + filecount + '][tempdocid]" value="' + response.tempdocid + '" >';

                    $("#appenddocsmodal").append(appnd);
                    filecount++
                    // $("#docuplad").val('1');
                    // $("#docuplad").valid();
                } else {
                    if (typeof response.error !== 'undefined' && response.error !== null && response.error == 1) {
                        swal(response.errormsg);
                        this.removeFile(file);
                    }
                }
            });
        },
    });

    function removeImageDoc(count) {
        $("#doc_" + count).remove();
    }


    function saveDocs() {

        var url = "<?php echo e(route('frontend.storeDocs')); ?>";
        var docLength = $('#doc_form').find('.fileBody').length;

        // if (docLength > 0) {

        $.ajax({
            url: url,
            type: "post",
            data: {
                'formdata': $("#doc_form").serialize(),
                '_token': $('input[name=_token]').val()
            },
            success: function (data) {
                if (data.success == 1) {
                    window.location.href = "<?php echo e(url('/medical-history')); ?>";
                } else {

                }
            }
        });
        // } else {
        //     $('#save_doc_btn').prop('disabled', true);
        // }
    }

    function closeDocsModal() {
        $("#appointmentDoc").modal('hide');
        // Reset the form fields
        $("#doc_form")[0].reset();

        // Clear the Dropzone
        var dropzone = Dropzone.forElement("#patientDocs");
        if (dropzone) {
            dropzone.removeAllFiles(true);
        }

        // Clear the image preview container
        $("#appenddocsmodal").empty();

    }

    function removeDoc(uuid) {

        var url = "<?php echo e(route('frontend.removeDocs')); ?>";

        swal("Are you sure you want to remove this document?", {
            title: "Remove!",
            icon: "warning",
            buttons: true,
        }).then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    url: url,
                    type: "post",
                    data: {
                        'uuid': uuid,
                        '_token': $('input[name=_token]').val()
                    },
                    success: function (data) {
                        if (data.success == 1) {
                            window.location.href = "<?php echo e(url('/medical-history')); ?>";
                        } else {

                        }
                    }
                });
            }
        });

    }


    function removeDocs(key) {

        swal({
            title: "Are you sure you want to remove this document?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonClass: "btn-danger",
            confirmButtonText: "OK",
            cancelButtonText: "Cancel",
            showLoaderOnConfirm: false,
            preConfirm: () => {
                $("#doc_" + key).remove();
                $("#patient_doc_exists" + key).val('');

            }
        });


    }



    function initiateEditorwithSomeMainPlugin(editorID) {
        //tinymce.remove('.tinymce_' + editorID);
        tinymce.init({
            selector: '.tinymce_' + editorID,
            height: 250,
            menubar: false,
            plugins: 'image code',
            paste_as_text: true,
            entity_encoding: "raw",
            relative_urls: false,
            remove_script_host: false,
            // verify_html:false,

            images_upload_handler: function (blobInfo, success, failure) {
                // var input = document.createElement('input');
                // input.setAttribute('type', 'file');
                // input.setAttribute('accept', 'image/*');
                var xhr, formData;
                xhr = new XMLHttpRequest();
                xhr.withCredentials = false;
                xhr.open('POST', '<?php echo e(URL::to("/editorupload")); ?>');
                var token = '<?php echo e(csrf_token()); ?>';
                xhr.setRequestHeader("X-CSRF-Token", token);
                xhr.onload = function () {
                    var json;
                    if (xhr.status != 200) {
                        failure('HTTP Error: ' + xhr.status);
                        return;
                    }
                    json = JSON.parse(xhr.responseText);

                    if (!json || typeof json.location != 'string') {
                        failure('Invalid JSON: ' + xhr.responseText);
                        return;
                    }
                    success(json.location);
                };
                formData = new FormData();
                formData.append('file', blobInfo.blob(), blobInfo.filename());
                xhr.send(formData);
                //alert(formData);
            },
            plugins: [

                'advlist', 'autolink', 'lists',

                'anchor', 'searchreplace', 'visualblocks', 'fullscreen',
                'insertdatetime', 'media', 'table', 'wordcount'
            ],
            toolbar: 'undo redo | blocks | ' +
                'bold italic | alignleft aligncenter ' +

                'alignright alignjustify ',

            setup: function (ed) {
                ed.on('init', function (args) {
                    $('#pretxt_' + editorID).hide();
                    $('.editordiv_' + editorID).show();
                });
                ed.on('change', function (e) {
                    calculateEditorCount(editorID);

                    $("#" + editorID).val(ed.getContent());
                });
                ed.on('keyup', function (e) {
                    calculateEditorCount(editorID);

                    $("#" + editorID).val(ed.getContent());
                    console.log(ed.getContent());
                });
            }
        });
    }
    function calculateEditorCount(editorid) {

        var editorwordcount = getStats(editorid).words;

        editorwordcount = editorwordcount - 1;
        //alert(editorwordcount);
        $("#has_" + editorid).val('');

        if (editorwordcount > 0) {

            $("#has_" + editorid).val(1);
            $("#has_" + editorid).valid();
        }

        //$("#hascontent").valid();
    }

    function getStats(id) {

        var body = tinymce.get(id).getBody(),
            text = tinymce.trim(body.innerText || body.textContent);

        return {
            chars: text.length,
            words: text.split(/[\w\u2019\'-]+/).length
        };
    }

</script>

<script>





</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('frontend.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Xampp\htdocs\blackbag\resources\views/frontend/medical-history.blade.php ENDPATH**/ ?>