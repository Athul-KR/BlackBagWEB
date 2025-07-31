                <div class="row">
                    <div class="col-12 col-lg-4 border-r"> 
                        <div class="d-flex justify-content-between mb-4">
                            <h4 class="fw-medium">Order Radiology Test</h4>
                        </div>
                        <form method="POST" id="ordertestform" autocomplete="off">
                            @csrf
                            <div class="row">
                            <?php
                                $corefunctions = new \App\customclasses\Corefunctions;
                            ?>
                                <!-- <div class="col-12"> 
                                    <div class="form-group form-outline no-iconinput mb-4">
                                        <input type="text" class="form-control" name="test_date" id="test-date">
                                        <label class="float-label" for="test-date" id="test-date_label" >Date of test</label>
                                    </div>
                                </div> -->
                               

                                <div class="col-12"> 
                                    <div class="form-group form-outline form-dropdown no-icondropdown mb-4">
                                        <label class="float-label" for="input" id="category_label">Category</label>
                                        <input type="hidden" name="category_id" id="category_id">
                                        <div class="dropdownBody dropdownBodyInner">
                                            <div class="dropdown">
                                                <a class="btn dropdown-toggle w-100"  role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <span class="material-symbols-outlined">keyboard_arrow_down</span>
                                                </a>
                                                <ul class="dropdown-menu w-100" aria-labelledby="dropdownMenuLink">
                                                    <li class="dropdown-item">
                                                        <div class="form-outline input-group ps-1">
                                                            <div class="input-group-append">
                                                                <button class="btn border-0" type="button">
                                                                    <i class="fas fa-search fa-sm"></i>
                                                                </button>
                                                            </div>
                                                            <input id="search_category" name="search_category" class="form-control border-0 small" type="text" placeholder="Search Category" aria-label="Search" aria-describedby="basic-addon2">
                                                        </div>
                                                    </li>
                                                    <div id="search_li">
                                                        @foreach ($categoryList as $cls)
                                                        <li class="dropdown-item select_category" id="cat_{{$cls['id']}}">
                                                            <div class="dropview_body">
                                                                <p class="m-0 select_category_item" data-id="{{$cls['id']}}">{{$cls['name']}}</p>
                                                            </div>
                                                        </li>
                                                        @endforeach
                                                    </div>
                                                 
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12"> 
                                    <div class="form-group form-outline form-dropdown no-icondropdown mb-4">
                                        <label class="float-label" for="input" id="subcategory_label">Sub Category</label>
                                        <input type="hidden" name="subcategory_id" id="subcategory_id">
                                        <div class="dropdownBody dropdownBodyInner">
                                            <div class="dropdown">
                                                <a class="btn dropdown-toggle w-100"  role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <span class="material-symbols-outlined">keyboard_arrow_down</span>
                                                </a>
                                                <ul class="dropdown-menu w-100" aria-labelledby="dropdownMenuLink">

                                                    <li class="dropdown-item">
                                                        <div class="form-outline input-group ps-1">
                                                            <div class="input-group-append">
                                                                <button class="btn border-0" type="button">
                                                                    <i class="fas fa-search fa-sm"></i>
                                                                </button>
                                                            </div>
                                                            <input id="search_subcategory" name="search_subcategory" type="text" class="form-control border-0 small" placeholder="Search Sub Category" aria-label="Search" aria-describedby="basic-addon2">
                                                        </div>
                                                    </li>
                                                    <div id="search_li_subcategory">
                                                        <li class="dropdown-item">
                                                            <div class="dropview_body profileList justify-content-center">
                                                                <p>No records found</p>
                                                            </div>
                                                        </li>
                                                    </div>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="col-12" id="suboptions"> 
                                    <div class="row mb-4">
                                        @if(isset($optionsList))
                                        @foreach ($optionsList as $st)
                                            <div class="col-md-6">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="options[]" id="option_{{ $st['id'] }}" value="{{ $st['id'] }}">
                                                    <label class="form-check-label" for="option_{{ $st['id'] }}">
                                                        {{ $st['name'] }}
                                                    </label>
                                                </div>
                                            </div>

                                        @endforeach
                                    
                                        @endif
                                    </div>
                                </div>

                                <div class="col-12"> 
                                    <div class="row mb-4"> 
                                        <div class="col-6"> 
                                            <div class="form-check">
                                                 <input class="form-check-input" type="radio" value="1"name="is_contrast" id="iscontrast_yes" >
                                                 <label class="form-check-label" for="iscontrast_yes"> With Contrast</label>
                                             </div>
                                         </div>
                                         <div class="col-6"> 
                                            <div class="form-check">
                                                 <input class="form-check-input" type="radio" value="0"name="is_contrast" id="iscontrast_no">
                                                 <label class="form-check-label" for="iscontrast_no">Without Contrast</label>
                                             </div>
                                         </div>
                                         <input type="hidden" name="key" id="key" >
                                    </div>
                                </div>
                               
                                <div class="col-12"> 
                                    <div class="form-group form-outline form-textarea no-iconinput">
                                        <label for="input" class="float-label">Message</label>
                                        <textarea class="form-control" name="description" id="description" rows="4" cols="4"></textarea>
                                    </div>
                                </div>
                                <div class="btn_alignbox mt-4">
                                    <button id="submitbpbtn" onclick="submitImaging()" type="button" class="btn btn-primary w-100">Add to Order</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-12 col-lg-8"> 
                        <div class="d-flex justify-content-between mb-4">
                            <h4 class="fw-medium">Preview</h4>
                            <div class="btn_alignbox">
                                <button type="button"  onclick="showImaginfPrintView();"  class="btn btn-outline-primary gray btn-align" data-bs-toggle="modal" data-bs-dismiss="modal"><span class="material-symbols-outlined"> print</span>Save and Print</button>
                                <a class="cls-btn" data-bs-dismiss="modal" aria-label="Close"><span class="material-symbols-outlined">close</span></a>
                            </div>
                        </div>

                        <div class="preview-container" id="previewimaging">

                        @include('appointment.imaging.orderlist')
                                
                        </div>
                        <input type="hidden" name="labkey" id="labkey">
                        <input type="hidden" name="all_img_entries" id="all_img_entries">
                    </div>
                </div>




