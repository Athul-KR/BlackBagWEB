<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Address Autocomplete</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&libraries=places&callback=initAutocomplete" async defer></script>
</head>
<body>

<div class="container">
    <h1>Address Autocomplete</h1>

    <!-- Country selector dropdown -->
    <div class="form-group">
        <label for="country">Select Country</label>
        <select id="country" class="form-control">
            <option value="us">United States</option>
            <option value="ca">Canada</option>
            <!-- Add more countries as needed -->
        </select>
    </div>

    <!-- Form to handle the address input -->
    <form id="address-form">
        <div class="form-group">
            <label for="address">Address</label>
            <input type="text" id="address" class="form-control" name="address" placeholder="Enter address">
            <span id="error-message" class="text-danger" style="display: none;">Address is required</span>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>

<script>
    jQuery.browser = {};
	(function() {
		jQuery.browser.msie = false;
		jQuery.browser.version = 0;
		if (navigator.userAgent.match(/MSIE ([0-9]+)\./)) {
			jQuery.browser.msie = true;
			jQuery.browser.version = RegExp.$1;
		}
	})();
    let autocomplete;

    function initAutocomplete() {
        const countryCode = $('#country').val();  // Default country is US

        // Initialize the Google Places Autocomplete
        autocomplete = new google.maps.places.Autocomplete(
            document.getElementById('address'),
            {
                componentRestrictions: { country: countryCode }, // Restrict to selected country
                fields: ['address_components', 'geometry', 'formatted_address'], // Request additional fields
            }
        );

        // Add a listener to handle the selected place
        autocomplete.addListener('place_changed', onPlaceChanged);
    }

    // Handle the place change
    function onPlaceChanged() {
        const place = autocomplete.getPlace();

        if (!place.geometry) {
            alert("No details available for input: '" + place.name + "'");
            return;
        }

        const address = place.formatted_address;
        console.log("Selected address: ", address);

        // Optionally, you can call the backend geocode endpoint to get more details
        $.ajax({
            url: "{{ route('address.geocode') }}",
            method: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                address: address,
                country: $('#country').val()
            },
            success: function(response) {
                console.log('Geocoding response:', response);
                // Handle the response, for example, save to database or show additional info
            },
            error: function(error) {
                console.error('Error:', error);
            }
        });
    }

    // Form submission logic
    $('#address-form').submit(function (e) {
        e.preventDefault();

        const address = $('#address').val();
        if (address.trim() === '') {
            $('#error-message').show();
            return;
        } else {
            $('#error-message').hide();
        }

        // Submit the form data (AJAX) or you can add further validation here
        $.ajax({
            url: "{{ route('address.save') }}",
            method: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                address: address,
                country: $('#country').val()
            },
            success: function (response) {
                alert(response.message);
            },
            error: function (error) {
                console.error('Error:', error);
            }
        });
    });

    // Update country-specific autocomplete when the country changes
    $('#country').change(function () {
        const countryCode = $(this).val();
        autocomplete.setComponentRestrictions({ country: countryCode });
    });
</script>

</body>
</html>
