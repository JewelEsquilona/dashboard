<?php
session_start();
require '../db/config.php';

if (isset($_GET['id'])) {
    $alumni_id = $_GET['id'];
    $stmt = $con->prepare("SELECT * FROM `2024-2025` WHERE Alumni_ID_Number = ?");
    $stmt->bind_param("s", $alumni_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $alumni = $result->fetch_assoc();
    } else {
        $_SESSION['message'] = "No record found!";
        header("Location: index.php");
        exit(0);
    }
} else {
    $_SESSION['message'] = "You can edit your Profile here";
    header("Location: index.php");
    exit(0);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../style/style.css">

    <title>Alumni Edit</title>
    <script>
        function toggleEmployerFields() {
            const workingStatus = document.querySelector('select[name="working_status"]').value;
            const employerFields = document.getElementById('employer-fields');
            employerFields.style.display = (workingStatus === 'Employed') ? 'block' : 'none';
        }

        // Call toggleEmployerFields on page load to set initial visibility
        window.onload = function() {
            toggleEmployerFields();
        }
    </script>
</head>

<body>

    <div class="container mt-5">

        <?php include('message.php'); ?>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Alumni Edit
                            <a href="index.php" class="btn btn-danger float-end">BACK</a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <form action="alumni-submit.php" method="POST">

                            <input type="hidden" name="alumni_id" value="<?= htmlspecialchars($alumni['Alumni_ID_Number']); ?>">

                            <div class="mb-3">
                                <label>Student Number</label>
                                <input type="text" name="student_number" class="form-control" value="<?= htmlspecialchars($alumni['Student_Number']); ?>" required>
                            </div>
                            <div class="mb-3">
                                <label>Last Name</label>
                                <input type="text" name="last_name" class="form-control" value="<?= htmlspecialchars($alumni['Last_Name']); ?>" required>
                            </div>
                            <div class="mb-3">
                                <label>First Name</label>
                                <input type="text" name="first_name" class="form-control" value="<?= htmlspecialchars($alumni['First_Name']); ?>" required>
                            </div>
                            <div class="mb-3">
                                <label>Middle Name</label>
                                <input type="text" name="middle_name" class="form-control" value="<?= htmlspecialchars($alumni['Middle_Name']); ?>">
                            </div>
                            <div class="mb-3">
                                <label>College</label>
                                <select name="college" class="form-control" required>
                                    <option value="" disabled>Select College</option>
                                    <option value="CITCS" <?= isset($alumni['College']) && $alumni['College'] === 'CITCS' ? 'selected' : ''; ?>>CITCS</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label>Department</label>
                                <select name="department" class="form-control" required>
                                    <option value="" disabled>Select Department</option>
                                    <option value="BSCS" <?= isset($alumni['Department']) && $alumni['Department'] === 'BSCS' ? 'selected' : ''; ?>>BSCS</option>
                                    <option value="BSIT" <?= isset($alumni['Department']) && $alumni['Department'] === 'BSIT' ? 'selected' : ''; ?>>BSIT</option>
                                    <option value="ACT" <?= isset($alumni['Department']) && $alumni['Department'] === 'ACT' ? 'selected' : ''; ?>>ACT</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label>Section</label>
                                <select name="section" class="form-control" required>
                                    <option value="" disabled>Select Section</option>
                                    <option value="CS4A" <?= isset($alumni['Section']) && $alumni['Section'] === 'CS4A' ? 'selected' : ''; ?>>CS4A</option>
                                    <option value="CS4B" <?= isset($alumni['Section']) && $alumni['Section'] === 'CS4B' ? 'selected' : ''; ?>>CS4B</option>
                                    <option value="CS4C" <?= isset($alumni['Section']) && $alumni['Section'] === 'CS4C' ? 'selected' : ''; ?>>CS4C</option>
                                    <option value="CS4D" <?= isset($alumni['Section']) && $alumni['Section'] === 'CS4D' ? 'selected' : ''; ?>>CS4D</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label>Year Graduated</label>
                                <input type="number" name="year_graduated" class="form-control" value="<?= htmlspecialchars($alumni['Year_Graduated']); ?>" required>
                            </div>
                            <div class="mb-3">
                                <label>Contact Number</label>
                                <input type="text" name="contact_number" class="form-control" value="<?= htmlspecialchars($alumni['Contact_Number']); ?>" required>
                            </div>
                            <div class="mb-3">
                                <label>Personal Email</label>
                                <input type="email" name="personal_email" class="form-control" value="<?= htmlspecialchars($alumni['Personal_Email']); ?>" required>
                            </div>
                            <div class="mb-3">
                                <label>Working Status</label>
                                <select name="working_status" class="form-control" onchange="toggleEmployerFields()" required>
                                    <option value="Employed" <?= (isset($alumni['Working_Status']) && $alumni['Working_Status'] === 'Employed') ? 'selected' : ''; ?>>Employed</option>
                                    <option value="Unemployed" <?= (isset($alumni['Working_Status']) && $alumni['Working_Status'] === 'Unemployed') ? 'selected' : ''; ?>>Unemployed</option>
                                    <option value="Self-employed" <?= (isset($alumni['Working_Status']) && $alumni['Working_Status'] === 'Self-employed') ? 'selected' : ''; ?>>Self-employed</option>
                                </select>
                            </div>

                            <!-- Employer Fields -->
                            <div id="employer-fields" style="display: <?= (isset($alumni['Working_Status']) && $alumni['Working_Status'] === 'Employed') ? 'block' : 'none'; ?>;">
                                <div class="mb-3">
                                    <label>Present Occupation</label>
                                    <input type="text" name="present_occupation" class="form-control" value="<?= isset($alumni['Present_Occupation']) ? htmlspecialchars($alumni['Present_Occupation']) : ''; ?>">
                                </div>
                                <div class="mb-3">
                                    <label>Name of Employer</label>
                                    <input type="text" name="name_of_employer" class="form-control" value="<?= isset($alumni['Name_of_Employer']) ? htmlspecialchars($alumni['Name_of_Employer']) : ''; ?>">
                                </div>
                                <div class="mb-3">
                                    <label>Address of Employer</label>
                                    <input type="text" name="address_of_employer" class="form-control" value="<?= isset($alumni['Address_of_Employer']) ? htmlspecialchars($alumni['Address_of_Employer']) : ''; ?>">
                                </div>
                                <div class="mb-3">
                                    <label>Number of Years in Present Employer</label>
                                    <input type="number" name="number_of_years_in_present_employer" class="form-control" value="<?= isset($alumni['Number_of_Years_in_Present_Employer']) ? htmlspecialchars($alumni['Number_of_Years_in_Present_Employer']) : ''; ?>">
                                </div>
                                <div class="mb-3">
                                    <label>Type of Employer</label>
                                    <input type="text" name="type_of_employer" class="form-control" value="<?= isset($alumni['Type_of_Employer']) ? htmlspecialchars($alumni['Type_of_Employer']) : ''; ?>">
                                </div>
                                <div class="mb-3">
                                    <label>Major Line of Business</label>
                                    <input type="text" name="major_line_of_business" class="form-control" value="<?= isset($alumni['Major_Line_of_Business']) ? htmlspecialchars($alumni['Major_Line_of_Business']) : ''; ?>">
                                </div>
                            </div>

                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary">Update Alumni</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
</body>

</html>
