<div class="text-center mb-4 px-xl-5 px-3">
    <h4 class="text-center fw-bold mb-1">Book Appointment</h4>
    <p class="gray fw-light mb-0">Select a preferred doctor for your appointment.</p>
</div>
<form method="POST" action="" id="bookappointmentform">
    @csrf
    <div class="row g-4"> 
        <div class="col-12"> 
            <div class="form-group form-outline mb-3 no-iconinput">
                <label for="input" id="selectedClinicInput">Select Clinic</label>
                <div class="dropdownBody">
                    <div class="dropdown">
                        <a class="btn dropdown-toggle w-100" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                            <span class="material-symbols-outlined">keyboard_arrow_down</span>
                        </a>
                        <ul class="dropdown-menu w-100" aria-labelledby="dropdownMenuLink" style="">
                            <li class="dropdown-item">
                                <div class="form-outline input-group ps-1">
                                    <div class="input-group-append">
                                        <button class="btn border-0" type="button"><i class="fas fa-search fa-sm"></i></button>
                                    </div>
                                    <input type="text" id="clinicSearchInput" class="form-control border-0 small" placeholder="Search Clinics" aria-label="Search" aria-describedby="basic-addon2">
                                    <div class="input-group-append" id="clearSearchBtnContainer" style="display: none;">
                                        <button class="btn border-0" type="button" id="clearSearchBtn">
                                            <i class="fas fa-times-circle fa-sm"></i> </button>
                                    </div>
                                </div>
                            </li>
                            @if(!empty($clinics))
                                @foreach($clinics as $clinic)
                                    <li class="dropdown-item clinic-option" data-id="{{ $clinic['id'] }}">
                                        <div class="dropview_body profileList">
                                            <img src="{{$clinic['clinic_logo']}}" class="img-fluid">
                                            <p class="m-0">{{$clinic['name']}}</p>
                                        </div>
                                    </li>
                                @endforeach
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
             <!-- Clear Filter Button -->
                <div class="mt-2 text-end" id="clearClinicFilterContainer" style="display: none;">
                    <button type="button" class="btn btn-sm btn-outline-secondary" id="clearClinicFilterBtn">
                        Clear Filter
                    </button>
                </div>
        </div>
        <div class="col-12 mt-0"> 
            <h4 class="text-strat fw-bold mb-0 ">Select Doctor</h4>
            <div class="gray-border my-3"></div>
        </div>
        <div class="col-12 mt-2">
            <div class="row justify-content-center g-3" id="clinicUsersContainer">
                @include('frontend.clinicusers')
            </div>
        </div>
    </div>
</form>        
<script>
    document.getElementById('clinicSearchInput').addEventListener('keydown', function(event) {
        if (event.key === 'Enter' || event.keyCode === 13) {
            event.preventDefault();
        }
    });
    $(document).ready(function () {
        $('#clinicSearchInput').on('keyup', function () {
            var searchTerm = $(this).val().toLowerCase();
            $('.clinic-option').each(function () {
                var clinicName = $(this).text().toLowerCase();
                $(this).toggle(clinicName.includes(searchTerm));
            });
        });
        
        const label = document.getElementById('selectedClinicInput');
    const dropdownToggle = document.getElementById('dropdownMenuLink');
    const clinicOptions = document.querySelectorAll('.clinic-option');
    const searchInput = document.getElementById('clinicSearchInput');
    const clearSearchBtnContainer = document.getElementById('clearSearchBtnContainer');
    const clearClinicFilterBtn = document.getElementById('clearClinicFilterBtn');

    function resetClinicSelection() {
        // Reset label text
        label.innerText = 'Select Clinic';

        // Reset dropdown button text
        dropdownToggle.innerHTML = `<span class="material-symbols-outlined">keyboard_arrow_down</span>`;

        // Remove selected highlight if applied
        clinicOptions.forEach(opt => {
            opt.classList.remove('selected'); // If you use a "selected" class
            opt.style.display = 'block';      // Show all clinics
        });

        // Clear search input
        if (searchInput) {
            searchInput.value = '';
        }

        // Hide search clear button
        if (clearSearchBtnContainer) {
            clearSearchBtnContainer.style.display = 'none';
        }// Hide clear button
        if (clearClinicFilterBtn) {
            clearClinicFilterBtn.style.display = 'none';
        }
          showPreloader('clinicUsersContainer');
            $.ajax({
                url: '{{ url("/getclinicusers") }}',
                method: 'POST',
                data: {
                    clinic_id: '',
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if(response.success == 1){
                        $("#clinicUsersContainer").html(response.view);
                    }
                },
                error: function(xhr) {
                    if(xhr.status != 403){
                        handleError(xhr);
                    }
                },
                complete: function() {
                    isRequestProgress = false;
                    console.log('Request complete');
                }
            });
    }


        const clearBtn = document.getElementById('clearClinicFilterBtn');
        if (clearBtn) {
            clearBtn.addEventListener('click', resetClinicSelection);
        }
        
           $('.clinic-option').on('click', function () {
            
            const clearSearchBtnContainer = document.getElementById('clearClinicFilterContainer');
            var clinicId = $(this).data('id');

            clearSearchBtnContainer.style.display = clinicId ? 'block' : 'none';
            var clinicId = $(this).data('id');
            const clinicName = $(this).find('p').text().trim();
            $('#selectedClinicInput').text(clinicName);
            showPreloader('clinicUsersContainer');
            $.ajax({
                url: '{{ url("/getclinicusers") }}',
                method: 'POST',
                data: {
                    clinic_id: clinicId,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if(response.success == 1){
                        $("#clinicUsersContainer").html(response.view);
                    }
                },
                error: function(xhr) {
                    if(xhr.status != 403){
                        handleError(xhr);
                    }
                },
                complete: function() {
                    isRequestProgress = false;
                    console.log('Request complete');
                }
            });
        });
    });



</script>