<link rel="stylesheet" href="{{ asset('css/bootstrap-datetimepicker.min.css')}}">
<script src="{{ asset('js/bootstrap-datetimepicker.min.js')}}"></script>

<script>


$(document).ready(function () {
    
});



    $(document).ready(function() {
        // getPreviewList();
         // Initialize the date picker
         $('#test-date').datetimepicker({
            format: 'MM/DD/YYYY',
            locale: 'en',
            useCurrent: true, // Prevents selecting the current date by default
            minDate: moment(),
            
        });

        $("#ordertestform").validate({
                ignore: [],
                rules: {
                    test_date  :"required",
                    category_id: "required",
                    subcategory_id:{
                        required: {
                        depends: function(element) { 
                            return (  $("#category_id").val() != '8' );  
                        }
                     },
                    },
                    description:{
                        required: {
                        depends: function(element) { 
                            return (  $("#category_id").val() == '8' );  
                        }
                     },
                    },
                  
                },
                messages: {
                    test_date: "Please select a date.",
                    category_id: "Please select a category.",
                    subcategory_id: "Please select a sub category.",
                    description: "Please enter the message.",
                },
                
                errorPlacement: function(error, element) {
                    error.insertAfter(element);
                },
        });
    });



    function getSubcategoryList(searchData,catId){
        var type = 'subcategory' ;

        $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "post",
                url: "{{url('/imaging/search')}}" + "/" + type,
                data: {
                    'search': searchData,
                    'category_id': catId
                },
                success: function(response) {
                    console.log(response);
                    // Replace the dropdown items with the new HTML
                    $('#search_li_subcategory').html(response.view);
                },
                error: function(xhr) {
                
                    handleError(xhr);
                },
            })
    }
        $(document).on('click', '.select_category', function() {

            var catItem = $(this).find('.select_category_item').text();
            var catId = $(this).find('.select_category_item').data('id');
            $('#category_label').text(catItem);
            $('#category_label').removeClass('active');
            $('#category_id').val(catId);
            $("#category_id").valid();
            var searchData = $('#search_subcategory').val();
            $('.select_subcategory_list').find('.select_subcategory_item').text('');
            $('#subcategory_id').val('');
            $('#subcategory_label').text('Sub Category');
            getSubcategoryList(searchData,catId);
            $("#suboptions").show();
            if(catId == '8'){
                $("#suboptions").hide();
            }
            let isDuplicate = allImgFormData.some(entry => {
                return  entry.category_id == catId;
            });

            if (isDuplicate && catId == '8') {
                swal("Warning!", 'This category has already been added.', "warning");
                $('#category_label').text('Category');
                $('#category_id').val('');
                return;
            }


        })

        $(document).on('click', '.select_subcategory_list', function() {

            var catItem = $(this).find('.select_subcategory_item').text();
            var catId = $(this).find('.select_subcategory_item').data('id');
            $('#subcategory_label').text(catItem);
            $('#subcategory_label').removeClass('active');
            $('#subcategory_id').val(catId);
            $("#subcategory_id").valid();
            
            let isDuplicate = allImgFormData.some(entry => {
                return  entry.subcategory_id == catId;
            });

            if (isDuplicate) {
                // Show alert or custom message
                swal("Warning!", 'This category and subcategory combination has already been added.', "warning");
                // alert('This category and subcategory combination has already been added.');
                $('#subcategory_label').text('Sub Category');
                $('#subcategory_id').val('');
                return;
            }
        })

      //Patient Search Section
      $('#search_category').on('keyup', function() {
        var type = 'category';
        var searchData = $('#search_category').val();

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "post",
                url: "{{url('/imaging/search')}}" + "/" + type,
                data: {
                    'search': searchData
                },
                success: function(response) {
                    console.log(response);
                    // Replace the dropdown items with the new HTML
                    $('#search_li').html(response.view);
                },
                error: function(xhr) {
                
                    handleError(xhr);
                },
            })

        })

          //Patient Search Section
      $('#search_subcategory').on('keyup', function() {
     
        var searchData = $('#search_subcategory').val();
        var catId = $('#category_id').val();
        getSubcategoryList(searchData,catId);

        })

                // Function to toggle the 'active' class

                $(document).ready(function () {
                function toggleLabel(input) {
                    const $input = $(input);
                    const value = $input.val();
                    const hasValue = value !== null && value.trim() !== ''; // Check for a non-empty value
                    const isFocused = $input.is(':focus');
            
                    // Ensure .float-label is correctly selected relative to the input
                    $input.siblings('.float-label').toggleClass('active', hasValue || isFocused);
                }
            
                // Initialize all inputs on page load
                $('input, textarea').each(function () {
                    toggleLabel(this);
                });
            
                // Handle input events
                $(document).on('focus blur input change', 'input, textarea', function () {
                    toggleLabel(this);
                });
            
                // Handle dynamic updates (e.g., Datepicker)
                $(document).on('dp.change', function (e) {
                    const input = $(e.target).find('input, textarea');
                    if (input.length > 0) {
                        toggleLabel(input[0]);
                    }
                });
            });




</script>