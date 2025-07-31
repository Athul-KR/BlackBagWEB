                                    <div class="outer-wrapper box-cnt-inner">
                                        <div class="accordion accordion-flush" id="accordionFlushExampleHistory">
                                            @foreach ($medicalHistory as $index => $item)
                                                @php
                                                    $collapseId = 'flush-collapse-' . $index;
                                                    $headingId = 'flush-heading-' . $index;
                                                @endphp

                                                <div class="accordion-item">
                                                    <h2 class="accordion-header" id="{{ $headingId }}">
                                                        <button class="accordion-button collapsed" type="button"
                                                            data-bs-toggle="collapse"
                                                            data-bs-target="#{{ $collapseId }}"
                                                            aria-expanded="false"
                                                            aria-controls="{{ $collapseId }}" onclick="getHistoryDetails('{{$item['type']}}','history','{{$index}}')">
                                                            <div class="row align-items-center collapse-header w-100">
                                                                <div class="col-12">
                                                                    <h5 class="fw-medium">{{ $item['title'] }}</h5>
                                                                </div>
                                                            </div>
                                                            <span class="material-symbols-outlined arrow-btn">keyboard_arrow_down</span>
                                                        </button>
                                                    </h2>
                                                    <div id="{{ $collapseId }}" class="accordion-collapse collapse"
                                                        aria-labelledby="{{ $headingId }}"
                                                        data-bs-parent="#accordionFlushExampleHistory">
                                                        <div class="col-12 mt-3">
                                                            <div class="btn_alignbox justify-content-end">
                                                                <a onclick="addmedications('{{$item['type']}}')" class="btn btn-primary btn-sm btn-align" data-bs-toggle="modal" data-bs-dismiss="modal" data-bs-target="#adddata">
                                                                    <span class="material-symbols-outlined">add</span>Add Data
                                                                </a>
                                                            </div>
                                                        </div>
                                                        <div class="accordion-body" id="{{$item['type']}}-history">

                                                           

                                                        </div>
                                                    
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
   
                                                           
                                                

        <script>

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