<div class="row">
                    <div class="col-12 col-lg-4 border-r"> 
                        <div class="d-flex justify-content-between mb-4">
                            <h4 class="fw-medium">Order Lab Test</h4>
                        </div>
                        <form method="POST" id="ordertestform" autocomplete="off">
                            @csrf
                            <div class="row">
                            <?php
                                $corefunctions = new \App\customclasses\Corefunctions;
                            ?>
                                
                               
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

                               


                                <div class="col-12 subcategoryerror" id="search_li_subcategory"> 
                                </div>
                                <div class="col-12 subsearchcls" > 
                                    <div class="form-group form-outline form-dropdown no-icondropdown mb-4">
                                        <label class="float-label" for="input" id="subcategory_label">Sub Category</label>
                                        <!-- <input type="hidden" name="subcategory_ids" id="subcategory_ids"> -->
                                        <div class="dropdownBody dropdownBodyInner">
                                            <div class="dropdown">
                                                <a class="btn dropdown-toggle w-100"  role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <span class="material-symbols-outlined">keyboard_arrow_down</span>
                                                </a>
                                                <ul class="dropdown-menu w-100" aria-labelledby="dropdownMenuLink">

                                                   
                                                    <div id="search_li_subcategoryold">
                                                        <!-- @foreach ($categoryList  as $categoryList )
                                                        <li class="dropdown-item">
                                                            <p class="m-0" data-id="">MRA Arm</p>
                                                        </li>
                                                        @endforeach -->

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


                                <!-- <div class="col-12"> 
                                    <div class="form-group form-outline form-dropdown no-icondropdown mb-4">
                                        <label class="float-label" for="input" id="">Options</label>
                                        <input type="hidden" name="" id="">
                                        <div class="dropdownBody">
                                            <div class="dropdown">
                                                <a class="btn dropdown-toggle w-100" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <span class="material-symbols-outlined">keyboard_arrow_down</span>
                                                </a>
                                                <ul class="dropdown-menu w-100" aria-labelledby="dropdownMenuLink">
                                                    <li class="dropdown-item">
                                                        <input class="form-check-input btn-outline-checkbox m-0" name="" id="" type="checkbox" value="">
                                                        <samll class="gray fw-medium">Left</samll>
                                                    </li>
                                                    <li class="dropdown-item">
                                                        <input class="form-check-input btn-outline-checkbox m-0" name="" id="" type="checkbox" value="">
                                                        <samll class="gray fw-medium">Right</samll>
                                                    </li>
                                                    <li class="dropdown-item">
                                                        <input class="form-check-input btn-outline-checkbox m-0" name="" id="" type="checkbox" value="">
                                                        <samll class="gray fw-medium">External</samll>
                                                    </li>
                                                    <li class="dropdown-item">
                                                        <input class="form-check-input btn-outline-checkbox m-0" name="" id="" type="checkbox" value="">
                                                        <samll class="gray fw-medium">Bilateral</samll>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div> -->
                                <input type="hidden" name="labkey" id="labkey">
                                <div class="col-12"> 
                                    <div class="form-group form-outline form-textarea no-iconinput">
                                        <label for="input" class="float-label">Message</label>
                                        <textarea class="form-control" name="description" id="description" rows="4" cols="4"></textarea>
                                    </div>
                                </div>
                                <div class="d-flex gap-2 mt-4">
                                    <button onclick="submitOrder('all')" type="button" class="btn btn-primary w-50">Add All Items</button>
                                    <button onclick="submitOrder()" type="button" class="btn btn-primary w-50">Add Selected Items</button>
                                </div>

                                <!-- <div class="btn_alignbox mt-4">
                                    <button onclick="submitOrder('all')" type="button" class="btn btn-primary w-100">Add All Items</button>
                                    <button onclick="submitOrder()" type="button" class="btn btn-primary w-100">Add Selected Items</button>

                                

                                </div> -->
                            </div>
                        </form>
                    </div>
                    <div class="col-12 col-lg-8"> 
                        <div class="d-flex justify-content-between mb-4">
                            <h4 class="fw-medium">Preview</h4>
                            <div class="btn_alignbox">
                                <button type="button" class="btn btn-outline-primary gray btn-align" onclick="showPrintView();" data-bs-toggle="modal"  ><span class="material-symbols-outlined"> print</span>Save and Print</button>
                                <a  class="cls-btn" data-bs-dismiss="modal" aria-label="Close"><span class="material-symbols-outlined">close</span></a>
                            </div>
                        </div>

                        <div class="preview-container" id="previewlabs">

                        @include('appointment.labs.orderlist')

                                
                        </div>
                        <input type="hidden" name="all_entries" id="all_entries">
                    </div>
                </div>






