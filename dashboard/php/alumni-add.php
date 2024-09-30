<?php
// Start the session only if it hasn't been started yet
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../style/style.css">

    <title>Alumni Create</title>
    <style>
        .conditional-fields {
            display: none; /* Hide conditional fields by default */
        }
    </style>
</head>

<body>

    <div class="container mt-5">

        <?php include('message.php'); ?>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Alumni Add
                            <a href="index.php" class="btn btn-danger float-end">BACK</a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <form action="alumni-submit.php" method="POST">

                            <div class="mb-3">
                                <label>Student Number</label>
                                <input type="text" name="student_number" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label>Last Name</label>
                                <input type="text" name="last_name" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label>First Name</label>
                                <input type="text" name="first_name" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label>Middle Name</label>
                                <input type="text" name="middle_name" class="form-control">
                            </div>

                            <div class="mb-3">
                                <label>College</label>
                                <select name="college" id="college" class="form-control" required>
                                    <option value="">Select College</option>
                                    <option value="CITCS">CITCS</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label>Department</label>
                                <select name="department" id="department" class="form-control" required>
                                    <option value="">Select Department</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label>Section</label>
                                <select name="section" id="section" class="form-control" required>
                                    <option value="">Select Section</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label>Year Graduated</label>
                                <input type="number" name="year_graduated" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label>Contact Number</label>
                                <input type="text" name="contact_number" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label>Personal Email</label>
                                <input type="email" name="personal_email" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label>Working Status</label>
                                <select name="working_status" id="working_status" class="form-control" required>
                                    <option value="">Select Working Status</option>
                                    <option value="Employed">Employed</option>
                                    <option value="Unemployed">Unemployed</option>
                                    <option value="Self-employed">Self-employed</option>
                                </select>
                            </div>

                            <div class="conditional-fields" id="employment_details">
                                <h5>Employment Details</h5>
                                <div class="mb-3">
                                    <label>Present Occupation</label>
                                    <input type="text" name="present_occupation" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label>Name of Employer</label>
                                    <input type="text" name="employer_name" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label>Address of Employer</label>
                                    <input type="text" name="employer_address" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label>Number of Years in Present</label>
                                    <input type="number" name="years_in_present" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label>Type of Employer</label>
                                    <input type="text" name="employer_type" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label>Major Line of Business</label>
                                    <input type="text" name="major_line_of_business" class="form-control">
                                </div>
                            </div>

                            <div class="mb-3">
                                <button type="submit" name="save_alumni" class="btn btn-primary">Save Alumni</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const colleges = {
            'CITCS': {
                'BSCS': ['CS4A', 'CS4B', 'CS4C', 'CS4D'],
                'BSIT': ['IT1', 'IT2', 'IT3', 'IT4'],
                'ACT': ['ACT1', 'ACT2', 'ACT3', 'ACT4'],
            }
        };

        document.getElementById('college').addEventListener('change', function() {
            const departmentSelect = document.getElementById('department');
            const sectionSelect = document.getElementById('section');

            const selectedCollege = this.value;

            departmentSelect.innerHTML = '<option value="">Select Department</option>';
            sectionSelect.innerHTML = '<option value="">Select Section</option>';

            if (selectedCollege) {
                Object.keys(colleges[selectedCollege]).forEach(department => {
                    const option = document.createElement('option');
                    option.value = department;
                    option.textContent = department;
                    departmentSelect.appendChild(option);
                });
            }
        });

        document.getElementById('department').addEventListener('change', function() {
            const sectionSelect = document.getElementById('section');
            const selectedCollege = document.getElementById('college').value;
            const selectedDepartment = this.value;

            sectionSelect.innerHTML = '<option value="">Select Section</option>';

            if (selectedCollege && selectedDepartment) {
                colleges[selectedCollege][selectedDepartment].forEach(section => {
                    const option = document.createElement('option');
                    option.value = section;
                    option.textContent = section;
                    sectionSelect.appendChild(option);
                });
            }
        });

        document.getElementById('working_status').addEventListener('change', function() {
            const employmentDetails = document.getElementById('employment_details');
            // Check the value of the selected option
            if (this.value === 'Employed') {
                employmentDetails.style.display = 'block'; // Show employment details if employed
            } else {
                employmentDetails.style.display = 'none'; // Hide otherwise
            }
        });

        // Call the function on page load to set the correct visibility
        document.addEventListener('DOMContentLoaded', (event) => {
            const workingStatus = document.querySelector('select[name="working_status"]').value;
            // Ensure the employment details are displayed correctly on page load
            document.getElementById('employment_details').style.display = (workingStatus === 'Employed') ? 'block' : 'none';
        });
    </script>

</body>

</html>
