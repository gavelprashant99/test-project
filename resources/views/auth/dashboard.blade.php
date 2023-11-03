<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Custom Authentication</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Dashboard</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown"
            aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="dashboard/ulbregistration">ULB Registration</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="dashboard/ulblist">ULB List</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="ulblogin">ULB Login</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="dashboard/uploaddocument">Upload Document</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="dashboard/verify">Verify Document</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="stateportalreg">State Portal Registration</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="stateportallogin">State Portal Login</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="distportalreg">District Portal Registration</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="distportallogin">District Portal Login</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="dashboard/passwordreset">Forget Password?</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout">Logout</a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Sambhag Dropdown -->
    <div class="sambhag-dropdown">
        <select id="sambhag-dropdown">
            <option value="">Select Sambhag</option>
            @foreach ($data['sambhags'] as $sambhag)
                <option value="{{ $sambhag->sambhag_id }}">{{ $sambhag->sambhag_name }}</option>
            @endforeach
        </select>
    </div>

    <!-- District Dropdown (Populated via Ajax) -->
    <div id="district-dropdown-container">
        <select id="district-dropdown">
            <option value="">Select District</option>
        </select>
    </div>

    <!-- NAGAR NIGAM Dropdown (Populated via Ajax) -->
    <div id="district-dropdown-container">
        <select id="nagarnigam-dropdown">
            <option value="">Select Nagar Nigam</option>
        </select>
    </div>

    <!-- NAGAR PALIKA Dropdown (Populated via Ajax) -->
    <div id="district-dropdown-container">
        <select id="nagarpalika-dropdown">
            <option value="">Select Nagar Palika</option>
        </select>
    </div>

    <!-- NAGAR PANCHAYAT (Populated via Ajax) -->
    <div id="district-dropdown-container">
        <select id="nagarpanchayat-dropdown">
            <option value="">Select Nagar Panchayat</option>
        </select>
    </div>
</body>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#sambhag-dropdown').change(function() {
            var sambhagId = $(this).val();

            if (sambhagId) {
                $.ajax({
                    url: '/get-districts/' + sambhagId, // Update with the correct route
                    type: 'GET',
                    success: function(data) {
                        console.log(data);
                        var districtDropdown = $('#district-dropdown');
                        districtDropdown.empty();
                        districtDropdown.append(
                            '<option value="">Select District</option>');
                        $.each(data, function(key, value) {
                            districtDropdown.append('<option value="' + value
                                .district_id + '">' + value.district_name +
                                '</option>');
                        });
                    },
                    error: function(xhr, status, error) {
                        console.log(error);
                    }
                });
            } else {
                $('#district-dropdown').empty(); // Clear the dropdown
            }
        });
    });


    $(document).ready(function() {
        $('#district-dropdown').change(function() {
            var districtId = $(this).val();
            if (districtId) {
                $.ajax({
                    url: '/get-nagarnigam/' + districtId, // Update with the correct route
                    type: 'GET',
                    success: function(data) {
                        console.log(data);
                        var nigamDropdown = $('#nagarnigam-dropdown');
                        nigamDropdown.empty();
                        nigamDropdown.append('<option value="">Select Nigam</option>');
                        $.each(data, function(key, value) {
                            nigamDropdown.append('<option value="' + value
                                .nn_id + '">' + value.nn_name +
                                '</option>');
                        });
                    },
                    error: function(xhr, status, error) {
                        console.log(error);
                    }
                });
            } else {
                $('#nagarnigam-dropdown').empty(); // Clear the dropdown
            }
        });
    });

    $(document).ready(function() {
        $('#district-dropdown').change(function() {
            var districtId = $(this).val();
            if (districtId) {
                $.ajax({
                    url: '/get-nagarpalika/' + districtId, // Update with the correct route
                    type: 'GET',
                    success: function(data) {
                        console.log(data);
                        var palikaDropdown = $('#nagarpalika-dropdown');
                        palikaDropdown.empty();
                        palikaDropdown.append('<option value="">Select Palika</option>');
                        $.each(data, function(key, value) {
                            palikaDropdown.append('<option value="' + value
                                .np_id + '">' + value.np_name +
                                '</option>');
                        });
                    },
                    error: function(xhr, status, error) {
                        console.log(error);
                    }
                });
            } else {
                $('#nagarpalika-dropdown').empty(); // Clear the dropdown
            }
        });
    });

    $(document).ready(function() {
        $('#district-dropdown').change(function() {
            var districtId = $(this).val();
            if (districtId) {
                $.ajax({
                    url: '/get-nagarpanchayat/' + districtId, // Update with the correct route
                    type: 'GET',
                    success: function(data) {
                        console.log(data);
                        var panchayatDropdown = $('#nagarpanchayat-dropdown');
                        panchayatDropdown.empty();
                        panchayatDropdown.append(
                            '<option value="">Select Panchayat</option>');
                        $.each(data, function(key, value) {
                            panchayatDropdown.append('<option value="' + value
                                .npan_id + '">' + value.npan_name +
                                '</option>');
                        });
                    },
                    error: function(xhr, status, error) {
                        console.log(error);
                    }
                });
            } else {
                $('#nagarpanchayat-dropdown').empty(); // Clear the dropdown
            }
        });
    });
</script>


</html>