<script>
      
function selectAllItems() {
    const vs = document.querySelector('#subcategories');
    if (!vs || !vs.virtualSelect || vs.offsetParent === null) {
        return ;
    }
    const allOptions = vs.virtualSelect.options;
    const allValues = allOptions.map(opt => opt.value);

    // Set all values
    vs.virtualSelect.setValue(allValues);
    

    // // Update placeholder-like text
    // const label = `${allOptions.length} subcategories selected`;
    // vs.querySelector('.vscomp-value').innerText = label;

   
    // Find the visible dropdown wrapper added by Virtual Select
    // const openDropdown = document.querySelector('.vscomp-wrapper.open');

    // if (!openDropdown) {
    //     console.warn("Dropdown is not open yet.");
    //     return;
    // }

    // // Find the "Select All" button inside the open dropdown
    // const selectAllButton = openDropdown.querySelector('.vscomp-toggle-all-button');

    // if (selectAllButton) {
    //     selectAllButton.click(); // Trigger the actual click
    // } else {
    //     console.warn("Select All button not found.");
    // }

  
} 
function clearAllItems() {
    const vs = document.querySelector('#subcategories');
    vs.virtualSelect.setValue([]);
}

$(document).ready(function() {
      
        
        $('input, textarea').each(function () {
             toggleLabel(this);
        });

        $("#ordertestform").validate({
                ignore: [],
                rules: {
                    
                    category_id: "required",
                    subcategory_id:{
                        required: {
                        depends: function(element) { 
                            return (  $("#category_id").val() != '11' );  
                        }
                     },
                    },
                    description:{
                        required: {
                        depends: function(element) { 
                            return (  $("#category_id").val() == '11' );  
                        }
                     },
                    },
                },
                messages: {
                   
                    category_id: "Please select a category.",
                    subcategory_id: "Please select a sub category.",
                    description: "Please enter the message.",
                },
                
                errorPlacement: function(error, element) {
                    if (element.attr('name') === 'subcategory_id') {
                        error.insertAfter('.multiselsub');
                    }else{
                        error.insertAfter(element);

                    }
                },
        });
    });
    function multiselectsub(){
        VirtualSelect.init({ 
            ele: '#subcategories',
            search: true,
            placeholder: 'Sub Category',
            multiple: true,
            showValueAsTags: false // disables the default tag list
        });

        
    }
    function getSubcategoryList(searchData,catId){
        var type = 'subcategory' ;

        $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "post",
                url: "{{url('/labs/search')}}" + "/" + type,
                data: {
                    'search': searchData,
                    'category_id': catId
                },
                success: function(response) {
                    console.log(response);
                    // Replace the dropdown items with the new HTML
                    $('.subsearchcls').hide();
                    $('#search_li_subcategory').show();
                    $('#search_li_subcategory').html(response.view);
                    multiselectsub();
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

        })

        $(document).on('click', '.select_subcategory_list', function() {

            var catItem = $(this).find('.select_subcategory_item').text();
            var catId = $(this).find('.select_subcategory_item').data('id');
            $('#subcategory_label').text(catItem);
            $('#subcategory_label').removeClass('active');
            $('#subcategory_id').val(catId);
            $("#subcategory_id").valid();

            // Check for duplicates in allFormData
            let isDuplicate = allFormData.some(entry => {
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

        $('#subcategories').on('change', function () {
            let selectedValues = $(this).val(); // array of selected subcategory IDs

            let duplicate = selectedValues.some(val =>
                allFormData.some(entry => entry.subcategory_id == val)
            );

            if (duplicate) {
                swal("Warning!", "One or more selected subcategories already exist.", "warning");
                $(this).val([]).trigger('change'); // Clear selection
            }
        });


      //Patient Search Section
      $('#search_category').on('keyup', function() {
        var type = 'category';
        var searchData = $('#search_category').val();

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "post",
                url: "{{url('/labs/search')}}" + "/" + type,
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
            var type = 'subcategory';
            var searchData = $('#search_subcategory').val();
            var catId = $('#category_id').val();
            getSubcategoryList(searchData,catId);
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "post",
                url: "{{url('/labs/search')}}" + "/" + type,
                data: {
                    'search': searchData,
                    'category_id':catId,
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